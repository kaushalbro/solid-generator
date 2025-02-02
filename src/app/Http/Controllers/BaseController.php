<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\HelperTrait;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use HelperTrait;
    public $laravel_10;
    public $laravel_11;
    public $is_api;
    public $repo_pattern;
    public $api_with_resource_classes;
    public $is_api_without_api_with_resource_classes;
    public $is_api_with_api_resource_classes;
    public $custom_request;

    public function __construct(){
//        These are stub conditions
        $this->laravel_10 = (int) app()->version() < 11;
        $this->laravel_11 = (int) app()->version() >= 11;
        $this->is_api = config('solid.is_api')??false;
        $this->custom_request = config('solid.custom_request')??false;
        $this->repo_pattern = (config('solid.design_pattern')??'')=='repository' || (config('solid.design_pattern')??'')=='Repository';
        $this->api_with_resource_classes= config('solid.api_with_resource_classes')??false;
        $this->is_api_without_api_with_resource_classes = $this->is_api && !$this->api_with_resource_classes;
        $this->is_api_with_api_resource_classes = $this->is_api?$this->is_api && $this->api_with_resource_classes:$this->is_api;
    }
//    public function stubConditions($only=[]): array
//    {
//        $condition = [
//            'laravel_11'=>$this->laravel_11,
//            'laravel_10'=>$this->laravel_10,
//            'is_api'=>$this->is_api,
//            'custom_request'=>$this->custom_request,
//            'repo_pattern'=>$this->repo_pattern,
//            'is_api_without_api_with_resource_classes'=>$this->is_api_without_api_with_resource_classes,
//            'is_api_with_api_resource_classes'=>$this->is_api_with_api_resource_classes
//        ];
//        foreach($condition as $name=>$value){
//            if (!in_array('all', $only) && !in_array($name,$only)) unset($condition[$name]);
//        }
//        return $condition;
//
//    }
}
