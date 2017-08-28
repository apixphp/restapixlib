<?php
/**
 * This file is main class of the  service named __serviceName__ on  __projectName__ project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\__version__\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\__version__\__call\__serviceName__\app
 */

namespace src\app\__projectName__\__version__\__call\__serviceName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;
use Log;


/**
 * @class getService
 * @package Src_App_Mobi_V1_Call_Stk
 */
class getService extends app implements getServiceInterface
{

    /**
     * Production forbidden.
     *
     * if it is true,you can't access on the production
     * restrictions method is comprehensive on app class
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
     * @return mixed
     */
    public function indexAction()
    {
        return $this->fingerPrint(true);
    }
}
