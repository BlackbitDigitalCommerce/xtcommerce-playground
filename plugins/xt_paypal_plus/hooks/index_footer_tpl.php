<?php
defined('_VALID_CALL') or die('Direct Access is not allowed.');
global $db,$xtLink,$language, $currency_code, $currency;

if (isset($xtPlugin->active_modules['xt_paypal_plus']) && isset($_REQUEST['ppp_available_data']))
{
	$template4 = new Template();
	$tpl = 'paypal_plus_footer.html';
	$template4->getTemplatePath($tpl, 'xt_paypal_plus', '', 'plugin');
	$tmp_data = $template4->getTemplate('smarty_xt_paypal_plus', $tpl, $_REQUEST['ppp_available_data']);

	echo $tmp_data;

	$css_local_path = '/' . _SRV_WEB_PLUGINS. 'xt_paypal_plus/css/xt_paypal_plus.css';
    $css_file = _SRV_WEBROOT . _SRV_WEB_TEMPLATES . _STORE_TEMPLATE . $css_local_path;
	if(!file_exists($css_file))
        $css_file = _SRV_WEBROOT . _SRV_WEB_TEMPLATES . _SYSTEM_TEMPLATE . $css_local_path;
    if(!file_exists($css_file))
        $css_file = _SRV_WEBROOT  . $css_local_path;
	$css = file_get_contents($css_file);
	echo "<style>".PHP_EOL.$css.PHP_EOL."</style>";
}


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
        $tpl = 'paypal_plus_sdk.html';
        $template4->getTemplatePath($tpl, 'xt_paypal_plus', '', 'plugin');
        $tpl_data = [
            'client_id' => XT_PAYPAL_PLUS_MODE == 'live' ? XT_PAYPAL_PLUS_CLIENT_ID : XT_PAYPAL_PLUS_SANDBOX_CLIENT_ID,
            'currency' => $currency->code
        ];
        $tmp_data = $template4->getTemplate('smarty_xt_paypal_plus', $tpl, $tpl_data);

        echo $tmp_data;
    }
}
