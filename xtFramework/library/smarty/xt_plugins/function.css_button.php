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

/**
 * Generate css button.
 * 
 * $param may contain the following keys:
 * - text: string button text
 * - type:  form|string type of button
 * - class: string class for button where type!="form"
 * - id: for button where type!="form"
 * - name: for button where type!="form"
 * - style: for button where type!="form"
 * 
 * @global type $template
 * @global type $form
 * @global type $language
 * @param array $params
 * @param type $smarty
 * @return string
 * @version 1.0.1 - add alt to all images 
 */
function smarty_function_css_button($params, & $smarty) {
    global $template, $form, $language;

    
    if ($params['type'] == 'form') {
        // draw submit button
        
        $attributes = '';
        
        if (!empty($params['class'])) {
            $attributes .= ' class="' . $params['class'] . '"';
        }
        
        echo '<input type="submit" '.$attributes.' title="'.$params['text'].'" value="'.$params['text'].'" />';
        
    } else {
    	
    	$attributes = '';

        if (!empty($params['class'])) {
            $attributes .= ' class="' . $params['class'] . '"';
        } else {
        	 $attributes .= ' class="button"';
        }

    	if (!empty($params['id'])) {
            $attributes .= ' id="' . $params['id'] . '"';
        } 
    	if (!empty($params['style'])) {
            $attributes .= ' style="' . $params['style'] . '"';
        } 
        if (!empty($params['name'])) {
            $attributes .= ' name="' . $params['name'] . '"';
        } 		
		
        // generate normal span tag
        return '<span '.$attributes.' title="'.$params['text'].'">'.$params['text'].'</span>';

    }

    return;
}

?>