<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;


class MakeInterface extends BaseController
{
    use FileFolderManage,GetStubContents;
    protected mixed $interfaceName;
    protected string $stub_path;
    protected mixed $dir_name='app/Interfaces';
    public function __construct($interfaceName)
    {
        parent::__construct();
        if (config('solid.interface_path')) $this->dir_name=config('solid.interface_path');
        $this->interfaceName = $interfaceName;
        $this->stub_path =__DIR__.'/../../stubs/interface.stub';
        $this->make();
    }
    public function make(): void
    {
             $this->makeDirectory($this->dir_name);
             $contents =$this->getStubContents($this->stub_path, [
                 'namespace' => $this->pathToNameSpace($this->dir_name),
                 'classname'=> $this->interfaceName]);
             $this->makeFile($this->dir_name.'/'.$this->interfaceName.'.php', $contents);
    }

}
