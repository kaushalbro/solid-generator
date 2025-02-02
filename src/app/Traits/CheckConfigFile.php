<?php

namespace Devil\Solidprinciple\app\Traits;

use Illuminate\Support\Facades\Artisan;

trait CheckConfigFile
{
    public function checkConfig()
    {
            if (!config('solid')) {
                 error_log(sprintf("\033[31m%s\033[0m", "solid.php Configuration file is required. \nCommand to generate Config file: "). sprintf("\033[33m%s\033[0m", " php artisan solid:make --config"));
                echo "Generate Solid Config File (y/n): ";
                $input = rtrim(fgets(STDIN));
                if ($input == 'y' || $input == 'Y'){
                    Artisan::call('solid:make --config');
                    echo "Solid Config File Generated  Successfully at : \config\solid.php";
                }else{
                    echo "Exit.\n";
                    return exit();
                }
                return exit();
            }

    }

}
