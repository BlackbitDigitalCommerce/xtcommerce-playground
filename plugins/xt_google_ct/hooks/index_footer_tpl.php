<?php

global $success_order;

if(is_object($success_order) && $_GET ['page'] == 'checkout' && $_GET ['page_action'] == 'success' && constant('XT_GCT_ACTIVATE') == '1')
{
    require_once _SRV_WEBROOT . 'plugins/xt_google_ct/classes/class.xt_google_ct.php';

    $gct = new xt_google_ct;
    $js = $gct->_getCode();
    echo $js;
}
