<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;


class MakeComponents extends BaseController
{
    use FileFolderManage,GetStubContents;
    protected $componentName;

    protected $stub_path;

    protected $dir_name='components';

    public function __construct()
    {
        parent::__construct();
        $this->componentName = 'actionButtons.blade.php';
        $this->stub_path =__DIR__.'/../../stubs/components/actionButtons.blade.php';
        $this->make();
    }

    public function make(): void
    {
        $fileDIRPath= 'resources/views/'.$this->dir_name;
        $this->makeDirectory($fileDIRPath);
        $contents =$this->getStubContents($this->stub_path, [
            'namespace' => $this->pathToNameSpace('app/'.$this->dir_name),
            'classname'=> $this->componentName]);
        $this->makeFile($fileDIRPath.'/'.$this->componentName, $contents);
    }

}
