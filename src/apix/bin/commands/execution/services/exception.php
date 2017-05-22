<?php
/**
 * app exception handler
 * it is mainly service app exception for service
 * service app exception
 */

namespace src\app\__projectName__\v1\config;

class exception
{

    /**
     * project exception handler.
     *
     * class exception container call access for every service.
     *
     * @param string
     * @return response exception handler runner
     */
    public static function handler($errNo=null, $errStr=null, $errFile=null, $errLine=null, array $errContext)
    {
        return [

            /**
             * project exception handler.
             *
             * class exception container call access for every service.
             *
             * @param array key
             * @key error File
             */
            'errorFile'=>$errFile,

            /**
             * project exception handler.
             *
             * class exception container call access for every service.
             *
             * @param array key
             * @key error Line
             */
            'errorLine'=>$errLine,

            /**
             * project exception handler.
             *
             * class exception container call access for every service.
             *
             * @param array key
             * @key error String
             */
            'errorString'=>$errStr,

            /**
             * project exception handler.
             *
             * class exception container call access for every service.
             *
             * @param array key
             * @key error Number
             */
            'errorNo'=>$errNo,

            /**
             * project exception handler.
             *
             * class exception container call access for every service.
             *
             * @param array key
             * @key error Context
             */
            'Context'=>$errContext
        ];
    }

}
