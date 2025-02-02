<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Psy\Util\Str;

class MakeController extends BaseController
{
    use FileFolderManage, GetStubContents;

    protected $model_data;
    protected $stub_path;
    protected $dir_name = '/app/Http/Controllers';
    protected $controller_name;
    protected $folder;

    public function __construct($model_data_or_path, $folder=null)
    {
        parent::__construct();
        if (config('solid.controller_path')) $this->dir_name = config('solid.controller_path');
        if (is_array($model_data_or_path) && ($model_data_or_path[0] != 'from_param')){
          $this->controller_name = $model_data_or_path[0];
        }else{
            $data =is_array($model_data_or_path)?$model_data_or_path[1]:file_get_contents($model_data_or_path);
            $this->model_data =$data;
        }
        $this->folder = $folder;
        $this->stub_path = $folder=='Admin'?(__DIR__.'/../../stubs/admincontroller.stub'):(__DIR__.'/../../stubs/controller.stub');;
        $this->dir_name=$folder?($this->dir_name.'/'.$folder):$this->dir_name;

        $this->make();
    }

    public function make(): void
    {
        $this->makeDirectory($this->dir_name);
        if ($this->model_data){
            $model_data  = json_decode($this->model_data);
            foreach ($model_data as $key => $model){
                $model_name = $model->model_name;
                $contents =$this->getStubContents($this->stub_path,[
                    'namespace' => $this->pathToNameSpace($this->dir_name),
                    'rootNamespace'=>'App\\',
                    'classname'=> ucwords($model_name),
                    'reponame'=> strtolower($model_name),
                    'viewfolder'=>strtolower($model_name),
                    'stub_conditions'=>[ //order should be matched
                        'is_api_with_api_resource_classes'=>$this->is_api_with_api_resource_classes,
                        'is_api'=>$this->is_api,
                        'repo_pattern'=>$this->repo_pattern,
                        'laravel_11'=>$this->laravel_11,
                        'laravel_10'=>$this->laravel_10,
                        'is_api_without_api_with_resource_classes'=>$this->is_api_without_api_with_resource_classes,
                    ],
                ]);
                $this->makeFile($this->dir_name.'/'.ucwords($model->model_name).'Controller.php', $contents);
            }
        }else{
            $contents =$this->getStubContents($this->stub_path,[
                'namespace' =>$this->folder
                                ?$this->pathToNameSpace($this->dir_name.'/'.$this->folder)
                                :$this->pathToNameSpace($this->dir_name),
                'classname'=> ucwords($this->controller_name),
                'viewfolder'=>strtolower($this->controller_name),
                'reponame'=> '',
                'stub_conditions'=>['is_api'=>$this->is_api, 'repo_pattern'=>$this->repo_pattern]
            ]);
            $this->makeFile($this->dir_name.'/'.ucwords($this->controller_name).'Controller.php', $contents);
        }
    }
}
