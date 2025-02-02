<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Http\Controllers\Admin\MakeAdminPanelController;
use Devil\Solidprinciple\app\Traits\CheckConfigFile;
use Devil\Solidprinciple\app\Traits\GetPath;
use Devil\Solidprinciple\app\Traits\HelperTrait;
use Devil\Solidprinciple\app\Traits\MakeSidebar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class OptionController extends BaseController
{
    use CheckConfigFile,GetPath, MakeSidebar, HelperTrait;
    protected $options;
    protected $arguments;
    protected  $solid_command="solid:make";
    public function __construct($options,$arguments)
    {
        parent::__construct();
        $this->options=$options;
        $this->arguments=$arguments;
    }
    public function chooseOption()
    {
        Artisan::call("optimize:clear");
        if (!$this->options['config']){
            $this->checkConfig();
        }else{
            new MakeConfig();
        }
        if (!file_exists(config('solid.model_schema_json_path'))){
            error_log(sprintf("\033[31m%s\033[0m", config('solid.model_schema_json_path')." => Raw data file not found in the path "));
            return exit();
        }
        $data_path=config('solid.model_schema_json_path');
        $model_name = $this->arguments['model_name'];
//        if (!$model_name)
//            return error_log(sprintf("\033[31m%s\033[0m",  "Model name or flags is required. "));
        new MakeTrait('FileManager');
        if ($this->is_api){
            new MakeTrait('Api_Response');
        }
        switch ($this->options) {
            case $this->options['test']:
                new MakeAdminPanelController($data_path);
                break;
            case $this->options['publish']:
                Artisan::call('vendor:publish --tag=solidRoutes');
                Artisan::call('vendor:publish --tag=solidAppServiceProvider');
                break;
            case $this->options['config']:
                new MakeConfig();
                break;
            case $this->options['interface']:
                if ($this->repo_pattern)
                   new MakeInterface(config('solid.base_interface_name'));
                break;
            case $this->options['repo']:
                if ($this->repo_pattern)
                   new MakeRepo(config('solid.base_repository_name'));
                break;
            case $this->options['model']:
                if ($model_name){
                    new MakeModel($this->makeModelRepoCrud($model_name));
                }
                break;
            case $this->options['api']:
                    new MakeApiResources($model_name?( $this->makeModelRepoCrud($model_name)):$data_path);
                break;
            case $this->options['controller']:
                if ($model_name){
                    new MakeController($this->makeModelRepoCrud($model_name));
                }
                break;
            case $this->options['request']:
                if ($model_name){
                    new MakeRequest($this->makeModelRepoCrud($model_name));
                }
                break;
            case $this->options['migration']:
                if ($model_name){
                    new MakeMigration($this->makeModelRepoCrud($model_name));
                }
                break;
            case $this->options['route']:
                new MakeRoute('route');
                break;
            case $this->options['view']:
                if ($model_name){
                    new MakeComponents();
                    new MakeView($this->makeModelRepoCrud($model_name), $this->path('view_admin'));
                }
                break;
            case $this->options['layout']:
                // for frontend
                new MakeComponents();
                new MakeLayout(($model_name=='frontend'||$model_name=='admin')?$model_name:"frontend",$data_path);
                break;
            case $this->options['new-admin-panel']:
                Artisan::call('solid:make --layout');
                Artisan::call('solid:make --repo');
                Artisan::call('solid:make --interface');
                if ($this->is_api) Artisan::call('solid:make --api');
                new MakeComponents();
                new MakeAdminPanelController($data_path);
                break;
            case $this->options['crud']:
                // creates crud for model
                $this->makeRepoCrud($model_name?( $this->makeModelRepoCrud($model_name)):$data_path);
                if ($this->is_api_with_api_resource_classes){
                    Artisan::call('solid:make --api');
                }
                break;
            default:
                if ($model_name){
                    $this->makeRepoCrud($model_name?( $this->makeModelRepoCrud($model_name)):$data_path);
                }
                exit();
        }

    }
    public function makeRepoCrud($data_path): void
    {
        if ($this->repo_pattern){
            //Generating Base Interface for Base Repository
            new MakeInterface(config('solid.base_interface_name'));
            //Generating Base Repository for Model Repository
            new MakeRepo(config('solid.base_repository_name'));
            //Generating Models
        }
        new MakeModel($data_path);
        //Generating Model's Repositories
        if ($this->repo_pattern){
            new MakeModelRepo($data_path);
        }
        //Generating Custom Request
        new MakeRequest($data_path);
        //Generating Controller
        new MakeController($data_path);
        //Generating Migrations
        new MakeMigration($data_path);
        //Generating View
        if (!$this->is_api){
            new MakeView($data_path, $this->path('view_admin'));
//            new MakeView(is_array($data_path)?$data_path:file_get_contents($data_path), $this->path('view_admin'));
        }
        $this->appendToSidebar($data_path);
        //Generating Routes
        //new MakeRoute($data_path);
    }

    public function makeModelRepoCrud($model_name): array
    {
        if ($model_name){
            $model_name_formated =ucfirst(Str::singular($model_name));
            $table_name = strtolower(Str::plural($model_name));
            return ['from_param','
                [ {
                    "model_name": "'.$model_name_formated.'",
                    "table_name": "'.$table_name.'",
                    "fillable":[],
                    "hidden": [],
                    "casts": [],
                    "with": [],
                    "sidebar": [false, "", ""],
                    "table_column_name": [],
                    "routes": [],
                    "request_rules":[],
                    "view_input":[]
                   }
                ]'];
        }
       return [];
    }
}
