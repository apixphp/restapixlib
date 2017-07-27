<?php
/*
 * This file is repo part src of the __projectName__ repository.
 *
 * every request can call repository
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\optional\repository\__bundleName__\src\__srcName__;

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

class __className__ extends base {


    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct() {

        parent::__construct();
        $this->branchInitialize();
    }


    /**
     * for repository src service
     * get method is main run.
     *
     * @return string|array|object
     */
    public function get(){

        //return source
        return "__projectName__ repository __bundleName__ __srcName__";
    }
}
