<?php

namespace Src\App\__projectName__\Kernel\Middleware;

use Src\App\__projectName__\V1\ServiceAnnotationsController;
use Src\App\__projectName__\V1\ServiceBaseController as Base;


class Validator extends Base  {

    //set annotations trait
    use ServiceAnnotationsController;

    /**
     * Represents a middleware method.
     * default method
     * return mixed
     */
    public function handle(){

        //validator : page url
        $this->getUrlPageControl();
    }

    /**
     * get url page control.
     * it is page value on the url
     */
    public function getUrlPageControl(){

        //check page on the url
        if(isset($this->get['page'])){
            if(!is_numeric($this->get['page'])){
                throw new \InvalidArgumentException('page value on the url is not valid');
            }
        }
    }



}