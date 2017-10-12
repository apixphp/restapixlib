<?php

namespace Src\App\__projectName__\V1;

use Apix\StaticPathModel;
use Apix\logProvider;

class ServiceLogController extends LogProvider
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
