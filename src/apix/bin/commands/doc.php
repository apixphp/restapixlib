<?php namespace apix\bin\commands;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;

/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class doc {

    public $project=null;

    public function execute($arguments=array()){

        $this->getProject($arguments);
        $getRouterList=$this->getRouterList();
        $commandList=[];
        $methodList=[];
        $commandList[]='php api service publish';
        foreach($getRouterList as $service=>$array){
            $commandList[]=$this->project.':'.$service;
            foreach($getRouterList[$service][$this->getAppVersion()] as $http=>$methods){
                $httpMethod='http:'.$http;
                foreach($getRouterList[$service][$this->getAppVersion()][$http]['methods'] as $methodName){
                    $methodList=$methodName.'Action';
                    $command=implode(" ",$commandList).' names:'.$methodList.' '.$httpMethod;
                    echo utils::symfonyProcess($command);
                }
            }

        }


    }

    public function getProject($arguments=array()){
        $this->project=end($arguments);
    }

    public function getRouterList(){
        return utils::getYaml(staticPathModel::getProjectPath($this->project).'/router.yaml');
    }

    public function getAppVersion(){
        return utils::getAppVersion($this->project);
    }
}