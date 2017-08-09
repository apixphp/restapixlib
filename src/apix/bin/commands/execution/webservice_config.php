<?php
/*
 * This file is platform part of the __projectName__ service.
 *
 * every request can give reference to platform specified
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\optional\webServices;

use Src\Store\Services\Httprequest as Request;

/**
 * Represents a config class.
 *
 * main call
 * return type array
 */

class config
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
