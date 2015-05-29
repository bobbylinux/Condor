<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Lib\Storage\Categoria\CategoriaRepository', 'App\Lib\Storage\Categoria\EloquentCategoriaRepository');
    }
}
