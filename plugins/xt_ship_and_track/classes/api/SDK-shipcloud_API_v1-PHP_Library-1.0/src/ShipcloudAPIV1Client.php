<?php
/*
 * ShipcloudAPIV1Lib
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace ShipcloudAPIV1Lib;

use ShipcloudAPIV1Lib\Controllers;

/**
 * ShipcloudAPIV1Lib client class
 */
class ShipcloudAPIV1Client
{
 
    /**
     * Singleton access to API controller
     * @return Controllers\APIController The *Singleton* instance
     */
    public function getClient()
    {
        return Controllers\APIController::getInstance();
    }
}