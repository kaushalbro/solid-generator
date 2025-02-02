<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Illuminate\Routing\Controller;


class MakeConfig extends BaseController
{
    use FileFolderManage,GetStubContents;
    protected $stub_path;
    public function __construct()
    {
        parent::__construct();
        $this->stub_path =__DIR__.'/../../stubs/config.stub';
        $this->make();
    }

    public function make(): void
    {
        $default_path=['model_path','controller_path','repo_path','frontend_view_path'];
        $config_contents =$this->getStubContents($this->stub_path);
        $this->makeFile("config/solid.php",$config_contents);
    }

}
