<?php

namespace Src\App\__projectName__\__version__\__Call\__serviceName__;

class __method__Service extends App implements __method__ServiceInterface
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
     * @return array
     */
    public function indexAction()
    {
        //return __method__ index
        return ['__method__'=>true];
    }
}
