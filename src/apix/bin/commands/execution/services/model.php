<?php
namespace Src\App\__projectName__\__version__\Model\Sudb;

use Src\Store\Packages\Providers\Database\Sudb\Src\Model as Model;

class __className__ extends Model
{
    use \Src\App\__projectName__\__version__\Model\ModelVar;

    /**
     * @var $table.
     *
     * table name for your database
     * status obligatory
     */
    public $table='__tableName__';

    /**
     * @var $primaryKey.
     *
     * primary key column for your database table
     * status obligatory
     */
    public $primaryKey='id';

    /**
     * @var $paginator.
     *
     * your result is automatically paginated
     * status optional
     */
    public $paginator=[];

    /**
     * @var $orderBy.
     *
     * your result is automatically ordered
     * status optional
     */
    public $orderBy=[];

    /**
     * @var $redis.
     *
     * info your result is cached for redis
     * status it is run for status true
     * expire cache expire time
     */
    public $redis=['status'=>false,'expire'=>60];

    /**
     * @var $createdAndUpdatedFields.
     *
     * this value is created and updated time for values it will be inserted
     * status obligatory
     */
    public $createdAndUpdatedFields=['created_at'=>'createdAt','updated_at'=>'updatedAt'];


    /**
     * @var $resultDataInfo.
     *
     * this value changes default result data info
     * example coultAllData=>'total'
     * status optional
     */
    public $resultDataInfo=[];


    /**
     * @var $joiner
     *
     * info joiner table is relationship
     * status it is array
     */
    public $joiner=[
        'photo'=>[
            'relations'=>[
                //modelId-photoField
                'id'=>'userId'
            ],
            'fields'=>[
                'name'
            ],
            'auto'=>false,
            'sequence'=>'single',
            'join'=>'left',
            'orderBy'=>'desc',
            'limit'=>null,
            'limitUrlString'=>'photoPage'
        ]
    ];


    /**
     * @var $selectHidden.
     *
     * your table columns is hidden
     * status optional
     */
    public $selectHidden=[];

    /**
     * @var $insertConditions.
     *
     * info restrictions for data inserted by client
     * status optional - it is run for status true
     */
    public $insertConditions=[
        'status'=>false,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];

    /**
     * @var $updateConditions.
     *
     * info restrictions for data updated by client
     * status optional - it is run for status true
     */
    public $updateConditions=[
        'status'=>false,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];

    /**
     * @var $selectPermissions.
     *
     * info client can select to data
     * status optional - it is run for status true
     */
    public $selectPermissions=[
        'status'=>false,
        'authorized'=>'*',
        'forbidden'=>[],
        'tokens'=>'*',
        'seperator'=>'::'
    ];


    /**
     * @var $scope.
     *
     * specific where conditional
     * status optional
     */
    public $scope=['auto'=>[]];


    /**
     * @var $modelScope.
     *
     * specific where conditional snippet
     * status optional
     */
    public function modelScope($data, $query)
    {

        //get id
        if ($data=="id") {
            $query->where(function ($model) {
                if (\app::checkUrlParam("id")) {
                    $model->where("id", "=", \app::getUrlParam("id"));
                }
            });
        }

        //scopes
        if ($data=="active") {
            $query->where("status", "=", 1);
        }
    }

    /**
     * @method fieldPassword.
     *
     * your table columns is value
     * status optional
     */
    /*public function fieldPassword(){
        return md5(\app::post("password"));
    }*/


    public function __construct(){

        $this->resultDataInfo=$this->resultDataInfo();
        $this->paginator=$this->paginator();
        $this->orderBy=$this->orderBy();
    }
}
