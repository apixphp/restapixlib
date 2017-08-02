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

    public function handle(){

        $kernel=staticPathModel::getKernelPath(app);
        $kernelMiddleware=$kernel->middleware;
        $serviceMiddleware=staticPathModel::serviceMiddleware();

        foreach($serviceMiddleware as $middleware=>$permissions){
            if(in_array($middleware,$kernelMiddleware)){

                //service layer
                $cond1=service.':'.strtolower(request).':'.utils::cleanActionMethod(method);
                $cond2=service.':'.strtolower(request).'';
                $cond3=service.'';

                if(is_string($permissions) AND $permissions==="all"){
                    return $this->getMiddlewarePath($middleware);
                }

                //check service layer
                if(in_array($cond1,$permissions) OR in_array($cond2,$permissions) OR in_array($cond3,$permissions)){
                    return $this->getMiddlewarePath($middleware);
                }
            }
        }

    }

    public function getMiddlewarePath($middleware){
        Utils::resolve(staticPathModel::getMiddlewarePath(null,true).'\\'.$middleware)->handle();
    }






}