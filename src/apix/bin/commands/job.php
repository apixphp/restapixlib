<?php namespace apix\bin\commands;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class job extends Console {

    public $fileprocess;

    public function __construct(){

        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){

        $dirQueue='apix';
        $list=[];

        foreach ($data as $key=>$value){
            $project=$key;
            $dir=$value;
        }

        define('app',$project);
        define('version',utils::getAppVersion($project));

        $appOptionalJobDir=staticPathModel::getProjectPath($project).'/'.utils::getAppVersion($project).'/optional/jobs';
        $apixPath=$appOptionalJobDir.'/'.$dirQueue;
        if(!file_exists($apixPath)){
            $list[]=$this->fileprocess->mkdir_path($apixPath);
        }


        if(!file_exists($apixPath.'/'.$dir)){

            $list[]=$this->fileprocess->mkdir_path($apixPath.'/'.$dir);

            $touchServiceApixPublisher['execution']='queue_task';
            $touchServiceApixPublisher['params']['projectName']=$project;
            $touchServiceApixPublisher['params']['version']=utils::getAppVersion($project);
            $touchServiceApixPublisher['params']['dir']=$dir;
            $touchServiceApixPublisher['params']['queueName']=$dirQueue;
            $list[]=$this->fileprocess->touch_path($apixPath.'/'.$dir.'/task.php',$touchServiceApixPublisher);


            return utils::fileProcessResult($list,function() use($project,$dir) {
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->classical('Queue (Job Process) Has Been Successfully Created Named '.$dir.' ');
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->success('You can run via cli "php api job run '.$project.' '.$dir.'"');
                echo $this->info('------------------------------------------------------------------------------');

                $yaml = Yaml::dump([$dir.'Queue'=>[

                ]]);

                file_put_contents(staticPathModel::getStoragePath(true).'/jobs/'.$dir.'.yaml', $yaml);
            });
        }
        else{
            return $this->error('Queue named '.$project.'/'.$dir.' is already available');
        }


    }


    //project create command
    public function run ($data){

        $list=array_keys($data);
        define ('app',$list[0]);
        define ('queue',$list[1]);
        define ('version',utils::getAppVersion($list[0]));

        if(array_key_exists(2,$list)){
            return $this->queueApixRun();
        }
        else{
            return $this->nohupApix();
        }
    }
    
    public function nohupApix(){

        $process = new Process('nohup php api job run '.app.' '.queue.' subscriber > '.root.'/src/app/'.app.'/'.utils::getAppVersion(app).'/optional/jobs/apix/'.queue.'/nohup 2>&1 & echo $! > '.root.'/src/app/'.app.'/'.utils::getAppVersion(app).'/optional/jobs/apix/'.queue.'/save_pid.txt');
        $process->run();

        echo $process->getOutput();
        echo $this->info('++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
        echo $this->info('++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
        echo $this->classical('Queue (Job Process) Named '.queue.' is working now ');
        echo $this->info('++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
        echo $this->info('++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
    }


    public function queueApixRun(){

        $nameSpace=StaticPathModel::getJobPath().'\\apix\\'.queue.'\\task';
        if(class_exists($nameSpace)){
            while(1){
                utils::resolve($nameSpace)->execute();
                sleep(5);
            }
        }

    }
}