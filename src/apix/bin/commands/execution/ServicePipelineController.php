<?php

namespace Src\App\__projectName__\V1;

use Src\App\__projectName__\V1\ServiceBaseController as Base;

class ServicePipelineController extends Base
{
    //set annotations trait
    use ServiceAnnotationsController;

    /**
     * @method pipeTest
     * @return array
     */
    public function pipeTest(){

        return [

            //list pipeline class
            ['namespace'    =>'method'],
            ['namespace2'   =>'method2']
        ];
    }
}
