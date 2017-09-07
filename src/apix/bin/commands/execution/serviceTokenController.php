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
 */

class serviceTokenController {

    /**
     * status variable
     */
    public $status=[];

    /**
     * Represents a token provision construct class.
     *
     * $data main variables
     * return array
     */
    public function __construct(){

        /**
         *  method maybe header or get
         * define 'key' is token for header
         */
        $this->status['method']='get';
        $this->status['local']=false;
        $this->status['production']=true;

    }

    /**
     * token provision for get method.
     * @param string $environment
     * @return array
     */
    public function handle($environment='local'){

        //token status false|true
        $token['status']=$this->status[$environment];

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
