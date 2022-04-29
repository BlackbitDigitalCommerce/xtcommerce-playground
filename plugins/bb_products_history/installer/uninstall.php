<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

global $db;

$db->Execute("DROP TABLE IF EXISTS " . DB_PREFIX . "_plg_products_history");
$db->Execute("DROP TABLE IF EXISTS " . DB_PREFIX . "_plg_products_price_special_history");