<?php namespace Src\App\__projectName__\V1\Model;

trait ModelVar {

    /**
     * @method orderBy
     *
     * info your result is automatically ordered
     * status optional
     * @return array
     */
    public function orderBy(){

        return [
            'auto'=> [
                    'id'=>'desc'
                ]
        ];
    }

    /**
     * @method paginator.
     *
     * your result is automatically paginated
     * status optional
     * @return array
     */
    public function paginator(){

        return [
            'auto'=>10
        ];
    }

    /**
     * @method resultDataInfo.
     *
     * this value changes default result data info
     * example coultAllData=>'total'
     * status optional
     * @return array
     */
    public function resultDataInfo(){

        return [];
    }
}