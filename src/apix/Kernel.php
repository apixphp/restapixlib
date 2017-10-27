<?php
namespace Apix;

use Monolog\Logger;
use Monolog\Handler\StreamHandler as StreamHandler;

class Kernel {

    /**
     * @var $container
     */
    public $container;

    /**
     * @var $resolve
     */
    public $resolve;

    /**
     * @var $_instance
     */
    public static $_instance=null;

    /**
     * @var $globalVars
     */
    public static $globalVars=null;

    /**
     * @var $service
     */
    public static $service=null;

    /**
     * @var $serviceMethod
     */
    public static $serviceMethod=null;

    /**
     * @var $queryParams
     */
    public static $queryParams=null;

    /**
     * @var $getVersion
     */
    public static $getVersion=null;

    /**
     * @param $app \Apix\Connection
     */
    public function booting($app){

        /**
         * @var $app \Apix\Connection
         */
        $app=$app::getInstance();

        $app->checkForMaintenance($app);
        $app->bootStrap();
        $app->getDeclarationApi();
    }
}