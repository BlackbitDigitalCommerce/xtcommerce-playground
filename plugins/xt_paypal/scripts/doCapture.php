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


include '../../../xtFramework/admin/main.php';

if (!$xtc_acl->isLoggedIn()) {
    die('action requires login');
}

$orders_id = (int)$_GET['order_id'];


$query = "SELECT * FROM ".TABLE_ORDERS." WHERE orders_id='".$orders_id."'";
$rs = $db->GetRow($query);


if (count($rs)>0) {
    include ('../../../plugins/xt_paypal/classes/class.paypal.php');
    $paypal = new paypal();
    $success = $paypal->doCaptureRequest($orders_id);

    if ($success=='true') {
        echo TEXT_PAYPAL_CAPTURE_SUCCESS;
    } else {
        echo TEXT_PAYPAL_CAPTURE_ERROR.' '.$success;
    }
} else {
    echo TEXT_PAYPAL_CAPTURE_ERROR;
}
?>