<?php
/**
 * container app controller
 * it is mainly service app provider for service
 * service app provider
 */

namespace Src\App\__projectName__\V1\Config;

class App
{

    /**
     * @method container.
     * containers can be accessed for every service.
     * @return array
     */
    public function container()
    {
        return [

            'base'       =>'\\Src\\App\\__projectName__\\V1\\ServiceBaseController'
        ];
    }

    /**
     * @method getAppDefinition
     * definition is defined by user
     * @return array
     */
    public static function getAppDefinition()
    {
        return [];
    }

    /**
     * @method getAppClassAlias.
     * aliases are defined by user.
     * @return array
     */
    public static function getAppClassAlias()
    {
        return [
            'Log'               =>'Src\App\__projectName__\V1\ServiceLogController'
        ];
    }

}
