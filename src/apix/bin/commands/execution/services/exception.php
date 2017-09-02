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
     * @return array
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
             * user information.
             * @key user
             * @value fingerPrint from base
             * @return array
             */
            'user'=>app('base')->fingerPrint(true),

            /**
             * Context.
             * @key context
             * @value $errContext
             */
            'Context'=>$errContext
        ];
    }

    /**
     * project exception type codes handler.
     *
     * class exception type codes call access for every service.
     *
     * @param string
     * @return array
     */
    public static function exceptionTypeCodes($type=null){

        $exceptionTypes=[

            /**
             * BadFunctionCallException.
             *
             * @define Exception thrown if a callback refers to an undefined function
             * or if some arguments are missing.
             */
            'BadFunctionCallException'=>100,

            /**
             * BadMethodCallException.
             *
             * @define Exception thrown if a callback refers to an undefined method
             * or if some arguments are missing.
             */
            'BadMethodCallException'=>101,

            /**
             * DomainException.
             *
             * @define Exception thrown if a value does not adhere to a defined valid data domain.
             */
            'DomainException'=>102,

            /**
             * InvalidArgumentException.
             *
             * @define Exception thrown if an argument is not of the expected type.
             */
            'InvalidArgumentException'=>103,

            /**
             * LengthException.
             *
             * @define Exception thrown if a length is invalid.
             */
            'LengthException'=>104,

            /**
             * LogicException.
             *
             * @define Exception that represents error in the program logic.
             * This kind of exception should lead directly to a fix in your code.
             */
            'LogicException'=>105,

            /**
             * OutOfBoundsException.
             *
             * @define Exception thrown if a value is not a valid key.
             * This represents errors that cannot be detected at compile time.
             */
            'OutOfBoundsException'=>106,

            /**
             * OutOfRangeException.
             *
             * @define Exception thrown when an illegal index was requested.
             * This represents errors that should be detected at compile time.
             */
            'OutOfRangeException'=>107,

            /**
             * OverflowException.
             *
             * @define Exception thrown when adding an element to a full container.
             */
            'OverflowException'=>108,

            /**
             * RangeException.
             *
             * @define Exception thrown to indicate range errors during program execution.
             * Normally this means there was an arithmetic error other than under/overflow.
             * This is the runtime version of DomainException.
             */
            'RangeException'=>109,

            /**
             * RuntimeException.
             *
             * @define Exception thrown if an error which can only be found on runtime occurs.
             */
            'RuntimeException'=>110,

            /**
             * UnderflowException.
             *
             * @define Exception thrown when performing an invalid operation on an empty container,
             * such as removing an element.
             */
            'UnderflowException'=>111,

            /**
             * UnexpectedValueException.
             *
             * @define Exception thrown if a value does not match with a set of values.
             * Typically this happens when a function calls another function and expects
             * the return value to be of a certain type or value not including arithmetic or buffer related errors.
             */
            'UnexpectedValueException'=>112
        ];

        if($type!==null){
            return $exceptionTypes[$type];
        }
        return $exceptionTypes;


    }

}
