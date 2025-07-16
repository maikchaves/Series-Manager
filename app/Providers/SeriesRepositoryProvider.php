<?php

namespace App\Providers;

use App\Repositories\EloquentSeriesRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Support\ServiceProvider;

class SeriesRepositoryProvider extends ServiceProvider
{
    
    public array $bindings = [
        SeriesRepository::class => EloquentSeriesRepository::class,
    ];

    /*
    O atributo $bindings faz exatamente a mesma coisa que criar esse app->bind dentro de register
    public function register()
    {
        $this->app->bind(SeriesRepository::class, EloquentSeriesRepository::class);
    }
*/
}
