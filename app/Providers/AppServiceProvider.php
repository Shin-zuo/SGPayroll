<?php

namespace SGpayroll\Providers;

<<<<<<< HEAD
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
=======
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use ReflectionClass;
>>>>>>> branch1

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
<<<<<<< HEAD
        //
        Schema::defaultStringLength(191);
=======
        Schema::defaultStringLength(191);

        if (env('DB_CONNECTION') === 'pgsql') {
            $grammar = DB::connection()->getSchemaGrammar();

            if ($grammar instanceof PostgresGrammar) {
                $reflection = new ReflectionClass($grammar);
                $property = $reflection->getProperty('transactions');
                $property->setAccessible(true);
                $property->setValue($grammar, false);
            }
        }
>>>>>>> branch1
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
