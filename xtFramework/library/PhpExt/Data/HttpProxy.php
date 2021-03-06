<?php
/**
 * PHP-Ext Library
 * http://php-ext.googlecode.com
 * @author Sergei Walter <sergeiw[at]gmail[dot]com>
 * @copyright 2008 Sergei Walter
 * @license http://www.gnu.org/licenses/lgpl.html
 * @link http://php-ext.googlecode.com
 *
 * Reference for Ext JS: http://extjs.com
 *
 */

/**
 * @see PhpExt_Data_DataProxy
 */
include_once 'PhpExt/Data/DataProxy.php';

/**
 * An implementation of Ext.data.DataProxy that reads a data object from a Connection object configured to reference a certain URL.
 *
 * <b>Note that this class cannot be used to retrieve data from a domain other than the domain from which the running page was served.</b>
 *
 * <b>For cross-domain access to remote data, use a PhpExt_Data_ScriptTagProxy.</b>
 *
 * Be aware that to enable the browser to parse an XML document, the server must set the Content-Type header in the HTTP response to "text/xml".
 *
 * @see PhpExt_Data_ScriptTagProxy
 * @package PhpExt
 * @subpackage Data
 */
class PhpExt_Data_HttpProxy extends PhpExt_Data_DataProxy
{

    // Url
    /**
     * The URL from which to request the data object.
     * @param string $value
     * @return PhpExt_Data_ScriptTagProxy
     */
    public function setUrl($value) {
    	$this->setExtConfigProperty("url", $value);
    	return $this;
    }
    /**
     * The URL from which to request the data object.
     * @return string
     */
    public function getUrl() {
    	return $this->getExtConfigProperty("url");
    }


    // METHOD
    /**
     * The htttp method to use to request the data object.
     * @param string $value
     * @return PhpExt_Data_ScriptTagProxy
     */
    public function setMethod($value) {
        $this->setExtConfigProperty("method", $value);
        return $this;
    }
    /**
     * The htttp method to use to request the data object.
     */
    public function getMethod() {
        return $this->getExtConfigProperty("method");
    }


	public function __construct($url, $method = '') {
		parent::__construct();
		$this->setExtClassInfo("Ext.data.HttpProxy", null);

		$validProps = array(
		    "url", "method"
		);
		$this->addValidConfigProperties($validProps);

		$this->setUrl($url);
        if(!empty($method)) $this->setMethod($method);

	}


}

