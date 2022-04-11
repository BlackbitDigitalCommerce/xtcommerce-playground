<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

if (XT_PAYPAL_PLUS_SHOW_INSTALLMENTS_CALCULATOR == 1)
{
    $payment = new payment();

    $payment->_payment();
    $data_array = $payment->_getPossiblePayment();

    $PP_enabled = false;
    foreach ($data_array as $k => $v) {
        if ($v['payment_code'] == 'xt_paypal') {
            $PP_enabled = true;
            break;
        }
    }
    $PPP_enabled = defined('_XT_PAYPAL_PLUS_ENABLED') && _XT_PAYPAL_PLUS_ENABLED == 1;

    if($PP_enabled || $PPP_enabled)
    {
        $template4 = new Template();
        $tpl = 'paypal_plus_calculator.html';
        $template4->getTemplatePath($tpl, 'xt_paypal_plus', '', 'plugin');
        $tpl_data = [
            'products_price_plain' => round($_SESSION['cart']->content_total['plain'],2)
        ];
        $tmp_data = $template4->getTemplate('smarty_xt_paypal_plus', $tpl, $tpl_data);

        echo $tmp_data;
    }
}
