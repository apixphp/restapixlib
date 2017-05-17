<?php
/*
 * This file is token provision of the every service.
 *
 * provision returns boolean value (true|false)
 * token provision
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1;

use src\store\Services\Httprequest as Request;

/**
 * Represents a provision class.
 *
 * main call
 * return type boolean
 */

class serviceTokenController {

    /**
     * Represents a token provision construct class.
     *
     * $data main variables
     * return type string
     */
    public function __construct(){}

    /**
     * token provision for get method.
     *
     * @return array
     */
    public function handle($environment=null){

        //status check
        //false status : access without token
        //tru status : access with token
        $status=($environment=="local") ? false : false;

        //token status false|true
        $token['status']=$status;

        //service tokens
        $token['tokens'][]='apix';

        //client ip tokens
        $token['clientIp']=[];
        //$token['clientIp']['apix']='192.168.33.1';

        return $token;
    }


    /**
     * dont run this services.
     *
     * @return array
     */
    public function Except(){

        //except routes
        $except=[];
        //$except[]=app.'/service/method?';

        //excepts client ip
        $except['clientIp']=[];
        //$except['clientIp']['192.168.33.1'][]=app.'/service/method?';

        return $except;
    }


}
