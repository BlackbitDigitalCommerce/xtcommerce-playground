<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

$db->Execute(
    "DELETE FROM xt_plg_products_price_special_history 
       WHERE xt_products_price_special_id = ?",
    array($id)
);