<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetPath;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Illuminate\Support\Str;

class MakeLayout extends BaseController
{ use FileFolderManage,GetStubContents,GetPath;

    protected $model_data;
    protected $stub_path;
    protected $model_data_path;
    protected $layout_type;

    public function __construct($layout_type, $model_data_path=null)
    {
        parent::__construct();
        $data =!$model_data_path?"":(is_array($model_data_path)?$model_data_path[1]:file_get_contents($model_data_path));
        $this->model_data = $data;
        $this->layout_type = $layout_type;
        $this->model_data_path = $model_data_path??"";
        $this->stub_path =__DIR__.'/../../stubs/layout_frontend';
        $this->make();
    }

    public function make(): void
    {
        $view_path=$this->path('view');
        $stub=$this->stub_path;
        $stub_files=scandir($stub);
        $includes_stub_files=scandir($stub."/includes");
        $filter_stub_files=array_filter($stub_files, function($value) {
            return strpos($value, '.stub') == true;
        });
        $filter_includes_stub_files=array_filter($includes_stub_files, function($value) {
            return strpos($value, '.stub') == true;
        });
        $include_folder=$view_path.'/'.$stub_files[2];
        $this->makeDirectory($include_folder);
        foreach ($filter_stub_files as $file_1){
            $this->makeFile($view_path.'/'.explode(".",$file_1)[0].'.blade.php', $this->getStubContents($stub."/".$file_1));
        }
        foreach ($filter_includes_stub_files as $file_2){
            $this->makeFile($view_path.'/includes/'.explode(".",$file_2)[0].'.blade.php', $this->getStubContents($stub."/includes/".$file_2));
        }
    }
}
