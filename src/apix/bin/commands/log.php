<?php namespace apix\bin\commands;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class log {

    public $project=false;

    public function get($arguments=array()){

        $this->getProject($arguments);

        define('app',$this->project);
        define('version',utils::getAppVersion($this->project));

        $logPath=staticPathModel::getAppServiceLog()->logPath;

        $processCommand='tail -f '.$logPath;

        if(array_key_exists('grep',$arguments)){
            $processCommand=$processCommand.' | grep -i '.$arguments['grep'];
        }

        dd($processCommand);

        /*$process = new Process($processCommand);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo $buffer;
            }
        });*/
    }

    public function getProject($arguments=array()){
        foreach($arguments as $value){
            $this->project=$value;
            break;
        }
    }
}