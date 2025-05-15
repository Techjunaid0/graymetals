<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Validate ExistsInDatabase or 0/null
         */
        \Validator::extend(
            'exists_or_null',
            function ($attribute, $value, $parameters)
            {
                if($value == 0 || is_null($value)) 
                {
                    return true;
                } 
                else 
                {
                    $validator = \Validator::make([$attribute => $value], [
                        $attribute => 'exists:' . implode(",", $parameters)
                    ]);
                    return !$validator->fails();
                }
            }
        );
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
