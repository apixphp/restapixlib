<?php
/*
 * This file is main class of the  service named __serviceName__ on  __projectName__ project .
 * METHOD : PUT
 * every service is called with index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\v1\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\v1\__call\__serviceName__\app
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;

use Src\Store\Services\Httprequest as Request;
use Log;

/**
 * Represents a putService class.
 * http method : put
 * every method that on this service is called with put method as http method on browser
 * every service extends app class
 * attention:provision condition can be needed for put method
 * return type array
 */
class putService extends app
{
    public $forbidden=false;

    /**
     * Constructor.
     *
     * dependency injection and __serviceName__ class
     * main loader as construct method
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index method is main method.
     * produced json output as result
     * @return array
     */
    public function index()
    {

        //return index
        return ['put'=>true];
    }
}
