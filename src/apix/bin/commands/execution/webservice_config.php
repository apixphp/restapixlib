<?php

namespace Src\App\__projectName__\V1\Optional\WebServices;

/**
 * Represents a config class.
 *
 * main call
 * return type array
 */

class Config
{

    /**
     * @param $urlPrefix
     * @param array group key=>value
     * @return mixed
     */
    public $urlPrefix=null;

    /**
     * @param $endPoints
     * @return array
     */
    public $endPoints=[

        //'xml'=>'stk/xml'
    ];

    /**
     * @method setUrlGetQuery
     * it is automatically injected on get query
     * @return array
     */
    public function setUrlGetQuery(){
        return [];
    }

    /**
     * @method setHeaders
     * it is automatically injected to headers sent
     * @return array
     */
    public function setHeaders(){
        return [];
    }

}
