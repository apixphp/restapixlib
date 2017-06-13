<?php
/*
 * This file is data object loader of the every service.
 *
 * object loader returns array value
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace apix;
use Apix\Utils;
use Apix\StaticPathModel;

class objectLoader {

    /**
     * get object loader params.
     * extra data booting for service method
     *
     * outputs get object.
     *
     * @param string
     * @return response boot object loader runner
     */
    public function boot(){

        $serviceobjectLoader="\\src\\app\\".app."\\v1\\optional\\provisions\\objectloader";
        $serviceobjectLoader=utils::resolve($serviceobjectLoader);
        $serviceobjectLoaderMethod=request.'ObjectLoader';

        $servicemethodicCall=$serviceobjectLoader->$serviceobjectLoaderMethod();
        $s_serviceobjectLoaderMethodExcept=strtolower(request).'Except';

        if(in_array(service,$serviceobjectLoader->$s_serviceobjectLoaderMethodExcept())){

            $servicemethodicCall=[];
        }

        return array_merge_recursive($servicemethodicCall);

        return [];

    }



}