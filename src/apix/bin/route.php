<?php namespace apix\bin;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
use Apix\Console_Table;


/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class route {

    public $project=null;

    public function execute($arguments=array()){

        $this->getProject($arguments);
        $routeList=$this->getRouterList();

        if($routeList===null){
            dd('route error : no project or yaml');
        }

        $tbl = new Console_Table();
        $tbl->setHeaders(
            array('Project', 'Service','Version','Http','Method','Doc')
        );


        foreach($routeList as $service=>$array){
            foreach($routeList[$service] as $version=>$array){
                foreach($routeList[$service][$version] as $http=>$array){
                    foreach($routeList[$service][$version][$http]['methods'] as $methodName){

                        $doc=$this->getDocControl($service,$http,$methodName);

                        if(array_key_exists(3,$arguments) && preg_match('@filter@is',$arguments[3])){
                            $field=explode("=",str_replace('filter:','',$arguments[3]));

                            /**
                             * Doc filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="doc"){
                                if($doc==$field[1]){
                                    $tbl->addRow(array($this->project, $service,$version,$http,$methodName,$doc));
                                }
                            }

                            /**
                             * Service filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="service"){
                                if($service==$field[1]){
                                    $tbl->addRow(array($this->project, $service,$version,$http,$methodName,$doc));
                                }
                            }

                            /**
                             * Version filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="version"){
                                if($version==$field[1]){
                                    $tbl->addRow(array($this->project, $service,$version,$http,$methodName,$doc));
                                }
                            }


                            /**
                             * Http filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="http"){
                                if($http==$field[1]){
                                    $tbl->addRow(array($this->project, $service,$version,$http,$methodName,$doc));
                                }
                            }


                            /**
                             * methodName filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="method"){
                                if($methodName==$field[1]){
                                    $tbl->addRow(array($this->project, $service,$version,$http,$methodName,$doc));
                                }
                            }

                        }
                        else{
                            $tbl->addRow(array($this->project, $service,$version,$http,$methodName,$doc));
                        }

                    }

                }

            }

        }


        echo $tbl->getTable();
    }

    public function getProject($arguments=array()){
        $this->project=$arguments[2];

    }

    public function getRouterList(){
        if(file_exists(staticPathModel::getProjectPath($this->project).'/router.yaml')){
            return utils::getYaml(staticPathModel::getProjectPath($this->project).'/router.yaml');
        }
        return null;

    }

    public function getAppVersion(){
        return utils::getAppVersion($this->project);
    }

    public function getDocControl($service,$http,$method){
        $yaml=$service.'_'.$http.'_'.$method.'Action.yaml';
        $docYamlPath=utils::getDeclarationYamlFile($this->project,$yaml);
        if(file_exists($docYamlPath)){
            return 'yes';
        }
        return 'no';
    }
}