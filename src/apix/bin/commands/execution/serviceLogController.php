<?php
/**
 * Service log controller
 * it is mainly service logging for service
 * service logging
 */

namespace src\app\__projectName__\v1;

use Src\Store\Services\Httprequest as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler as StreamHandler;
use Apix\Utils;
use Apix\StaticPathModel;

class serviceLogController
{
    public $logger;
    public $logPath=null;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct()
    {

        //get log component
        $this->logger=new logger('log');
        $this->logPath=staticPathModel::getProjectPath(app).'/storage/logs/access.log';
        $this->logger->pushHandler(new StreamHandler($this->logPath, Logger::INFO));
    }

    /**
     * handle.
     *
     * @param data client responses
     * @return bool
     */
    public function handle($data=array())
    {

        //logging data
        return $this->logger->info(json_encode($data));
    }
}
