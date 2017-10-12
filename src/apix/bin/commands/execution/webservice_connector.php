<?php

namespace Src\App\__projectName__\V1\Optional\WebServices;

use Src\Store\Services\Httprequest as Request;

class Connector extends Config
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
