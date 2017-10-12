<?php

namespace Src\App\__projectName__\__version__\__Call\__serviceName__;

class GetService extends App implements GetServiceInterface
{
    /**
     * Production forbidden.
     *
     * if it is true,you can't access on the production
     * restrictions method is comprehensive on app class
     */
    public $forbidden=false;

    /**
     * @method indexAction
     * @return mixed
     */
    public function indexAction()
    {
        return [
            'endpoint'=>'__serviceName__'
        ];
    }
}
