<?php
/**
 * container app controller
 * it is mainly service app provider for service
 * service app provider
 */

namespace src\app\__projectName__\v1\config;

class app
{

    /**
     * @method container.
     * containers can be accessed for every service.
     * @return array
     */
    public function container()
    {
        return [

            'base'       =>'\\src\\app\\__projectName__\\v1\\serviceBaseController'
        ];
    }


    /**
     * @method staticProvider.
     * class static call access for every service.
     * @return array
     */
    public function staticProvider()
    {
        return [];
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
            'Adapter'           =>'src\app\__projectName__\v1\serviceAdapterController',
            'Log'               =>'src\app\__projectName__\v1\serviceLogController'
        ];
    }

}
