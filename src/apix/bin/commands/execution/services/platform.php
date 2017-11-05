<?php

namespace Src\App\__projectName__\V1\Optional\Platform\__platformdir__\__serviceName__;

use Src\App\__projectName__\__version__\ServiceAnnotationsController;
use Src\App\__projectName__\__version__\serviceBaseController as Base;

class __platformfile__ extends Base
{

    //set annotations trait
    use ServiceAnnotationsController;


    /**
     * Constructor.
     *
     */
    public function __construct() {

        parent::__construct();
        $this->branchInitialize();
    }

    /**
     * index method is main method.
     * @return mixed
     */
    public function indexAction()
    {

        //return source
        return "__projectName__ source __serviceName__ platform __platformdir__ __platformfile__";
    }
}
