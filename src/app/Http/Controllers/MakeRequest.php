<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;

class MakeRequest extends BaseController
{
    use FileFolderManage, GetStubContents;

    protected $model_data;

    protected $stub_path;

    protected $dir_name="app/Http/Requests";
    public function __construct($model_data_path)
    {
        parent::__construct();
        $data =is_array($model_data_path)?$model_data_path[1]:file_get_contents($model_data_path);
        $this->model_data =$data;
        $this->stub_path =__DIR__.'/../../stubs/request.stub';
        $this->dir_name=config("solid.request_path")?:$this->dir_name;
        if ($this->is_api){
            $this->dir_name=$this->dir_name.'/API';
            $this->makeDirectory($this->dir_name);
        }
        $this->make();
    }

    public function make(): void
    {
        $model_data  = json_decode($this->model_data);
        foreach ($model_data as $key => $model){
            $model_name = $model->model_name;
            $request_rules = $model->model_attributes->request_rules;
            $rules_count = count($request_rules);
            $rules = "["."\n\t\t\t";
            if ($rules_count == 0){
                $rules.="]";
            }else{
                foreach ($request_rules as $key_1=>$rule){
                    $attributes= explode('|',$rule);
                    $aa= explode(':',array_shift($attributes));
                    $fillable_variable = $aa[0];
                    $fillable_rule = implode('|',array_merge(array($aa[1]),$attributes));
                    if ($key_1 == $rules_count-1) {
                        $rules .= "\n\t\t\t'".$fillable_variable."' => "."'".$fillable_rule."',\n"."\n\t\t\t]";
                    }else{
                        $rules .= "\n\t\t\t'".$fillable_variable."' => "."'".$fillable_rule."',";
                    }
                }
            }
//            $name_space= $this->is_api?'App\\Http\\Requests\\API':'App\\Http\\Requests';
            $contents =$this->getStubContents($this->stub_path,[
                'namespace' => $this->pathToNameSpace($this->dir_name),
                'classname' => ucwords($model_name),
                'rules'=>$rules,
                'stub_conditions'=>['is_api'=>$this->is_api]
            ]);
            $this->makeFile($this->dir_name.'/'.'Create'. ucwords($model->model_name).'Request.php', $contents);
        }
    }
}
