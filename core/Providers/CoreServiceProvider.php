<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class CoreServiceProvider extends ServiceProvider
{
  public function boot(): void
  {
    $this->loadCoreHelpers();
    $this->loadCoreRoutes();
    $this->loadCoreCommands();
    $this->loadCoreMigrations();
  }

  private function loadCoreHelpers(): void
  {
    $helpers = base_path('core/Helpers/helpers.php');

    if (file_exists($helpers)) {
      require_once $helpers;
    }
  }

  private function loadCoreRoutes(): void
  {
    $routesPath = base_path('core/routes/api_core.php');

    if (file_exists($routesPath)) {
      Route::middleware(['api'])
        ->prefix('api')
        ->group($routesPath);
    }
  }

  private function loadCoreCommands(): void
  {
    $this->commands([
      \Core\Commands\ResetDatabase::class,
    ]);
  }

  private function loadCoreMigrations(): void
  {
    $migrationsPath = base_path('core/database/migrations');

    if (is_dir($migrationsPath)) {
      $this->loadMigrationsFrom($migrationsPath);
    }
  }
}
