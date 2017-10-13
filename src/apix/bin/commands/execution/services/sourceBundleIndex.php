<?php

namespace Src\App\__projectName__\__version__\__Call\__serviceName__\Source\__bundleName__;

use Src\App\__projectName__\__version__\__Call\__serviceName__\App;

class Index extends App implements __bundleName__Interface
{
    /**
     * for bundle service
     * handle method is auto run.
     * @return mixed
     */
    public function get()
    {
        //return source
        return ['source'=>"__projectName__ bundle __serviceName__ __bundleName__"];
    }
}
