<?php

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

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

Route::group(['middleware'=>'web'], function(){
    Route::get('/', 'PromoController@index')->name('promo');
    Route::post('/sendMessage', 'PromoController@sendMessage')->name('promo.sendMessage');

    Route::get('/constructor', 'PricesController@constructor')->name('prices');
    Route::get('/getprice', 'PricesController@getPrice');
});


// Closed routes
Auth::routes();
Route :: get ('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/productions', 'ProductionsController@index')->name('productions');
    Route::get('/productions/{id}', 'ProductionsController@show')->name('productions.show');

    Route::get('/invoices/export', 'InvoicesController@export')->name('invoices.export');
    Route::get('/invoices', 'InvoicesController@index')->name('invoices');
    Route::get('/invoices/{id}', 'InvoicesController@show')->name('invoices.show');

});

Route::get('sitemap', function() {
    $sitemap = Sitemap::create();

        $sitemap = $sitemap
            ->add(Url::create(route('promo'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create(route('home'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create(route('productions'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create(route('invoices'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create(route('prices'))
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

    $sitemap->writeToFile(public_path("sitemap.xml"));

    return redirect()->route('promo');

});

Route::post('/', function(Request $request) {
    if ($request->has('id') && $request->has('lat') && $request->has('lon')) {
        \Illuminate\Support\Facades\Log::debug('/: method: ' . $request->method() . ', fullUrl: ' . $request->fullUrl() . ', params: ' . print_r($request->all(), true));
    }
});
