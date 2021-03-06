<?php
/*
 * This file is main class of the  service named stk on  mobi project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : mobi
 * namespace : src\app\mobi\v1\__call\stk
 * app class namespace : \src\app\mobi\v1\__call\stk\app
 */

namespace apix\bin;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Apix\Utils;
use Apix\Console;
use Apix\StaticPathModel;

/**
 * Represents a getService class.
 * http method : get
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class custom extends console {

    public $request;
    public $forbidden=false;


    /**
     * index method is main method.
     * it is default method without needed interface implemantation
     * because method name is called on the url
     * method can produce ouput as string or array
     * converted to array everytime as output
     * produced json output as result
     * @return array @method
     */
    public function customConsoleApplication($data){

        //result
        $application=new Application();
        $dataExplode=explode(":",$data[1]);

        $appCommandPath=null;
        if(count($dataExplode)===2){
            $appCommandPath=staticPathModel::getKernelCommand($dataExplode[0]).'/'.$dataExplode[1].'.php';
        }

        if(file_exists($appCommandPath)){
            $command=''.staticPathModel::getKernelCommand($dataExplode[0],true).'\\'.$dataExplode[1];
        }
        else{
            $command='\\src\\store\\commands\\'.$data[1];
        }

        if($data[1]=="migration"){
            $command='\\Apix\\bin\\'.$data[1];
        }

        if($data[1]=="curl"){
            $command='\\Apix\\bin\\'.$data[1];
        }

        $app=\Apix\Utils::resolve($command);

        $list=[];
        foreach($data as $key=>$value){
            if($key>1){
                $dataEx=explode(":",$value);
                if(array_key_exists(1,$dataEx) && strlen($dataEx[1])>0){
                    $list[$dataEx[0]]=$dataEx[1];
                }
                else{
                    $list[$dataEx[0]]=null;
                }

            }

        }

        if(method_exists($app,'appNameSpace')){
            $appDef=$app->appNameSpace((object)$list);
            define('app',$appDef['app']);
            define('version',$appDef['version']);
        }

        if(property_exists($app,'appNameSpace')){
            $appDef=$app->appNameSpace;
            define('app',$appDef['app']);
            define('version',$appDef['version']);
        }


        return $app->handle((object)$list);
        $application->run();
    }

    /**
     * index method is main method.
     * it is default method without needed interface implemantation
     * because method name is called on the url
     * method can produce ouput as string or array
     * converted to array everytime as output
     * produced json output as result
     * @return array @method
     */
    public function execute($data){

       return $this->customConsoleApplication($data);
    }
}