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

defined('_VALID_CALL') or die('Direct Access is not allowed.');

// Store
define('PAGE_INDEX', _SRV_WEB_PAGES.'index.php');
define('PAGE_LOGIN', _SRV_WEB_PAGES.'login.php');
define('PAGE_LOGOFF', _SRV_WEB_PAGES.'logoff.php');
define('PAGE_CATEGORIE', _SRV_WEB_PAGES.'categories.php');
define('PAGE_PRODUCT', _SRV_WEB_PAGES.'product.php');
define('PAGE_CONTENT', _SRV_WEB_PAGES.'content.php');
define('PAGE_CART', _SRV_WEB_PAGES.'cart.php');
define('PAGE_CUSTOMER', _SRV_WEB_PAGES.'customer.php');
define('PAGE_CHECKOUT', _SRV_WEB_PAGES.'checkout.php');
define('PAGE_MANUFACTURERS', _SRV_WEB_PAGES.'manufacturers.php');
define('PAGE_SEARCH', _SRV_WEB_PAGES.'search.php');
define('PAGE_CALLBACK', _SRV_WEB_PAGES.'callback.php');
define('PAGE_404', _SRV_WEB_PAGES.'404.php');

$store_handler->checkAdminSSL();

($plugin_code = $xtPlugin->PluginCode('page_registry.php:bottom')) ? eval($plugin_code) : false;
?>