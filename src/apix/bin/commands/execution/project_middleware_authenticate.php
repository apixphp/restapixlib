<?php

namespace Src\App\__projectName__\Kernel\Middleware;

use Src\App\__projectName__\V1\ServiceAnnotationsController;
use Src\App\__projectName__\V1\ServiceBaseController as Base;


class Authenticate extends Base  {

    //set annotations trait
    use ServiceAnnotationsController;

    /**
     * Represents a middleware method.
     * default method
     * return mixed
     */
    public function handle(){

        //if auth persistent is false
        if(auth()->persistent()===false){

            //exception show
            throw new \DomainException('Auth permission error');
        }
    }
}