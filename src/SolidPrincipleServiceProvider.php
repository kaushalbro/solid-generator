<?php
namespace Devil\Solidprinciple;
use Devil\Solidprinciple\app\console\Commands\solid;
use Devil\Solidprinciple\app\Services\SideBar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
class SolidPrincipleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (file_exists(app_path("Providers/SolidAppServiceProvider.php")))
               $this->app->register(\App\Providers\SolidAppServiceProvider::class);
        $this->app->singleton('sidebar', function () {
            try {
              return SideBar::getSidebarMetadata();
            }catch (\Exception $exception){
                return ['error' => $exception->getMessage()];
            }
        });
    }
    public function boot(): void
    {
      if (config("solid.carbon_immutable")) Date::use(CarbonImmutable::class);
      $this->loadViewsFrom(__DIR__.'/../resources/view', 'solid');
      $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
      $this->publishes([
          __DIR__ . '/provider/app.stub' => base_path('app/Providers/SolidAppServiceProvider.php'),
          __DIR__ . '/provider/model_schema_json.json' => base_path('model_schema_json.json'),
          __DIR__ . '/routes/route.php' =>base_path('routes/solid.php'),
          __DIR__ . '/app/stubs/config.stub' =>config_path("solid.php")
      ], 'solid-app');
      if (file_exists(base_path('routes/solid.php'))){
          $this->loadRoutesFrom(base_path('routes/solid.php'));
      }
        $this->commands([solid::class]);
      Artisan::call("optimize:clear");
    }

}
