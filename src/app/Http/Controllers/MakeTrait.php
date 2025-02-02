<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;

class MakeTrait extends BaseController
{
    use FileFolderManage,GetStubContents;
    protected $traitName;
    protected $stub_path;
    protected $dir_name;
    public function __construct($traitName)
    {
        parent::__construct();
        $this->traitName = $traitName;
        $this->stub_path =__DIR__.'/../../Traits/stubs/'.$traitName.'.stub';
        $this->dir_name='app/Traits';
        $this->make();
    }

    public function make(): void
    {
        $this->makeDirectory($this->dir_name);
        $contents =$this->getStubContents($this->stub_path,
                ['namespace' => $this->pathToNameSpace($this->dir_name)]
        );
        $this->makeFile($this->dir_name.'/'.$this->traitName.'.php', $contents);
    }
}
