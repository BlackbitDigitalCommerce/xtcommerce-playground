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

defined('_VALID_CALL') or die('Direct Access is not allowed.');

global $info, $xtPlugin, $xtLink, $brotkrumen;
$reinsert = array();
$show_form = 'true';


if (is_array($_POST) && isset($_POST['action'])) {

	$reinsert = $_POST;

    if(defined('_CONTACT_LOG') && _CONTACT_LOG === true) contact_dataLog($reinsert);

	// check if logged in (captcha check)
	if(!isset($_SESSION['registered_customer']) || true) {
		$send_mail = true;
		switch (_STORE_CAPTCHA){
			
			case 'Standard':
				include _SRV_WEBROOT.'/xtFramework/library/captcha/php-captcha.inc.php';
				if (PhpCaptcha::Validate($_POST['captcha'])) {
					$send_mail = true;
				} else {
					$send_mail = false;
					$info->_addInfo(ERROR_CAPTCHA_INVALID);
				}
			break;
			
			case 'ReCaptcha':
				($plugin_code = $xtPlugin->PluginCode('forms:contact_captcha_validator')) ? eval($plugin_code) : false;
				break;
			default: $send_mail = true;	
		}
       
	} else {
		$send_mail = true;
	}
	
	$form_check = new check_fields();
	$form_check->_checkLenght($_POST['email_address'], _STORE_EMAIL_ADDRESS_MIN_LENGTH, ERROR_EMAIL_ADDRESS);
    $form_check->_checkEmailAddress($_POST['email_address'], ERROR_EMAIL_ADDRESS_SYNTAX);
	$form_check->_checkLenght($_POST['firstname'], _STORE_FIRST_NAME_MIN_LENGTH, ERROR_FIRST_NAME);
	$form_check->_checkLenght($_POST['lastname'], _STORE_LAST_NAME_MIN_LENGTH, ERROR_LAST_NAME);
	$form_check->_checkMatch($_POST['contact_opt_in'], '1', ERROR_CONTACT_FORM_OPTIN);
	
	($plugin_code = $xtPlugin->PluginCode('forms:contact_data_check')) ? eval($plugin_code) : false;
	
	if ($form_check->error==true) $send_mail=false;

	if ($send_mail) {
        $message = html_entity_decode ($_POST['customer_message']);
        
        //mail to customers
        $mail = new xtMailer('contact_mail');
		$mail->_addReceiver($_POST['email_address'], $_POST['firstname'].' '.$_POST['lastname']);
        $mail->_assign('customers_title',$_POST['title']);
		$mail->_assign('customers_firstname',$_POST['firstname']);
		$mail->_assign('customers_lastname',$_POST['lastname']);
        $mail->_assign('name',$_POST['firstname'].' '.$_POST['lastname']);
        $mail->_assign('company',$_POST['company']);
        $mail->_assign('telefone',$_POST['telefone']);
		$mail->_assign('mobile_phone',$_POST['mobile_phone']);
        $mail->_assign('order_no',$_POST['order_id']);
        $mail->_assign('mail',$_POST['email_address']);
		$mail->_assign('message',$message);
		$sent = $mail->_sendMail();

		if(!$sent)
        {
            $info->_addInfo(ERROR_EMAIL_SEND. ' (contact_mail_error_1)','error');
        }
        else
        {
            //mail to admin
            $mail_admin = new xtMailer('contact_mail-admin');
            $admin_email_address = !empty(_STORE_CONTACT_EMAIL) ? _STORE_CONTACT_EMAIL : _CORE_DEBUG_MAIL_ADDRESS;
            $mail_admin->_addReceiver($admin_email_address, _STORE_NAME);
            $title = $_POST['title'] ? $_POST['title'] . ' ' : '';
            $mail_admin->_addReplyAddress($_POST['email_address'], $title . $_POST['firstname'] . ' ' . $_POST['lastname']);
            $mail_admin->_assign('customers_title', $_POST['title']);
            $mail_admin->_assign('customers_firstname', $_POST['firstname']);
            $mail_admin->_assign('customers_lastname', $_POST['lastname']);
            $mail_admin->_assign('name', $_POST['firstname'] . ' ' . $_POST['lastname']);
            $mail_admin->_assign('company', $_POST['company']);
            $mail_admin->_assign('telefone', $_POST['telefone']);
            $mail_admin->_assign('mobile_phone', $_POST['mobile_phone']);
            $mail_admin->_assign('order_no', $_POST['order_id']);
            $mail_admin->_assign('mail', $_POST['email_address']);
            $mail_admin->_assign('message', $message);
            $sent = $mail_admin->_sendMail();
            if(!$sent)
            {
                $info->_addInfo(ERROR_EMAIL_SEND. ' (contact_mail_error_2)','error');
            }
            else {
                $info->_addInfo(SUCCESS_EMAIL_SEND,'success');
                $show_form = 'false';
            }
        }
	}
	/*
		xtFramework/classes/class.filter.php automatically replaces newline characters with <br>,
		and they appear back in the form when the validation fails, so we need to replace them
		back to newline chars.

	    not since 5.1
	*/
	elseif(isset($reinsert['customer_message']))
	{
		//$reinsert['customer_message'] = str_replace('<br>', "\n", $reinsert['customer_message']);
	}
}


$brotkrumen->_addItem($xtLink->_link(array('page'=>'content', 'params'=>'coID='.$shop_content_data['content_id'],'seo_url' => $shop_content_data['url_text'],'conn'=>'SSL')),$shop_content_data['title']);

// customer logged in ?
if(isset($_SESSION['registered_customer'])) {

    $title_data = customer::pageCustomerGetTitleTplData();

	$add_data = array('logged_in'=>'true',
        'title'=>$_SESSION['customer']->customer_default_address['customers_title'],
        'show_title' => _STORE_ACCOUNT_USE_TITLE,
        'title_data' => $title_data,
        'title' => $_SESSION['customer']->customer_default_address['customers_title'],
        'firstname'=>$_SESSION['customer']->customer_default_address['customers_firstname'],
        'lastname'=>$_SESSION['customer']->customer_default_address['customers_lastname'],
        'telefone'=>$_SESSION['customer']->customer_default_address['customers_phone'],
        'mobile_phone'=>$_SESSION['customer']->customer_default_address['customers_mobile_phone'],
        'company'=>$_SESSION['customer']->customer_default_address['customers_company'],
        'email_address'=>$_SESSION['customer']->customer_info['customers_email_address']);


} else {
	$add_data = array('logged_in'=>'false','show_title' => _STORE_ACCOUNT_USE_TITLE);
}

if(_STORE_CAPTCHA != 'Standard' && _STORE_CAPTCHA != 'ReCaptcha'){
    $add_data['logged_in'] = false;
} elseif( _STORE_CAPTCHA == 'ReCaptcha' && $xtPlugin->active_modules['xt_recaptcha']!=true){
	$add_data['logged_in'] = false;
    $add_data['recpatcha'] = true;
}
elseif( _STORE_CAPTCHA == 'ReCaptcha' && $xtPlugin->active_modules['xt_recaptcha']==true){
    $add_data['recaptcha'] = true;
}

$template = new Template();
$tpl_data = array('message'=>$info->info_content,
    'data'=>$shop_content_data,
    'subdata'=>!empty($subdata) ? $subdata : [],
    'captcha_link'=>$xtLink->_link(array('default_page'=>'captcha.php','conn'=>'SSL')),
    'show_form'=>$show_form);

($plugin_code = $xtPlugin->PluginCode('forms:contact_captcha_show')) ? eval($plugin_code) : false;

$tpl_data = array_merge($tpl_data,$add_data);
if (is_array($reinsert)) $tpl_data=array_merge($tpl_data,$reinsert);
$tpl = 'contact.html';
($plugin_code = $xtPlugin->PluginCode('module_content.php:tpl_data')) ? eval($plugin_code) : false;
$tpl_data['logged_in'] = false;
$page_data = $template->getTemplate('smarty', '/'._SRV_WEB_CORE.'forms/'.$tpl, $tpl_data);

function contact_dataLog($data)
{
    global $xtc_acl;
    if(empty($xtc_acl)) $xtc_acl = new acl();


    $f=fopen(_SRV_WEBROOT.'xtLogs/contact.log', 'a+');
    if($f)
    {
        $log_data['ip'] = $xtc_acl->getCurrentIp();
        $log_data['session'] = $_SESSION;
        unset($log_data['session']['cart']);
        $log_data['post'] = $data;
        fwrite($f, date('Y-m-d H:i:s') ."\n". print_r($log_data, true)."\n");
        fclose($f);
    }
}