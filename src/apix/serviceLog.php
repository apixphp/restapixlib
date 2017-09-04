<?php
/**
 * Service log controller
 * it is mainly service logging for service
 * service logging
 */
namespace apix;
use Apix\Utils;
use Apix\StaticPathModel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler as StreamHandler;

class serviceLog {

    public $logger;
    public $loggerType;
    public $loggerTypes=['access'=>'INFO','error'=>'ERROR'];

    /**
     *
     */
    public function register($errorType,$errorFileName){

        $this->logger=new Logger('log');
        $this->loggerType=$this->loggerTypes[$errorType];
        $this->logger->pushHandler(new StreamHandler($this->logPath.''.$errorFileName.'.log', Logger::INFO));
    }

    /**
     * handle.
     *
     * data client responses
     * @return mixed
     */
    public function setLogger($data,$logInstance)
    {
        //logging data
        $loggerType=$logInstance->loggerType;
        return $logInstance->logger->$loggerType($data);
    }

}