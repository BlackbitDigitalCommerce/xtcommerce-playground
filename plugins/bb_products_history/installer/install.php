<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

global $db;

$sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . "_plg_products_history` (
  `id` int(11) NOT NULL auto_increment,
  `products_id` INT(11) NOT NULL,
  `products_price` DECIMAL(15,4) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `products_id` (`products_id`)
) ENGINE=" . DB_STORAGE_ENGINE . " DEFAULT CHARSET=utf8";

$db->Execute($sql);

$sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . "_plg_products_price_special_history` (
  `id` int(11) NOT NULL auto_increment,
  `xt_products_price_special_id` INT(11) NOT NULL,
  `specials_price` DECIMAL(15,4) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `xt_products_price_special_id` (`xt_products_price_special_id`)
) ENGINE=" . DB_STORAGE_ENGINE . " DEFAULT CHARSET=utf8";

$db->Execute($sql);