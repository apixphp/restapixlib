<?php

namespace apix;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Apix\StaticPathModel;

class utils {

    public static $extension='.php';

    /**
     * Class resolve.
     * PHP-DI's container is preconfigured for "plug'n'play", i.e. development environment.
     * By default, PHP-DI will have Autowiring enabled (annotations are disabled by default).
     * return type container
     */
    public static function resolve($class=null){
        if($class!==null){
            $container = \DI\ContainerBuilder::buildDevContainer();
            return $container->get($class);
        }

    }


    /**
     * Class resolve.
     * PHP-DI's container is preconfigured for "plug'n'play", i.e. development environment.
     * By default, PHP-DI will have Autowiring enabled (annotations are disabled by default).
     * return type container
     */
    public static function getAppVersion($app=null){
        if($app!==null){
            $getAppVersionPath=root.'/'.src.'/'.$app.'/version.php';
            if(file_exists($getAppVersionPath)){
                $getAppVersion=require($getAppVersionPath);
                return $getAppVersion['version'];
            }
        }
        return null;

    }


    /**
     * Class resolve.
     * PHP-DI's container is preconfigured for "plug'n'play", i.e. development environment.
     * By default, PHP-DI will have Autowiring enabled (annotations are disabled by default).
     * return type container
     */
    public static function getAppRootNamespace($app=null){
        if($app!==null){
            $getAppRoot='\\src\\app\\'.$app.'\\'.self::getAppVersion($app).'';
            return $getAppRoot;
        }
        return null;

    }

    /**
     * Method getYaml.
     * The Symfony Yaml component is very simple and consists of two main classes:
     * one parses YAML strings (Parser), and the other dumps a PHP array to a YAML string (Dumper).
     * If an error occurs during parsing, the parser throws a ParseException exception
     * indicating the error type and the line in the original YAML string where the error occurred:
     * return type container
     */
    public static function getYaml($file=null){
        if($file!==null){
            try {
                return Yaml::parse(file_get_contents($file));
            } catch (ParseException $e) {
                return "Unable to parse the YAML string :". $e->getMessage();
            }
        }

    }


    /**
     * Method dumpYaml.
     * The Symfony Yaml component is very simple and consists of two main classes:
     * one parses YAML strings (Parser), and the other dumps a PHP array to a YAML string (Dumper).
     * If an error occurs during parsing, the parser throws a ParseException exception
     * indicating the error type and the line in the original YAML string where the error occurred:
     * return type container
     */
    public static function dumpYaml($data=array(),$yamlPath=null){
        if(is_array($data)){
            $yaml = Yaml::dump($data);
            return file_put_contents($yamlPath, $yaml);
        }

    }


    /**
     * Spl auto load register.
     * spl_autoload_register — Register given function as __autoload() implementation
     * Register a function with the spl provided __autoload queue. If the queue is not yet activated it will be activated.
     * If your code has an existing __autoload() function then this function must be explicitly registered on the __autoload queue.
     * This is because spl_autoload_register() will effectively replace the engine cache for the __autoload() function
     * by either spl_autoload() or spl_autoload_call()
     * return autoload
     */
    public static function getArgForConsoleParameters($argv){
        $list=[];
        foreach ($argv as $key=>$value){
            if($key>2){

                if(preg_match('@:@is',$value))
                {
                    $value=explode(":",$value);
                    $list[$value[0]]=$value[1];
                }
                else
                {
                    $list[$value]=$value;
                }
            }
        }

        return $list;

    }


    /**
     * Spl auto load register.
     * spl_autoload_register — Register given function as __autoload() implementation
     * Register a function with the spl provided __autoload queue. If the queue is not yet activated it will be activated.
     * If your code has an existing __autoload() function then this function must be explicitly registered on the __autoload queue.
     * This is because spl_autoload_register() will effectively replace the engine cache for the __autoload() function
     * by either spl_autoload() or spl_autoload_call()
     * return autoload
     */
    public static function getBaseConsoleStaticProperties($argv){
        //get connection
        if($argv[1]=="doctrine"){
            $consoleCommandApplication=new \Apix\bin\doctrine();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        elseif($argv[1]=="system"){
            $consoleCommandApplication=new \Apix\bin\system();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        elseif($argv[1]=="server"){
            $consoleCommandApplication=new \Apix\bin\server();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        elseif($argv[1]=="git"){
            $consoleCommandApplication=new \Apix\bin\git();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }

        elseif($argv[1]=="d"){
            $consoleCommandApplication=new \Apix\bin\commands\doc();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }

        elseif($argv[1]=="route"){
            $consoleCommandApplication=new \Apix\bin\route();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }

        elseif($argv[1]=="runner"){
            $consoleCommandApplication=new \Apix\bin\runner();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }

        elseif($argv[1]=="list"){
            $consoleCommandApplication=new \Apix\bin\apixlist();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        else{
            $consoleCommandApplication=new \Apix\bin\custom();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }

    }


    //set service route list
    public static function setServiceRouteList($project,$service,$version,$method){
        $serviceRouteListPath=staticPathModel::getProjectPath($project).'/router.yaml';

        $routeList=[];
        if(file_exists($serviceRouteListPath)){
            $routeList=\apix\utils::getYaml($serviceRouteListPath);
        }

        dd($routeList);

        $serviceNamespace=staticPathModel::getAppServiceNamespace($project,$version,$service,$method);

        define('app',$project);
        define('version',$version);


        $class_methods = get_class_methods(\apix\utils::resolve($serviceNamespace));


        foreach ($class_methods as $methodName){
            if($methodName!=='__construct' && preg_match('@Action@is',$methodName)){
                $routeList[$service][$version][$method]['methods'][]=str_replace('Action','',$methodName);
            }

        }

        return \apix\utils::dumpYaml($routeList,$serviceRouteListPath);

    }


    //set service route list
    public static function refreshServiceRouteList($project,$service,$version,$method,$class,$memory){


        $serviceRouteListPath=staticPathModel::getProjectPath($project).'/router.yaml';

        $routeList=[];
        if(file_exists($serviceRouteListPath)){
            $routeList=self::getYaml($serviceRouteListPath);
        }
        $class_methods = get_class_methods($class);


        foreach ($class_methods as $methodName){
            if($methodName!=='__construct' && preg_match('@Action@is',$methodName)){

                $methodName=str_replace('Action','',$methodName);

                if(count($routeList) && array_key_exists($service,$routeList) &&
                    array_key_exists($version,$routeList[$service]) &&
                    array_key_exists($method,$routeList[$service][$version])){

                    if(in_array($methodName,$routeList[$service][$version][$method]['methods'])){
                        $routeList[$service][$version][$method]['memory'][utils::cleanActionMethod(method)]=$memory;
                    }

                }

                if(count($routeList)===0 OR !array_key_exists($service,$routeList) OR !array_key_exists($version,$routeList[$service]) OR !array_key_exists($method,$routeList[$service][$version])){
                    $routeList[$service][$version][$method]['methods'][]=$methodName;
                    $routeList[$service][$version][$method]['memory'][$methodName]=$memory;
                }
            }

        }


        return self::dumpYaml($routeList,$serviceRouteListPath);

    }


    public static function symfonyProcess($command=null){
        if($command!==null){
            $process = new Process($command);
            $process->run();

            echo $process->getOutput();
        }
    }

    public static function getDeclarationYamlFile($project,$yaml){
        return staticPathModel::getProjectPath($project).'/declaration/history/'.$yaml.'';
    }


    //file process
    public static function fileprocess(){

        //file process new instance
        $libconf=require("".staticPathModel::$binCommandsPath."/lib/conf.php");
        $file=$libconf['libFile'];
        return new $file();

    }

    //file process
    public static function fileRead($path){

        //file process new instance
        $dt = fopen($path, "r");
        $content = fread($dt, filesize($path));
        fclose($dt);
        return $content;


    }


    //mkdir process result
    public static function fileProcessResult($data,$callback){

        if(count($data)==0 OR in_array(false,$data)){

            return 'project fail';
        }
        else {

            return call_user_func($callback);
        }

    }


    //fopen process
    public static function changeClass($class,$param=array()){

        $executionPath=$class;
        $dt = fopen($executionPath, "r");
        $content = fread($dt, filesize($executionPath));
        fclose($dt);

        foreach ($param as $key=>$value){
            $content=str_replace($key,$value,$content);
        }


        $dt = fopen($executionPath, "w");
        fwrite($dt, $content);
        fclose($dt);

        return true;
    }

    //get response type
    public static function responseOutType(){
        if(staticPathModel::getAppServiceBase()===null){
            $responseOutType='json';
        }
        else{
            $responseOutType=staticPathModel::getAppServiceBase()->response;
        }
        return $responseOutType;
    }

    //get response type
    public static function cleanActionMethod($method=null){
        if($method!==null){
            return str_replace('Action','',$method);
        }
        return null;
    }

    //get response type
    public static function convertPathFromNamespace($data){
        return root.''.str_replace('\\','/',$data);
    }

    //get class methods
    public static function getClassMethods($class=null,$type=false){
        if($class!==null){
            $methods=get_class_methods($class);

            if($type===false){
                return $methods;
            }
            $list=[];
            foreach($methods as $method){
                if(preg_match('@Action@is',$method)){
                    $list[]=static::cleanActionMethod($method);
                }
            }
            return $list;
        }

        return null;
    }

    //forever dir
    public static function foreverDirectory($directory,$arrayShow=true){
        if($arrayShow===false){
            return str_replace("\\","/",$directory);
        }
        return explode("/",str_replace("\\","/",$directory));
    }

    public static function removeDirectory($path) {
        // The preg_replace is necessary in order to traverse certain types of folder paths (such as /dir/[[dir2]]/dir3.abc#/)
        // The {,.}* with GLOB_BRACE is necessary to pull all hidden files (have to remove or get "Directory not empty" errors)
        $files = glob(preg_replace('/(\*|\?|\[)/', '[$1]', $path).'/{,.}*', GLOB_BRACE);
        foreach ($files as $file) {
            if ($file == $path.'/.' || $file == $path.'/..') { continue; } // skip special dir entries
            is_dir($file) ? self::removeDirectory($file) : unlink($file);
        }
        rmdir($path);
        return;
    }

    public static function convertNameSpaceFromPath($path){

        $withoutRoot=str_replace(root,'',$path);
        $signNameSpace=str_replace('/','\\',$withoutRoot);
        return str_replace('.php','',$signNameSpace);
    }


    public static function getGlobFile($path,$class=false,$extension='php'){

        $list=[];
        foreach (glob("".$path."/*.".$extension) as $file) {

            if($class===false){
                $list[]=$file;
            }
            else{
                $list[]=self::convertNameSpaceFromPath($file);
            }

        }

        return $list;
    }
}