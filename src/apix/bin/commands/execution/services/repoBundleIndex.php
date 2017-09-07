<?php
/*
 * This file is repo part src of the __projectName__ repository.
 *
 * every request can call repository
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\optional\repository\__bundleName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;
use src\app\__projectName__\v1\serviceBaseController as base;
use Log;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class index extends base implements __bundleName__Interface {


    /**
     * Constructor.
     *
     */
    public function __construct() {

        parent::__construct();
        $this->branchInitialize();
    }


    /**
     * for repository service
     * handle method is auto run.
     *
     * @return mixed
     */
    public function get()
    {

        //return source
        return "__projectName__ repository __bundleName__";
    }

}
