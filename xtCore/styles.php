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

if(file_exists(_SRV_WEBROOT._SRV_WEB_TEMPLATES._STORE_TEMPLATE.'/css/stylesheet.css'))
$xtMinify->add_resource(_SRV_WEB_TEMPLATES._STORE_TEMPLATE.'/css/stylesheet.css',50);
else
    $xtMinify->add_resource(_SRV_WEB_TEMPLATES._SYSTEM_TEMPLATE.'/css/stylesheet.css',50);

//TODO auto add script at this hook
($plugin_code = $xtPlugin->PluginCode('styles.php:top')) ? eval($plugin_code) : false;
// <link rel="stylesheet" type="text/css" href="<?php echo _SYSTEM_BASE_URL._SRV_WEB._SRV_WEB_TEMPLATES._STORE_TEMPLATE.'/css/stylesheet.css'; " />
($plugin_code = $xtPlugin->PluginCode('styles.php:bottom')) ? eval($plugin_code) : false;
?>