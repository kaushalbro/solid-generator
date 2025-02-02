<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Illuminate\Support\Str;

class MakeModel extends BaseController
{
    use FileFolderManage,GetStubContents;
    protected $model_data;
    protected $stub_path;
    protected $dir_name="app/Models";
    protected $model_data_path;

    public function __construct($model_data_path)
    {
        parent::__construct();
        $data =is_array($model_data_path)?$model_data_path[1]:file_get_contents($model_data_path);
        $this->model_data =$data;
        $this->model_data_path = $model_data_path;
        $this->stub_path =__DIR__.'/../../stubs/model.stub';
        $this->dir_name= config('solid.model_path')?:$this->dir_name;
        $this->make();
    }

    public function make(): void
    {
        $json_model_details= $this->model_data;
       $model_data  = json_decode($json_model_details);
      foreach ($model_data as $key => $model){
          $fillables= [];
          foreach ($model->model_attributes->db_rules as $fillable){
              $fillables[] = explode(':', $fillable)[0];
          }
          $fillable = $this->removeDoubleQuote($fillables);
          $hidden = $this->removeDoubleQuote($model->model_variables->hidden ?? []);
          $casts = $this->removeDoubleQuote($model->model_variables->casts ?? []);
          $with = $this->removeDoubleQuote($model->model_variables->with ?? []);
          $contents =$this->getStubContents($this->stub_path,[
            'namespace' => $this->pathToNameSpace($this->dir_name),
            'classname'=> $model->model_name,
            'table_name'=> $model->table_name??strtolower(Str::plural($model->model_name)),
            'fillable'=>$fillable,
            'hidden'=>$hidden,
            'casts'=>$casts,
            'with'=>$with
          ]);
        $this->makeFile($this->dir_name.'/'.$model->model_name.'.php', $contents);
      }
//      new MakeController(['Admin'], 'Admin');
    }
}
