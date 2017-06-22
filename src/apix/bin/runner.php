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

            echo $this->generalProcessRunner($arguments);
        }
        else{

            $commandRunner=$this->getCommandProcessRunner();

            if(count($commandRunner)){
                $this->commandRunnerList($commandRunner,$arguments);
            }
            else{
                echo 'no command';
            }

        }


    }

    public function getProject($arguments=array()){
        if(array_key_exists(2,$arguments)){
            if(utils::getAppVersion($this->project)===null){
               $this->project=null;
            }
            else{
                $this->project=$arguments[2];
            }
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

    public function  generalProcessRunner($arguments){
        $storeConfigRunner=staticPathModel::storeConfigRunner();

        if($storeConfigRunner!==null){
            $storeConfigRunnerList=require_once($storeConfigRunner);
            $this->commandRunnerList($storeConfigRunnerList,$arguments);
        }
    }

    public function commandRunnerList($commandRunner,$arguments){

        $argumentKeyPointer=($this->project===null) ? 2 : 3;

        if(array_key_exists($argumentKeyPointer,$arguments)){
            foreach($commandRunner[$arguments[$argumentKeyPointer]] as $command){
                echo $this->processRunner($command);
            }
        }
        else{

            foreach($commandRunner as $command=>$allCommandArray){
                foreach($commandRunner[$command] as $commandList){
                    echo $this->processRunner($commandList);
                }
            }
        }

    }
}