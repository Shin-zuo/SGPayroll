<?php

namespace SGpayroll\Providers;

if (!function_exists('lang_path')) {
    /**
     * Get the path to the language folder.
     *
     * @param  string  $path
     * @return string
     */
    function lang_path($path = '')
    {
        return resource_path('lang' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}

if (!function_exists('now')) {
    /**
     * Get a Carbon instance for the current date and time.
     *
     * @param  \DateTimeZone|string|null  $tz
     * @return \Carbon\Carbon
     */
    function now($tz = null)
    {
        return \Carbon\Carbon::now($tz);
    }
}

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use ReflectionClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
