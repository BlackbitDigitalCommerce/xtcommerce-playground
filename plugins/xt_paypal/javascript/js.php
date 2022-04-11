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
 
if(constant('XT_PAYPAL_EXPRESS') == 1 && $_SESSION['paypalExpressCheckout']==true && $page->page_action!='success' && $page->page_action!='process'){
 
 ?>
<script type="text/javascript"><!--
<?php 

echo "
document.addEventListener('DOMContentLoaded', function(event)
{
	var error_message_agb;
	var error_message_res;
	var error_message;

	$('#buttonConfirm').click(function() {
		$('.checkPPExpressError').removeClass('checkPPExpressError');

   $('#rescission_accepted_paypal, #conditions_accepted_paypal').not(':checked').parent().addClass('checkPPExpressError');   

   	if($('.checkPPExpressError #conditions_accepted_paypal').length !== 0){
		error_message_agb = '".ERROR_CONDITIONS_ACCEPTED." \\n \\n';
	}else{
		error_message_agb = '';
	}

   	if($('.checkPPExpressError #rescission_accepted_paypal').length !== 0){
		error_message_res = '".ERROR_RESCISSION_ACCEPTED." \\n \\n';
	}else{
		error_message_res = '';
	}
	
	if(error_message_agb!='' || error_message_res!=''){
	
		error_message = '';
		
		if(error_message_agb!='')
			error_message = error_message + error_message_agb;
			
		if(error_message_res!='')
			error_message = error_message + error_message_res;
	
		alert(error_message);
	}

   if ($('.checkPPExpressError').length !== 0)
   	      	return false;
	  return true;
	});

});
";
?>
//-->
</script>

<?php  } ?>