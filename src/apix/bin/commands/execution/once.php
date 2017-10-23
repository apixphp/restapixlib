<?php

namespace Src\App\__projectName__\Kernel\Once;

use Src\App\__projectName__\V1\ServiceAnnotationsController;
use Src\App\__projectName__\V1\ServiceBaseController as Base;

class __class__ extends Base {

    //set annotations trait
    use ServiceAnnotationsController;

    /**
     * Represents a once method.
     * @method scriptBoot
     * return mixed
     */
    public function scriptBoot(){

        //make somethings
    }


    /**
     * Represents a once method.
     * @method commandBoot
     * return array
     */
    public function commandBoot(){

        //write php api command
        return [];
    }



}