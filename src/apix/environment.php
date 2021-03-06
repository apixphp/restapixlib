<?php

namespace apix;
use Apix\Utils;
use Apix\StaticPathModel;

class environment {

    private static $local='local';
    private static $production='production';

    /**
     * service environment constructs.
     *
     * outputs get file.
     *
     * @internal param $string
     */
    public function __construct(){}

    /**
     * service environment runner method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service environment runner
     */
    public static function get(){
        return self::defaultEnvironment(function(){
            return self::applicationEnvironment(function(){
                return self::$production;

            });
        });
    }


    /**
     * service environment config method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service environment config runner
     */
    public static function config(){

        //check environment
        if(self::get()==self::$local){
            if(defined("app")){
                $appEnvPath=root.'/.'.app.'env';
                $dotenv=(file_exists($appEnvPath))
                    ? new \Dotenv\Dotenv(root,'.'.app.'env')
                    : new \Dotenv\Dotenv(root);
            }
            else{
                $dotenv=new \Dotenv\Dotenv(root);
            }

            $dotenv->load();


        }
        else{

            if(file_exists($environmentInProjectPath)){
                $dotenv = new \Dotenv\Dotenv(root.'/'.src.'/'.app.'/storage/env','.'.$environment);
                $dotenv->load();
            }
        }

    }


    /**
     * service environment application method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service environment application runner
     */
    public static function applicationEnvironment($callback){

        $appEnvPath=root.'/.env';

        if(defined('app')){
            $appEnvPath=root.'/.'.app.'env';
        }

        if(file_exists($appEnvPath)){
            return self::$local;
        }
        else{
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }
    }

    /**
     * service environment default method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service environment default runner
     */
    public static function defaultEnvironment($callback){

        $envPath=root.'/.env';
        if(file_exists($envPath)){
            return self::$local;
        }
        else{
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }
    }

}