<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

if ($set_type == 'edit') {
    $ms_data = [
        'products_id' => $data['products_id'],
        'products_price' => $data['products_price'],
    ];
    $db->AutoExecute('xt_plg_products_history', $ms_data);
}