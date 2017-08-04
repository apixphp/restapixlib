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
 * Represents a connector class.
 *
 * main call
 * return type array
 */

class connector extends config
{

    /**
     * @param null $key
     * @return array
     */
    public function endPoints($key=null,$group=null){

        return $this->resultPoints($key,$group,$this->endPoints);


    }

    /**
     * @param $key
     * @param $group
     * @param $endPoints
     * @return mixed
     */
    private function resultPoints($key,$group,$endPoints){

        if($key!==null){

            if($group!==null){
                return $endPoints[$group][$key];
            }
            return $endPoints[$key];
        }

        if($group!==null){
            return $endPoints[$group];
        }

        return $endPoints;
    }
}
