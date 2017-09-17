<?php
/*
 * Middleware provide a convenient mechanism for filtering HTTP requests entering your application. For example,
 * Apix includes a middleware that verifies the user of your application is authenticated. If the user is not authenticated,
 * the middleware will redirect the user to the login screen.
 * However, if the user is authenticated, the middleware will allow the request to proceed further into the application. .
 * middleware command
 * auth
 */

namespace apix;
use Apix\Utils;
use Apix\StaticPathModel;

class ServiceMiddleware {

    public $cond1;
    public $cond2;
    public $cond3;
    public $excludeMiddleware=[];

    public function __construct() {

        $this->staticServiceLayer();
    }

    public function handle(){

        $kernel=staticPathModel::getKernelPath(app);
        $kernelMiddleware=$kernel->middleware;
        $serviceMiddleware=staticPathModel::serviceMiddleware();

        foreach($serviceMiddleware as $middleware=>$permissions){

            if(isset($serviceMiddleware['exclude']) AND isset($serviceMiddleware['exclude'][$middleware])){
                $this->excludeMiddleware=$serviceMiddleware['exclude'][$middleware];
            }


            if(in_array($middleware,$kernelMiddleware)){

                if(is_string($permissions) AND $permissions==="all"){
                    $this->getMiddleRun($middleware);
                }
                else{

                    //check service layer
                    if(in_array($this->cond1,$permissions) OR
                            in_array($this->cond2,$permissions) OR
                                in_array($this->cond3,$permissions)){

                        $this->getMiddleRun($middleware);
                    }

                }


            }
        }

    }

    protected function getExcludeMiddleware(){

        if(isset($this->excludeMiddleware) AND
            (in_array($this->cond1,$this->excludeMiddleware) OR
            in_array($this->cond2,$this->excludeMiddleware) OR in_array($this->cond3,$this->excludeMiddleware)) )
        {
            return false;
        }

        return true;
    }

    protected function getMiddlewarePath($middleware){
        Utils::resolve(staticPathModel::getMiddlewarePath(null,true).'\\'.$middleware)->handle();
    }

    protected function getMiddleRun($middleware){

        if($this->getExcludeMiddleware()){
            $this->getMiddlewarePath($middleware);
        }

    }

    protected function staticServiceLayer(){
        //service layer
        $this->cond1=service.':'.strtolower(request).':'.utils::cleanActionMethod(method);
        $this->cond2=service.':'.strtolower(request).'';
        $this->cond3=service.'';
    }






}