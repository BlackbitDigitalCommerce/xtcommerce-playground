<?php
/*
 #########################################################################
 #                       xt:Commerce Shopsoftware
 # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 #
 # Copyright 2021 xt:Commerce GmbH All Rights Reserved.
 # This file may not be redistributed in whole or significant part.
 # Content of this file is Protected By International Copyright Laws.
 #
 # ~~~~~~ xt:Commerce Shopsoftware IS NOT FREE SOFTWARE ~~~~~~~
 #
 # https://www.xt-commerce.com
 #
 # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 #
 # @copyright xt:Commerce GmbH, www.xt-commerce.com
 #
 # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 #
 # xt:Commerce GmbH, Maximilianstrasse 9, 6020 Innsbruck
 #
 # office@xt-commerce.com
 #
 #########################################################################
 */

use GuzzleHttp\Cookie\SetCookie;

defined('_VALID_CALL') or die('Direct Access is not allowed.');

class google_analytics {

	protected $price_without_tax = XT_GOOGLE_ANALYTICS_NET_PRICES;

    const INIT_FNC_NAME = 'googleAnalyticsInit';


	function _getCode() {
		global $xtPlugin;

		($plugin_code = $xtPlugin->PluginCode('class.xt_googleanalytics.php:_getCode')) ? eval($plugin_code) : false;

        $ci = new CookieInfo(CookieType::ANALYTICS, 'Google', null,
            'Google Analytics', 'https://traffic3.net/wissen/datenschutz/google-cookies#s41');
		$names =
            ['_ga', '_gid', '_gat', 'IDE',
            '_dc_gtm_'  .constant('XT_GOOGLE_ANALYTICS_UA'),
            '_gat_gtag_'.constant('XT_GOOGLE_ANALYTICS_UA'),
            '_gac_'     .constant('XT_GOOGLE_ANALYTICS_UA')
            ];
		foreach ($names as $name)
        {
            $ci->addCookie(new SetCookie(['Name' => $name]));
        }

		CookieRegistry::registerCookieScript($ci);

		// respect Do not Track setting in Browser
		if ((isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1) && constant('XT_GOOGLE_ANALYTICS_DO_NOT_TRACK') =='0')
        {
            return '<!-- GA disabled by browsers HTTP_DNT settings -->';
		}

        if (CookieRegistry::getCookieAllowed(CookieType::ANALYTICS) === false)
        {
            //return '<!-- GA disabled by  CookieType::ANALYTICS = false -->';
            // wir müssen den js code erzeuegen und die initfunktion bei akzeptieren rufen
        }

        CookieRegistry::registerInitFunction(self::INIT_FNC_NAME);

		if (XT_GOOGLE_ANALYTICS_UA!='') {
			if ($_GET['page']=='checkout' && $_GET['page_action']=='success') {
				if (XT_GOOGLE_ANALYTICS_ECOM=='1') {
					global $success_order;
					return $this->_getEcommerceCode();
				} else {
                    return $this->_getStandardCode();
				}

			} else {
                return $this->_getStandardCode();
			}
		}

	}

    function _getGtagCode()
    {
        return '<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id='.XT_GOOGLE_ANALYTICS_UA.'"></script>';
    }

	function _getStandardCode($wrapped = true)
    {
		$js ='
  console.log("executing GA standard code");
  window.dataLayer = window.dataLayer || [];
  function gtag(){window.dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "'.XT_GOOGLE_ANALYTICS_UA.'");';


		if (XT_GOOGLE_ANALYTICS_ANON=='1') {
			$js .= "gtag('config', '".XT_GOOGLE_ANALYTICS_UA."', { 'anonymize_ip': true });";
		}

        if($wrapped)
            $js = '<script>
function '.self::INIT_FNC_NAME.'() {
'.$js."
}
</script>
";
		return $js;
	}


	function _getEcommerceCode($wrapped = true) {
		global $success_order;

		$js = $this->_getStandardCode(false);

		$tax = $success_order->order_total['total']['plain']-$success_order->order_total['total_otax']['plain'];


		$data_layer = [];


		$data_layer['transaction_id']=$success_order->order_data['orders_id'];
		$data_layer['affiliation']=XT_GOOGLE_ANALYTICS_AFFILIATION;

		$data_layer['value']=($this->price_without_tax == 'false' ? round($success_order->order_total['total']['plain'],2) : round($success_order->order_total['total_otax']['plain'],2));
		$tax = $success_order->order_total['total']['plain']-$success_order->order_total['total_otax']['plain'];
		if ($this->price_without_tax == 'true') $tax=0;
		$data_layer['tax']=round($tax);
		$data_layer['shipping']=($this->price_without_tax == 'false' ? round($success_order->order_total['data_total']['plain'],2) : round($success_order->order_total['data_total_otax']['plain'],2));


		$data_layer['currency']=$success_order->order_data['currency_code'];


		foreach ($success_order->order_products as $key => $product) {

			$item = new xt_ga_item();

			$item->set_name($product['products_name']);
			$item->set_id($product['products_id']);
			$item->set_price(($this->price_without_tax == 'false' ? round($product['products_price']['plain'],2) : round($product['products_price']['plain_otax'],2)));
			$item->set_brand(self::_getItemManufacturer('',$product['products_id']));
			$item->set_quantity($product['products_quantity']);

			$cat = $this->_getCategoryTree($product['products_id']);
			$item->set_category($cat);


			$data_layer['items'][]=$item->getItemDataLayerArray();

		}

		$js .='
		console.log("executing GA ecommerce code")
		gtag("event", "purchase", '.json_encode($data_layer).');';

        if($wrapped)
            $js = '<script>
function '.self::INIT_FNC_NAME.'() {
'.$js."
}
</script>
";

		return $js;
	}


	private function _getCategoryTree($products_id) {
    global $db;

    $rs = $db->Execute(
        "SELECT categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE master_link=1 and products_id=? and store_id = ?",
        array($products_id,'1')
    );

    if ($rs->RecordCount() >= 1) {
      $tree = $this->buildCAT($rs->fields['categories_id']);
      $tree = substr($tree, 0, -1);
      return $tree;
    }
    return false;



  }

  /**
   * get Category tree
   *
   * @param mixed $catID
   * @return mixed
   */
  function buildCAT ($catID)
  {
      if (isset($this->CAT[$catID])) {
          return $this->CAT[$catID];
      } else {
          $cat = array();
          $tmpID = $catID;

          while ($this->_getParent($catID) != 0 || $catID != 0) {
              $cat[] = $this->getCategory($catID);
              $catID = $this->_getParent($catID);
          }

          $catStr = '';

          for ($i = count($cat); $i > 0; $i--) {
              $catStr .= $cat[$i - 1] . '/';
          }

          $this->CAT[$tmpID] = $catStr;

          return $this->CAT[$tmpID];
      }
  }

  function _getParent ($catID)
  {
      global $db, $xtPlugin;


      if (isset($this->PARENT[$catID])) {
          return $this->PARENT[$catID];
      } else {
          $rs = $db->Execute("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE categories_id=?", array($catID));
          $this->PARENT[$catID] = $rs->fields['parent_id'];

          return $rs->fields['parent_id'];
      }
  }

  function getCategory ($catID)
  {
      global $db, $xtPlugin,$language;


      if (isset($this->_CAT[$catID])) return $this->_CAT[$catID];

      $rs = $db->Execute(
          "SELECT categories_name FROM " . TABLE_CATEGORIES_DESCRIPTION . " WHERE categories_id=? and language_code=? AND categories_store_id=?",
          array($catID, $language->code, '1')
      );

      if ($rs->RecordCount() == 1) {
          $this->_CAT[$catID] = $rs->fields['categories_name'];


          return $this->_CAT[$catID];
      }
  }
	/**
	 * get manufacturers name
	 * @param  [type] $manufacturers_id [description]
	 * @return [type]                   [description]
	 */
	private function _getItemManufacturer($manufacturers_id='',$products_id='') {
		global $db;

		if ($manufacturers_id=='') {
			return $db->GetOne("SELECT m.manufacturers_name FROM ".TABLE_MANUFACTURERS." m, ".TABLE_PRODUCTS." p WHERE p.products_id=? AND p.manufacturers_id=m.manufacturers_id",array($products_id));
		}

		return $db->GetOne("SELECT manufacturers_name FROM ".TABLE_MANUFACTURERS." WHERE manufacturers_id=?",array($manufacturers_id));
	}
}
