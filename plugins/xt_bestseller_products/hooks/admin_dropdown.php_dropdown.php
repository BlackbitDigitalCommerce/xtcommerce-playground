<?php

// ADMIN: config for search mode

defined('_VALID_CALL') or die('Direct Access is not allowed.');

if ($request['get'] == 'plg_xt_bestseller_products_show_type') {
	if (!isset($result)) $result = array();
	$result[] = array('id' => 'master', 'name' => XT_BESTSELLER_PRODUCTS_MASTER, 'desc' => XT_BESTSELLER_PRODUCTS_MASTER);
	$result[] = array('id' => 'slave', 'name' => XT_BESTSELLER_PRODUCTS_SLAVE, 'desc' => XT_BESTSELLER_PRODUCTS_SLAVE);
	$result[] = array('id' => 'nothing', 'name' => XT_BESTSELLER_PRODUCTS_NOTHING, 'desc' => XT_BESTSELLER_PRODUCTS_NOTHING);
}
