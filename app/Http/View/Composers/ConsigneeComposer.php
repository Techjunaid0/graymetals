<?php

/**
 * @Author: Muhammad Umar Hayat
 * @Date:   2019-01-16 13:22:15
 * @Last Modified by:   Muhammad Umar Hayat
 * @Last Modified time: 2019-01-16 15:34:41
 */
namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Consignee;

class ConsigneeComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('consignees', Consignee::all());
    }
}