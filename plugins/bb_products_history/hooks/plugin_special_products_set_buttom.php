<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

if ($set_type == 'edit') {
    $ms_data = [
        'xt_products_price_special_id' => $data['id'],
        'specials_price' => $data['specials_price'],
    ];
    $db->AutoExecute('xt_plg_products_price_special_history', $ms_data);
}