<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'instruction.consignment_modal', 'App\Http\View\Composers\ConsigneeComposer'
        );
        View::composer(
            'instruction.items_modal', 'App\Http\View\Composers\CurrencyComposer'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
