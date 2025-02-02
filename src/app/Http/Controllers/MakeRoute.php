<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Illuminate\Support\Str;

class MakeRoute extends BaseController
{
    use FileFolderManage, GetStubContents;

    protected $model_data;
    protected $stub_path;
    protected $dir_name;

    public function __construct($model_data)
    {
        parent::__construct();
        $this->model_data= $model_data;
        $this->stub_path =__DIR__.'/../../stubs/route.stub';
        $this->dir_name='routes';
        $this->make();
    }

    public function make(): void
    {
        $this->makeDirectory($this->dir_name);
        $model_data = json_decode($this->model_data);

        foreach ($model_data as $key => $model) {
            $routes = $model->routes;
            $table_name=$model->table_name??strtolower(Str::plural($model->model_name));
            if (count($routes)>0){
                $current = file_get_contents($this->dir_name.'/web.php');
                $current .= 'Route::resource("'.$table_name.'",'.$model->model_name.'Controller::class);'."\n";
                file_put_contents($this->dir_name.'/web.php', $current);
            }
        }
    }

}
