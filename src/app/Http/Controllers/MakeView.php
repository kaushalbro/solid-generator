<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetPath;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Illuminate\Support\Str;

class MakeView extends BaseController
{
    use FileFolderManage, GetStubContents,GetPath;

    protected $model_data;
    protected $stub_path;
    protected $controller_name;
    protected $view_path;
    public function __construct($model_data, $view_path)
    {
        parent::__construct();
        $this->model_data =is_array($model_data)?json_decode($model_data[1]):json_decode(file_get_contents($model_data));
        $this->view_path = $view_path;
        $this->stub_path =__DIR__.'/../../../stubs/view.stub';
        $this->make();
    }

    public function make(): void
    {
        $model_data  = $this->model_data;
        $view_path = $this->view_path."/";
        foreach ($model_data as $key => $model)
        {
                $model_name = $model->model_name;
                $view_input = $model->view_input;
                $view_folder_path = $view_path.strtolower($model_name);
                $partial_folder_path = $view_folder_path."/partial";
                $file_path =base_path($view_folder_path);
                $this->makeDirectory($view_folder_path);
                $this->makeDirectory($partial_folder_path);
                $form_view_stub= __DIR__.'/../../stubs/admin_view/model_views/form.stub';

                $admin_path = $this->path('view').'/backend/admin';
                $this->makeDirectory($admin_path.'/includes');
                $error_stub= __DIR__.'/../../stubs/admin_view/model_views/errors.stub';
                $errors_contents =$this->getStubContents($error_stub);
                $this->makeFile($admin_path.'/includes/'.'errors.blade.php', $errors_contents);
                $final_input_template = "";
                foreach ($view_input as $input){
                    try {
                        $label = str_replace("'", '', explode('=>',$input)[0]);
                        $input_tag = explode("|",explode('=>',$input)[1]);
                        $name = $input_tag[0];
                        $type = $input_tag[1];
                    }catch (\Exception $e){
                        dd($e);
                    };
                    $input_only = '';
                    if ($type=='text'){
                        $type='text';
                        $input_only='<input type="{{type}}" value="{{old("{{name}}")}}" name="{{name}}" class="form-control  col-10  {{name}} {{$errors->has("name")?"is-invalid":""}}" id="{{name}}" placeholder="{{lable}}">';
                    }elseif ($type=='float' || $type=='number'){
                        $type='number';
                        $input_only='<input type="{{type}}"  value="{{old("{{name}}")}}" name="{{name}}" class="form-control  col-10  {{$errors->has("name")?"is-invalid":""}}" id="{{name}}" placeholder="{{lable}}" step="any">';
                    }elseif ($type=='textarea'){
                        $input_only= '<textarea name="{{name}}" class="form-control col-10 {{$errors->has("{{name}}")?"is-invalid":""}}" rows="1" id="{{name}}" placeholder="{{lable}}">{{old("{{name}}")}}</textarea>';
                    }elseif ($type=='onOff'){
                        $type='checkbox';
                        $data_on= explode(':',$input_tag[2])[0];
                        $data_off= explode(':',$input_tag[2])[1];
                        $input_only=
                        '<input type="{{type}}" name="{{name}}" class="form-control  col-10  {{name}}" id="{{name}}"
                             data-toggle="toggle"
                             data-on="'.$data_on.'" data-off="'.$data_off.'" {{old("{{name}}")=="on"?"checked":""}} data-onstyle="primary" data-offstyle="danger">'
                          ;
                    }elseif($type=='select'){
                        $type='select';
                        $input_only='
                        <select name="{{name}}" id="{{name}}"  class="form-control  col-10 {{$errors->has("name")?"is-invalid":""}}">
                          <option value="" selected>Select {{lable}}</option>
                        </select>
                        ';
                    }elseif($type=='file'){
                        $type='file';
                        $input_only='<input  type="{{type}}" name="{{name}}" id="{{name}} formFileMultiple"  class=" col-10  {{$errors->has("name")?"is-invalid":""}}" multiple>';
                    }
                    $input_template=
                        '
                        <div class="col-md-6 d-flex mb-3">
                        <label for="{{name}}" class="col-2 text-left col-form-label">{{lable}}:</label>
                        '.$input_only.'
                        </div>';
                    $replace_name = str_replace("{{name}}",$name,$input_template);
                    $replace_lable = str_replace("{{lable}}",$label,$replace_name);
                    $replace_type = str_replace("{{type}}",$type,$replace_lable);
                    $final_input_template.=$replace_type;
                }
                $form_contents =$this->getStubContents($form_view_stub,[
                    'input'=>$final_input_template,
                ]);
                $this->makeFile($partial_folder_path."/form.blade.php", $form_contents);

                $files=['create','edit','index','show','script'];
                foreach ($files as $file){
                    $file_name=$view_folder_path."/".$file.".blade.php";
                    $model_view_stub= __DIR__.'/../../stubs/admin_view/model_views/'.$file.'.stub';
//                    if ($model_name =='Payment' && $file=='index'){
//                        dd($model_view_stub);
//                    }
                    if ($file == 'create' || $file == 'edit'){
                        $method= ($file == 'create')?'POST':"PUT" ;
                        $route_name = strtolower(Str::plural ($model_name)).'.'.($file == 'create'?'store':'update');
                        $contents =$this->getStubContents($model_view_stub,[
                            'classname'=> ucwords($model_name),
                            'action'=>$file,
                            'routeprefix'=>strtolower($model_name),
                            'method'=> $method,
                            'form_route'=>$route_name
                        ]);
                        $this->makeFile($file_name,$contents);
                    }else{
                        $attributes=[
                            'routeprefix'=>strtolower($model_name),
                        ];
                        if ($file == 'index' ) {
                        $attributes=[
                            'classname'=> ucwords($model_name),
                            'action'=>$file,
                            'datatable_list_route'=>"{{ route('".Strtolower(Str::plural ($model_name)).".list') }}",
                            'model_create_route'=>"{{ route('".Strtolower(Str::plural ($model_name)).".create') }}",
                            'table_headers'=>'',
                            'table_header_data'=>'',
                            'routeprefix'=>strtolower($model_name),
                        ] ;
                        }
                        if ($file == 'show' ) {
                            $attributes=[
                                'classname'=> ucwords($model_name),
                                'action'=>$file,
                                'routeprefix'=>strtolower($model_name),
                            ] ;
                        }
                        $contents =$this->getStubContents($model_view_stub,$attributes);
                        $this->makeFile($file_name,$contents);
                    }
                }

    //            $this->makeFile($this->dir_name.'/'.ucwords($model->model_name).'Controller.php', $contents);
        }

    }
}
