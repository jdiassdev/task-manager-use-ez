<?php

namespace App\Providers;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\EloquentProjectRepository;
use App\Repositories\EloquentTaskRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, EloquentProjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // descomentar para logar as queries no arquivo de log
        
        // if (config('app.debug')) {
        //     DB::listen(fn ($query) => Log::debug('SQL', [
        //         'sql'      => $query->sql,
        //         'bindings' => $query->bindings,
        //         'time'     => $query->time . 'ms',
        //     ]));
        // }
    }
}
