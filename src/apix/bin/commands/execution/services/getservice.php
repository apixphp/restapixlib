<?php
/*
 * This file is main class of the  service named __serviceName__ on  __projectName__ project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\v1\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\v1\__call\__serviceName__\app
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;


/**
 * Class getService
 * @package src\app\__projectName__\v1\__call\__serviceName__
 */
class getService extends app
{

    /**
     * Production forbidden.
     *
     * @if it is true,you can't access on the production
     * @restrictions method is comprenhensive on app class
     */
    public $forbidden=false;


    /**
     * Construct Load
     */
    public function __construct()
    {
        //get app extends
        parent::__construct();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        return [
            'environment'=>environment(),
            'isMobile'=>app("device")->isMobile()
        ];
    }
}
