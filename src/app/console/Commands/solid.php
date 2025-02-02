<?php

namespace Devil\Solidprinciple\app\console\Commands;

use Devil\Solidprinciple\app\Http\Controllers\OptionController;
use Illuminate\Console\Command;

class solid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //interface-repo-model-migration-request
    //{id? : this is id} here ? means optional while making arguments, after : this is description of argument
    //flag/options {--h|help} here --h also shows help --help also shows help

    protected $signature = 'solid:make {model_name? : Optional model_name parameter}
                         {--config|config : Generate Package configuration }
                         {--crud|crud : Generate Plain CRUD files }
                         {--repo-crud|repo-crud : Generate CRUD files for Repository design pattern }
                         {--m|model : Generate model}
                         {--api|api : Generate api resources}
                         {--view|view : Generate model}
                         {--c|controller : Generate Controller }
                         {--i|interface : Generate interface}
                         {--re|repo  : Generate repository}
                         {--mi|migration  : Generate migration}
                         {--r|request : Generate custom request}
                         {--ro|route : Generate routes}
                         {--layout|layout  } layout_type? : Generate Layout}
                         {--newAdminPanel|new-admin-panel : Generate fresh Admin panel}
                         {--publish|publish : Generate Publish files }
                         {--h|help}
                         {--t|test}

                         ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Solid principle make interface repo model migration and custom request';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $optionController = new OptionController($this->options(),$this->arguments());
            $optionController->chooseOption();
        }catch (\Exception $exception){
            $this->error($exception->getMessage());
        }
    }
}
