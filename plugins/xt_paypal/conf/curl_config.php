<?php
/*
 #########################################################################
 #                       xt:Commerce Shopsoftware
 # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 #
 # Copyright 2021 xt:Commerce GmbH All Rights Reserved.
 # This file may not be redistributed in whole or significant part.
 # Content of this file is Protected By International Copyright Laws.
 #
 # ~~~~~~ xt:Commerce Shopsoftware IS NOT FREE SOFTWARE ~~~~~~~
 #
 # https://www.xt-commerce.com
 #
 # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 #
 # @copyright xt:Commerce GmbH, www.xt-commerce.com
 #
 # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 #
 # xt:Commerce GmbH, Maximilianstrasse 9, 6020 Innsbruck
 #
 # office@xt-commerce.com
 #
 #########################################################################
 */

$curlVersion = curl_version();
$curlSslBackend = $curlVersion['ssl_version'];

$r = array(
    'SSL_LIB' => $curlSslBackend,
    'SSL_VERSION' => CURL_SSLVERSION_TLSv1_2
);

if (XT_PAYPAL_SSL_VERSION == 'autodetect')
{

    if (substr_compare($curlSslBackend, "NSS/", 0, strlen("NSS/")) === 0)
    {
        $r['CIPHER_LIST'] = "";
    }
    else
    {
        $r['CIPHER_LIST'] = "TLSv1";
    }
    return $r;
}
else
{
    return array(
        'SSL_LIB' => $curlSslBackend,
        'SSL_VERSION' => XT_PAYPAL_SSL_VERSION,
        'CIPHER_LIST' => (XT_PAYPAL_CIPHER_LIST == 'autodetect') ? '' : XT_PAYPAL_CIPHER_LIST,
    );
}
