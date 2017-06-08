<?php namespace apix\bin;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class runner {

    public $project=null;

    public function execute($arguments=array()) {
        $this->getProject($arguments);

        if($this->project===null){

            echo $this->generalProcessRunner();
        }
        else{

            $commandRunner=$this->getCommandProcessRunner();

            if(count($commandRunner)){
                foreach($commandRunner as $command){
                    echo $this->processRunner($command);
                }
            }
            else{
                echo 'no command';
            }

        }


    }

    public function getProject($arguments=array()){
        if(array_key_exists(2,$arguments)){
            $this->project=$arguments[2];
            define('app',$this->project);
            define('version',utils::getAppVersion($this->project));
        }
        return null;


    }

    public function processRunner($command=null){
        if($command!==null){

            $process = new Process($command);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            echo $process->getOutput();
        }
    }

    public function  getCommandProcessRunner(){
        return staticPathModel::getKernelPath($this->project)->commandProcessRunner;
    }

    public function  generalProcessRunner(){
        $storeConfigRunner=staticPathModel::storeConfigRunner();

        if($storeConfigRunner!==null){
            $storeConfigRunnerList=require_once($storeConfigRunner);
            foreach ($storeConfigRunnerList as $command){
                echo $this->processRunner($command);
            }
        }
    }
}