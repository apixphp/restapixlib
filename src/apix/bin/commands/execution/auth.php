<?php
/**
 * Apix makes implementing authentication very simple. In fact, almost everything is configured for you out of the box.
 * The authentication configuration file is located at config/auth.php,
 * which contains several well documented options for tweaking the behavior of the authentication services.
 */

return [

    'provides'=>[

        //default user guard
        'default'=>[
            'driver'=>'database',
            'model'=>src\app\mobi\v1\model\sudb\user::class,
            'credentials'=>[],
            'registerMethod'=>'session',
            'tokenField'=>'app_token',
            'encrypt'=>'math'
        ],

        //admin user guard
        'admin'=>[
            'driver'=>'database',
            'model'=>src\app\mobi\v1\model\sudb\user::class,
            'credentials'=>[],
            'registerMethod'=>'session',
            'tokenField'=>'app_token',
            'encrypt'=>'math'
        ]

    ]


];