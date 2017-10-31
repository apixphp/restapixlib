<?php

namespace Apix\Bin;

use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
use Apix\Console_Table;

class Route extends Console {

    /**
     * @var $project
     */
    public $project=null;

    /**
     * @var $service
     */
    public $service=null;

    /**
     * @var $version
     */
    public $version=null;

    /**
     * @var $http
     */
    public $http=null;

    /**
     * @var $methodName
     */
    public $methodName=null;

    /**
     * @var $doc
     */
    public $doc=null;

    /**
     * @var $memory
     */
    public $memory=null;


    /**
     * route constructor.
     */
    public function __construct() {

        parent::__construct();
    }

    public function execute($arguments=array()){

        //get project
        $this->getProject($arguments);

        //get route list
        $routeList=$this->getRouterList();

        //if there is no routelist
        //trow exception
        if($routeList===null){

            return $this->error('No route or yaml list');
        }

        $tbl = new Console_Table();

        $tbl->setHeaders(
            array('Project', 'Service','Version','Http','Method','Namespace','Middleware','Doc','MemoryUsage')
        );


        foreach($routeList as $service=>$array){

            //set service object
            $this->service=ucfirst($service);

            foreach($routeList[$service] as $version=>$array){

                //set version object
                $this->version=ucfirst($version);

                foreach($routeList[$service][$version] as $http=>$array){

                    //set http object
                    $this->http=ucfirst($http);

                    foreach($routeList[$service][$version][$http]['methods'] as $methodName){

                        //set methodName object
                        $this->methodName=ucfirst($methodName);

                        $memory='no request';
                        if(array_key_exists('memory',$routeList[$service][$version][$http]) && array_key_exists($methodName,$routeList[$service][$version][$http]['memory'])){
                            $memory=$routeList[$service][$version][$http]['memory'][$methodName];
                            $this->memory=$this->get_memory_usage($memory);
                        }


                        $this->doc=$this->getDocControl($service,$http,$methodName);

                        if(array_key_exists(3,$arguments) && preg_match('@filter@is',$arguments[3])){

                            //explode field filter
                            $field=explode("=",str_replace('filter:','',$arguments[3]));

                            /**
                             * Doc filter.
                             * type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="doc"){
                                if($this->doc==$field[1]){
                                    $tbl->addRow($this->tableHeadersList());
                                }
                            }

                            /**
                             * Service filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="service"){
                                if($this->service==$field[1]){
                                    $tbl->addRow($this->tableHeadersList());
                                }
                            }

                            /**
                             * Version filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="version"){
                                if($this->version==$field[1]){
                                    $tbl->addRow($this->tableHeadersList());
                                }
                            }


                            /**
                             * Http filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="http"){
                                if($this->http==$field[1]){
                                    $tbl->addRow($this->tableHeadersList());
                                }
                            }


                            /**
                             * methodName filter.
                             *
                             * @param type doc filter and stk class
                             * main loader as doc filter
                             */
                            if($field[0]=="method"){
                                if($this->methodName==$field[1]){
                                    $tbl->addRow($this->tableHeadersList());
                                }
                            }


                        }
                        else{
                            $tbl->addRow($this->tableHeadersList());
                        }

                    }

                }

            }

        }


        echo $tbl->getTable();
    }


    /**
     * @method tableHeadersList
     * @return array
     */
    public function tableHeadersList(){

        return array($this->project, $this->service,$this->version,$this->http,$this->methodName,$this->getNamespace(),$this->getMiddleWares(),$this->doc,$this->memory);
    }

    /**
 * @return string
 */
    public function getNamespace(){

        return staticPathModel::$appNamespace.'\\'.$this->project.'\\'.$this->version.'\__Call\\'.$this->service.'\\'.$this->http.'Service';
    }

    /**
     * @return string
     */
    public function getMiddleWares(){

        return null;
    }

    /**
     * @param array $arguments
     */
    public function getProject($arguments=array()){
        $this->project=ucfirst($arguments[2]);

    }

    /**
     * @return mixed|null|string
     */
    public function getRouterList(){
        if(file_exists(staticPathModel::getProjectPath($this->project).'/router.yaml')){
            return utils::getYaml(staticPathModel::getProjectPath($this->project).'/router.yaml');
        }
        return null;

    }

    /**
     * @return null
     */
    public function getAppVersion(){
        return utils::getAppVersion($this->project);
    }

    /**
     * @param $service
     * @param $http
     * @param $method
     * @return string
     */
    public function getDocControl($service,$http,$method){
        $yaml=$service.'_'.$http.'_'.$method.'Action.yaml';
        $docYamlPath=utils::getDeclarationYamlFile($this->project,$yaml);
        if(file_exists($docYamlPath)){
            return 'yes';
        }
        return 'no';
    }


    /**
     * @param $mem_usage
     * @return string
     */
    public function get_memory_usage($mem_usage) {

        if ($mem_usage < 1024)
            return $mem_usage." bytes";
        elseif ($mem_usage < 1048576)
            return  round($mem_usage/1024,2)." kilobytes";
        else
            return round($mem_usage/1048576,2)." megabytes";
    }
}