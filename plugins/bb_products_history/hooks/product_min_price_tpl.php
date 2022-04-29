<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

global $db, $price;

if ($params['has_specials'] == true) {
    $price_min = $db->GetOne(
        "
        SELECT MIN(min_price) FROM (
            SELECT MIN(products_price)  min_price
                FROM xt_plg_products_history
                WHERE products_id = ? AND
                created_at BETWEEN now() - INTERVAL ? DAY AND now()
            UNION 
            SELECT MIN(xp.specials_price) min_price
                FROM xt_plg_products_price_special_history xp
                INNER JOIN (
                    select * from
                    xt_products_price_special
                    where
                        ((now() - ?) <= date_expired AND now() >= date_available)
                    ) xt ON xt.id = xp.xt_products_price_special_id 
                WHERE xt.products_id = ? 
        ) t 
            ",
        [
            $params['pid'], XT_PRODUCTS_HISTORY_MIN_PRICE_PERIOD_DAYS,
             XT_PRODUCTS_HISTORY_MIN_PRICE_PERIOD_DAYS, $params['pid']
        ]
    );

    if ($price_min && $params['pprice'] && $params['pprice']['original_price_otax'] > $price_min) {
        $price_with_tax = (float)$price_min + (float)$params['ptax'];
        $price_with_tax = $price->_StyleFormat(abs($price_with_tax));
        echo TEXT_PRODUCTS_HISTORY . " ". $price_with_tax;
    }
}
