<?php
namespace Devil\Solidprinciple\app\Traits;

use App\Sidebar\SideBar;
use App\Sidebar\SubLink;
use Illuminate\Support\Str;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

trait MakeSidebar
{
    use FileFolderManage,GetPath,GetStubContents;
    public function makeSidebar($data): void
    {
        $stub_path=__DIR__.'/../stubs';
        $model_data  = json_decode($data);
        $sidebar_config_sub_path= $stub_path.'/admin_view/sidebar_config.stub';
        $side_bar_content=[];
        $total_models= count($model_data);
        $destination_file=$this->path('config').'/sidebar.php';
        $is_exist_destination_file =file_exists($destination_file);
        foreach ($model_data as $key => $model){
            $side_bar = $model->sidebar[0];
            $model_name = ucfirst($model->model_name);
            $table_name = $model->table_name??strtolower(Str::plural($model->model_name));
            $route =strtolower(Str::plural($model->routes[0]));
            $icon=  explode('|', $model->sidebar[1])[1];
            $sub_links = explode(',',explode('=', $model->sidebar[2])[1]);
            if ($is_exist_destination_file) {
                $side_bar = config('sidebar');
                if (!isset($side_bar[$model_name])) {
                    $this->appendToSidebar(collect($model)->toArray());
                }
            }
            if ($side_bar){
                $side_bar_content += [
                    $model_name=>[
                        'icon'=>$icon,
                        'route'=>"",
                        'title'=>$model_name,
                        'class'=>'',
                        'visibility'=>true,
                        'permission'=>true,
                        'active'=>false,
                        "sub_link"=>[]
                    ],
                ];
                if (count($sub_links)>0)
                {
                    foreach ($sub_links as $sub_link){
                        $sub_route = "";
                        $sub_icon="";
                        $title= "";
                        $active=false;
                        if ($sub_link == 'create'){
                            $sub_icon = "fa-solid fa-plus";
                            $sub_route = "/admin/".$route.'/create';
                            $title= "Add ".$model_name;
                            $active ='$current_route'.' == "'.$sub_route.'"';
                        }elseif($sub_link == 'index'){
                            $sub_icon = "fa-solid fa-list";
                            $sub_route = "/admin/".$route;
                            $title= "List ".ucfirst($route);
                        }
                        $side_bar_content[$model_name]['sub_link']+=[
                            $sub_link=>[
                                'icon'=>$sub_icon,
                                'route'=>$sub_route,
                                'title'=>$title,
                                'visibility'=>true,
                                'permission'=>true,
                                'active'=>$active,
                            ]
                        ];
                    }
                }
            }
        }
        $side_bar_content =(array_merge($side_bar_content,['[solid_auto_generated_sidebar]'=>null]));
        $side_bar_content = str_replace(array("array (", ")"), array("[", "]"), var_export($side_bar_content, true));

        $sidebar_stub_content =$this->getStubContents($sidebar_config_sub_path,
            [
                'sidebar'=> $side_bar_content,
            ]);
        $this->makeFile( $destination_file, $sidebar_stub_content);
    }

    public function appendToSidebar($data){
        $is_data_array=(is_array($data) && isset($data[0]) && $data[0] )=='from_param'?false:true;
        $side_bar_path= base_path('config/sidebar.php');
//        dd(config('sidebar'));
         if (file_exists($side_bar_path)){
             $side_bar = config('sidebar');
//             dd($side_bar);
             if (is_array($data) && !isset($data[0])){
                 $model = ucfirst($is_data_array?$data['model_name']:$data);
             }else if(is_array($data) && isset($data[0]) && $data[0] =='from_param'){
                 $model = ucfirst(collect(json_decode($data[1]))->first()->model_name);
             }else{
                 $model = ucfirst($is_data_array?$data['model_name']:$data);
             }
          if (!isset($side_bar[$model])){
            $fileContent = file_get_contents($side_bar_path);
            $search = "'[solid_auto_generated_sidebar]' => NULL,";
            $main_title=$model;
            $main_visibility=confirm('Do you want to add model '.$model.' to Services?')?'true':'false';
            $main_permission='true';
            $main_active ='false';
            $sub_visibility='true';
            $sub_permission='true';
            $sub_active ='false';
            $sidebar_templete="
            '".$model."' =>
              [
                'icon' => 'fa-brands fa-product-hunt',
                'route' => '',
                'title' => '".$main_title."',
                'class' => '',
                'visibility' => ".$main_visibility.",
                'permission' => ".$main_permission.",
                'active' => ".$main_active.",
                'sub_link' =>
                [
                  'create' =>
                  [
                    'icon' => 'fa-solid fa-plus',
                    'route' => '',
                    'title' => 'Add ".$model."',
                    'visibility' => true,
                    'permission' => true,
                    'active' => '',
                  ],
                  'index' =>
                  [
                     'icon' => 'fa-solid fa-list',
                     'route' => '',
                     'title' => 'List ".$model."s',
                     'visibility' => ".$sub_visibility.",
                     'permission' => ".$sub_permission.",
                     'active' => ".$sub_active.",
                  ],
              ],
            ],".$search;
            $replace = $sidebar_templete;
            $modifiedContent = str_replace($search, $replace, $fileContent);
            if (($is_data_array && isset($data['sidebar']) && $data['sidebar'][0]) || !$is_data_array){
                file_put_contents($side_bar_path, $modifiedContent);
            }
//            $didebar=

                dd('kaushal');
//            Services::add(['Product','Category '])
//                ->icon()
//                ->route()
//                ->title()
//                ->class()
//                ->visibility()
//                ->permission()
//                ->subLinks(
//                    SUblinks::make('create')->icon()->route()->title()->visibility(),
//                    SUblinks::make('index')->icon()->route()->title()->visibility()
//                )

        }  // if not in array

    }// if file exist

    } //appendToSidebar function



}
