<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

if(constant('XT_GOOGLE_ANALYTICS_ACTIVATE') == '1')
{
    global $xtPlugin;
    require_once _SRV_WEBROOT . _SRV_WEB_PLUGINS . 'xt_googleanalytics/classes/class.xt_googleanalytics.php';
    require_once _SRV_WEBROOT . _SRV_WEB_PLUGINS . 'xt_googleanalytics/classes/class.xt_ga_item.php';

    $google_analytics = new google_analytics();
    $js = $google_analytics->_getGtagCode();
    echo $js;
    $js = $google_analytics->_getCode();
    echo $js;
    if(!array_key_exists('xt_cookie_consent', $xtPlugin->active_modules) || !defined('XT_COC_ACTIVATED') || constant('XT_COC_ACTIVATED') != '1')
    {
        echo '<script>document.addEventListener("DOMContentLoaded", function () { try { '.google_analytics::INIT_FNC_NAME.'(); } catch(e) { console.error(e) } } );</script>';
    }
}
