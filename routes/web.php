<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/cache', function () {

    \Illuminate\Support\Facades\Artisan::call('key:generate');
//    \Illuminate\Support\Facades\Artisan::call('vendor:publish --provider=Maatwebsite\Excel\ExcelServiceProvider');
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('migrate');

    return 'Commands run successfully.';
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('consignee', 'ConsigneeController');
    Route::resource('carriers', 'CarrierController');
    Route::resource('contracts', 'ContractController');
    Route::resource('consignment', 'ConsignmentController');
    Route::resource('consignment_detail', 'ConsignmentDetailController');
    Route::resource('notify_party', 'NotifyPartyController');
    Route::resource('port', 'PortController');
    Route::resource('shipper', 'ShipperController');
    Route::resource('shipping_co', 'ShippingCoController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('instruction', 'InstructionController');
    Route::resource('reports', 'ReportingController');

    Route::name('ajax.')->prefix('ajax')->group(function () {
        Route::get('getStates/{country_id}', 'AjaxController@getStates')->name('get_states');
        Route::get('getCitiesByCountry/{country_id}', 'AjaxController@getCitiesByCountry')->name('get_cities_by_country');
        Route::get('getCitiesByState/{state_id}', 'AjaxController@getCitiesByState')->name('get_cities_by_state');
        Route::get('getEmail/{email_id}', 'AjaxController@getEmail')->name('get_email');
        Route::put('emailRead/{email_id}', 'AjaxController@emailRead')->name('email_read');
        Route::post('newEmail', 'AjaxController@newEmail')->name('new_email');
        Route::post('forwardEmail', 'AjaxController@forwardEmail')->name('forward_email');
        Route::post('replyEmail', 'AjaxController@replyEmail')->name('reply_email');
        Route::post('emailInvoice', 'AjaxController@emailInvoice')->name('email_invoice');
        Route::post('emailDocuments', 'AjaxController@emailDocuments')->name('email_documents');
        Route::get('instruction/{id}/invoice/download', 'AjaxController@downloadInvoice')->name('download_invoice');
        Route::get('instruction/{id}/si/download', 'AjaxController@downloadSI')->name('download_si');
        Route::get('instruction/{id}/vgm/download', 'AjaxController@downloadVGM')->name('download_vgm');
        Route::post('instruction/{id}/items/save', 'AjaxController@saveItems')->name('save_items');
        Route::put('instruction/{id}/consignee/save', 'AjaxController@saveConsignee')->name('save_consignee');
        Route::put('instruction/{id}/notify/save', 'AjaxController@saveNotify')->name('save_notify');
        Route::post('bookingConfirmation', 'AjaxController@bookingConfirmation')->name('booking_confirmation');
        Route::post('trackingInfo', 'AjaxController@trackingInfo')->name('tracking_info');
        Route::get('getConsignment/{instruction_id}', 'AjaxController@getConsignment')->name('get_consignment');
        Route::get('getTrackingUrl//{carrier_id}', 'AjaxController@getTrackingURL')->name('get_tracking_url');
    });

    /* Extra Functions Routes */
    Route::get('instruction/{id}/email', 'InstructionController@emails')->name('instruction.emails');
    Route::get('instruction/{id}/email/{email_id}', 'InstructionController@showEmail')->name('instruction.email.show');
    Route::get('instruction/{id}/consigment', 'InstructionController@consignment')->name('instruction.consignment');
    Route::get('instruction/{id}/complete', 'InstructionController@complete')->name('instruction.complete');
    Route::get('report/download', 'ReportingController@downloadReport')->name('reports.download');

});

/**
 * Webhook Routes
 */
Route::post('webhook/receive_email','WebhookController@receiveEmail');

Route::get('profile', 'UserController@index');
Route::get('profile/create', 'UserController@create');
Route::post('profile/store', 'UserController@store');
Route::get('profile/show/{id}', 'UserController@show');
Route::get('profile/edit/{id}', 'UserController@edit');
Route::post('profile/update/{id}', 'UserController@update');
Route::delete('profile/destroy/{id}', 'UserController@destroy');

// Route::get('download/excel', 'ExportExcelController@export');
// Route::post('download/excel', 'ExportExcelController@export');
// Route::get('download/excel/file', 'ExportExcelController@excel');
Route::get('container', 'ConsignmentController@index');
Route::post('container/excel', 'ConsignmentController@export');
Route::get('consignee-wise', 'ConsigneeController@showConsignee');
Route::post('consignee-wise/excel', 'ConsigneeController@export');
Route::get('report/contract', 'EtaController@index')->name('reports.contract');
Route::post('eta/excel', 'EtaController@export');
Route::get('item', 'ConsignmentDetailController@index');
Route::post('item/excel', 'ConsignmentDetailController@export');
