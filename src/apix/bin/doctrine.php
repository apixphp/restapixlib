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
     * index method is main method.
     * Then, require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
     * Otherwise, your application won't be able to find the classes of this Symfony component.
     * @return array @method
     */
    public function execute($data){

        $process = new Process('php vendor/bin/doctrine orm:convert-mapping --namespace="src\\app\\mobi\\v1\\model\doctrine\\" --force  --from-database annotation ./');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}