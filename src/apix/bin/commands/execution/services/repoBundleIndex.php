<?php

namespace Src\App\__projectName__\__version__\Optional\Repository\__bundleName__;

use Src\App\__projectName__\__version__\ServiceAnnotationsController;
use Src\App\__projectName__\__version__\serviceBaseController as Base;

class Index extends Base implements __bundleName__Interface {

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
     * for repository service
     * handle method is auto run.
     * @return mixed
     */
    public function get()
    {
        //return source
        return ["__projectName__ repository __bundleName__"];
    }

}
