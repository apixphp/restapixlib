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
    public static $accessLimitationYamlPath='src/store/provisions/limitation';

    /**
     * @var param api doc
     * it is namespace for api documentation
     * for service path run
     */
    public static $apiDocNamespace='\\src\\store\\declarations\\src\\index';

    /**
     * @var param api platform
     * it is namespace for api platform
     * for service path run
     */
    public static $apiPlatformNamespace='\\src\\store\\services\\platform';


    /**
     * @var param api middleware
     * it is namespace for api middleware
     * for service path run
     */
    public static $apiMiddlewareNamespace='\\src\\store\\middleware';


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

    public static function getAppServiceBase(){

        if(defined('app')){
            $serviceBase='\\src\\app\\'.app.'\\'.version.'\\serviceBaseController';
            return new $serviceBase();
        }
        return null;


    }

    public static function getAppServiceNamespace($project,$version,$service,$method){

        return '\\src\\app\\'.$project.'\\'.$version.'\__call\\'.$service.'\\'.$method.'Service';
    }

    public static function getAppServiceLog(){
        $serviceBase='\\src\\app\\'.app.'\\'.version.'\\serviceLogController';
        return new $serviceBase();

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




}