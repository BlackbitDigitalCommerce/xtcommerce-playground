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

// Buffer all upcoming output...
ob_start();

// Send your response.
echo "OK";

// Get the size of the output.
$size = ob_get_length();

// Disable compression (in case content length is compressed).
header("Content-Encoding: none");

// Set the content length of the response.
header("Content-Length: {$size}");

// Close the connection.
header("Connection: close");

// Flush all output.
ob_end_flush();
ob_flush();
flush();

include 'xtCore/main.php';

if(isset($_REQUEST['cron_id']) && _SYSTEM_SECURITY_KEY==$_GET['seckey'])
{
    $cron_id = (int) $_REQUEST['cron_id'];

    $xt_cron = new xt_cron();
    $xt_cron->cron_start_by_id($cron_id, true);
}

