<?php
/*
 * namespace : lib/bin/doctrine
 * doctrine class
 */

namespace apix\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;

/**
 * Represents a doctrine class.
 * http method : console
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class doctrine {

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(){
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }

    /**
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function execute($data){

        $process = new Process('php vendor/bin/doctrine orm:convert-mapping --filter="'.ucfirst($data[3]).'" --namespace="src\\\\app\\\\'.$data[2].'\\\\'.utils::getAppVersion($data[2]).'\\\\model\\\\doctrine\\\\" --force  --from-database annotation ./');
        $process->run();


        echo $process->getOutput();
    }
}