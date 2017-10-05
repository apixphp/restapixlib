<?php
/*
 * This file is main class of the  service named __serviceName__ on  __projectName__ project .
 * METHOD : __method__
 * every service is called with index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\__version__\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\__version__\__call\__serviceName__\app
 */

namespace src\app\__projectName__\__version__\__call\__serviceName__;

use Src\Store\Services\appCollection as Collection;
use Log;


/**
 * Class __method__Service
 * @package src\app\__projectName__\__version__\__call\__serviceName__
 */
class __method__Service extends app implements __method__ServiceInterface
{

    /**
     * Production forbidden.
     *
     * if it is true,you can't access on the production
     * restrictions method is comprehensive on app class
     */
    public $forbidden=false;


    /**
     * Construct load
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
        //return __method__ index
        return ['__method__'=>true];
    }
}
