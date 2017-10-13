<?php

namespace Src\App\__projectName__\__version__\Optional\Repository\__bundleName__\Src\__srcName__;

use Src\App\__projectName__\__version__\ServiceAnnotationsController;
use Src\App\__projectName__\__version__\serviceBaseController as Base;


class __className__ extends Base {

    //set annotations trait
    use ServiceAnnotationsController;

    /**
     * Constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->branchInitialize();
    }

    /**
     * for repository src service
     * get method is main run.
     * @return mixed
     */
    public function get(){

        //return source
        return ["__projectName__ repository __bundleName__ __srcName__"];
    }
}
