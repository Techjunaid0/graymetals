<?php

/**
 * @Author: Muhammad Umar Hayat
 * @Date:   2019-01-16 13:22:15
 * @Last Modified by:   Muhammad Umar Hayat
 * @Last Modified time: 2019-02-08 19:38:05
 */
namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Currency;

class CurrencyComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currencies', Currency::all());
    }
}