<?php
namespace Src\App\__projectName__\V1\Config;

use Src\App\__projectName__\V1\ServiceAnnotationsController;
use Src\App\__projectName__\V1\ServiceBaseController as Base;
use Src\App\__projectName__\V1\Model\Sudb\User;

class Auth extends Base {

    //service annotations controller
    use ServiceAnnotationsController;

    /**
     * @var mixed
     */
    public $input;

    /**
     * Auth constructor.
     */
    public function __construct(){

        parent::__construct();
        $this->input=$this->request->input();

        if(!isset($this->input['username']) && !isset($this->input['password'])) {

            $this->input['username']='username';
            $this->input['password']='password';
        }
    }

    /**
     * @return array
     */
    public function handle(){

        return [

            'provides'=>[

                //default user guard
                'default'=>[
                    'driver'=>'database',
                    'model'=>User::class,
                    'credentials'=>[
                        'username'=>$this->input['username'],
                        'password'=>$this->input['password']
                    ],
                    'registerMethod'=>'session',
                    'tokenField'=>'app_token',
                    'encrypt'=>'math',
                    'persistent'=>'header', //header or get
                    'persistentKey'=>'auth'
                ],

                //admin user guard
                'admin'=>[
                    'driver'=>'database',
                    'model'=>User::class,
                    'credentials'=>[
                        'username'=>$this->input['username'],
                        'password'=>$this->input['password']
                    ],
                    'registerMethod'=>'session',
                    'tokenField'=>'app_token',
                    'encrypt'=>'math',
                    'persistent'=>'header', //header or get
                    'persistentKey'=>'auth'
                ]

            ]


        ];

    }

}

