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
    public static function handler($errNo=null, $errStr=null, $errFile=null, $errLine=null,$errType=null, array $errContext)
    {
        return [

            /**
             * Error file.
             * @key errorFile
             * @value $errFile
             */
            'errorFile'=>$errFile,

            /**
             * Error Line.
             * @key errorLine
             * @value $errLine
             */
            'errorLine'=>$errLine,

            /**
             * Error Type.
             * @key errorType
             * @value $errType
             */
            'errorType'=>$errType,

            /**
             * Error String.
             * @key errorString
             * @value $errStr
             */
            'errorString'=>$errStr,

            /**
             * Error No.
             * @key errorNo
             * @value $errNo
             */
            'errorNo'=>$errNo,

            /**
             * Context.
             * @key context
             * @value $errContext
             */
            'Context'=>$errContext
        ];
    }

}
