<?php
/*
 * This file is bindigs to data as method parameter in method for every service
 * default : bindings empty data array
 * managed as webServiceBoot method in serviceBaseController 
 * configuration : it is boot object in serviceBaseController
 * it is boolean @true @false
 * appBootLoader
 * return @array
 */
namespace apix;

class staticPathModel {


    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    public static $storePath='src/store';

    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    public static $appPath='src/store';

    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    public static $appNamespace='\\src\\app';

    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    public static $storeMigrationsPath='src/store/migrations';

    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    public static $accessLimitationYamlPath='src/store/provisions/limitation';

    /**
     * @var param api doc
     * it is namespace for api documentation
     * for service path run
     */
    public static $apiDocNamespace='\\Apix\\declarations\\src\\index';

    /**
     * @var param api platform
     * it is namespace for api platform
     * for service path run
     */
    public static $apiPlatformNamespace='\\src\\store\\services\\platform';


    /**
     * @var param api packages auto
     * it is path for api auto service
     * for service path run
     */
    public static $apiPackageAutoPath='src/store/packages/auto';


    /**
     * @var param api packages auto
     * it is namespace for api auto service
     * for service path run
     */
    public static $apiPackageAutoNamespace='\\src\\store\\packages\\auto';


    /**
     * @var param api packages dev
     * it is path for api dev service
     * for service path run
     */
    public static $apiPackageDevPath='src/store/packages/dev';


    /**
     * @var param api packages dev
     * it is namespace for api dev service
     * for service path run
     */
    public static $apiPackageDevNamespace='\\src\\store\\packages\\dev';


    /**
     * @var param api token
     * it is namespace for api token service
     * for service path run
     */
    public static $apiTokenNamespace='\\src\\store\\provisions\\token';


    /**
     * @var param api provision
     * it is namespace for api provision service
     * for service path run
     */
    public static $apiProvisionNamespace='\\src\\store\\provisions\\index';

    /**
     * @var param api lib bin commands
     * it is namespace for api commands service
     * for service path run
     */
    public static $binCommandsPath='./vendor/apixphp/restapixlib/src/apix/bin/commands/';

    /**
     * @var param api lib bin commands
     * it is namespace for api commands service
     * for service path run
     */
    public static $apixVendorPath='./vendor/apixphp/restapixlib/src/apix';

    /**
     * @var param api lib bin commands
     * it is namespace for api commands service
     * for service path run
     */
    public static $apixClassAliasPath='./vendor/apixphp/restapixlib/src/apix/appClassAlias.php';

    /**
     * @var param api lib bin commands
     * it is namespace for api commands service
     * for service path run
     */
    public static $binCommandsNameSpace='\\Apix\\Bin\\Commands\\';


    public static function getProjectPath($projectName=null){
        if($projectName!==null){
            return root.'/'.src.'/'.$projectName;
        }
    }

    public static function getAppServiceBase($app=null,$version=null){

        if(defined('app')){
            $serviceBase='\\src\\app\\'.app.'\\'.version.'\\serviceBaseController';
            return new $serviceBase();
        }
        else{
            $serviceBase='\\src\\app\\'.$app.'\\'.$version.'\\serviceBaseController';
            return new $serviceBase();
        }
        return null;


    }


    public static function getServiceConf($app=null,$version=null,$service=null){

        $app=($app!==null) ? $app : app;
        $version=($version!==null) ? $version : version;
        $service=($service!==null) ? $service : service;

        $serviceConfNamespace='\\src\\app\\'.$app.'\\'.$version.'\\__call\\'.$service.'\serviceConf';
        $serviceConfFile=utils::convertPathFromNamespace($serviceConfNamespace).'.php';

        $serviceConfPath=[];
        if(file_exists($serviceConfFile)){
            $serviceConfPath=require($serviceConfFile);
        }

        if(count($serviceConfPath)===0){
            $packageDevSource=self::getServicePackageDev();
            $packageList=$packageDevSource['packageDevSource']['package'];
            $packageDef=$packageDevSource['packageDevSource']['packageDefinition'];
            if(in_array($service,$packageList) && array_key_exists($service,$packageDef) && array_key_exists('model',$packageDef[$service])){
                return ['model'=>$packageDef[$service]['model']];
            }
        }

        return $serviceConfPath;

    }


    public static function getServicePackageDev($app=null,$version=null,$service=null){

        $app=($app!==null) ? $app : app;
        $version=($version!==null) ? $version : version;
        $service=($service!==null) ? $service : service;

        $serviceConfNamespace='\\src\\app\\'.$app.'\\'.$version.'\\servicePackageDevController';
        $serviceConfFile=utils::convertPathFromNamespace($serviceConfNamespace).'.php';

        $serviceConfPath=[];
        if(file_exists($serviceConfFile)){
            $serviceConfPath=require($serviceConfFile);
        }

        return $serviceConfPath;

    }

    public static function getAppServiceNamespace($project=null,$version=null,$service=null,$method=null){

        if(defined('app') && defined('service') && defined('version') && defined('request')){
            return '\\src\\app\\'.app.'\\'.version.'\__call\\'.service.'\\'.request.'Service';
        }
        return '\\src\\app\\'.$project.'\\'.$version.'\__call\\'.$service.'\\'.$method.'Service';
    }


    public static function getServiceNamespace($service=null,$request=null){

        return '\\src\\app\\'.app.'\\'.version.'\__call\\'.$service.'\\'.$request.'Service';
    }

    public static function getAppServiceLog($type='access'){
        $serviceBase='\\src\\app\\'.app.'\\'.version.'\\serviceLogController';
        return new $serviceBase($type);

    }

    public static function getRateLimitPath($namespace=false){
        if($namespace){
            return '\\src\\app\\'.app.'\\'.version.'\\optional\provisions\limitation\\accessRules';
        }
        return '/src/app/'.app.'/'.version.'/optional/provisions/limitation';

    }

    public static function getAppSocializeFacebook(){

        $facebook='\\src\\app\\'.app.'\\'.version.'\\config\\socialize';
        return $facebook::facebook();

    }


    public static function storeConfigRunner(){

        $storeConfigRunner=root.'/'.self::$storePath.'/config/runner.php';
        if(file_exists($storeConfigRunner)){
            return $storeConfigRunner;
        }
        return null;


    }

    public static function getKernelPath($project){

        $kernelPath='\\src\\app\\'.$project.'\\kernel\kernel';
        return utils::resolve($kernelPath);


    }

    public static function getKernelCommand($project,$namespace=false){

        $kernelCommandNamespace='\\src\\app\\'.$project.'\\kernel\commands';
        $kernelCommandPath=utils::convertPathFromNamespace($kernelCommandNamespace);
        if($namespace===false){
            return $kernelCommandPath;
        }
        return $kernelCommandNamespace;



    }


    public static function getMiddlewarePath($project){

        return root.'/src/app/'.$project.'/kernel/middleware';

    }

    public static function serviceMiddleware(){

        $serviceMiddleware=root.'/src/app/'.app.'/'.version.'/serviceMiddlewareController.php';
        $list=require_once($serviceMiddleware);
        return $list;

    }

    public static function getConfigStaticApp($className=null){

        if($className!==null){
            $config='\\src\\app\\'.app.'\\'.version.'\\config\\'.$className;
            return $config;
        }
        return null;


    }


    public static function getJobPath($type=false){

        if(!$type){
            return '\\src\\app\\'.app.'\\'.version.'\\optional\\jobs';
        }

        return root.'/src/app/'.app.'/'.version.'/optional/jobs';

    }

    public static function getStoragePath($type=false){

        if(!$type){
            return '\\src\\app\\'.app.'\\storage';
        }

        return root.'/src/app/'.app.'/storage';
    }





}