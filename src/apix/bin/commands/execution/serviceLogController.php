<?php
/**
 * Service log controller
 * it is mainly service logging for service
 * service logging
 */

namespace src\app\mobi\v1;

use Src\Store\Services\Httprequest as Request;
use Apix\Utils;
use Apix\StaticPathModel;
use Apix\serviceLog as LogProvider;

class serviceLogController extends LogProvider
{
    /**
     * @var null|string
     */
    public $logPath=null;

    /**
     * Constructor.
     * @param $errorType
     * @param $errorFileName
     */
    public function __construct($errorType='access',$errorFileName='access')
    {
        //get log path and register
        $this->logPath=staticPathModel::getProjectPath(app).'/storage/logs/';
        $this->register($errorType,$errorFileName);

    }

    /**
     * handle.
     * @param $data array
     * @return mixed
     */
    public function handle($data=array())
    {
        return $this->setLogger(json_encode($data),$this);
    }



}
