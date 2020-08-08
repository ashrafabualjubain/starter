<?php


Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/',function(){
   return 'Home';
});

Route::get('/redirect/{service}','SocialController@redirect');
Route::get('callback/{service}','SocialController@callback');
Route::get('create','CrudController@create');


Route::get('fillable','CrudController@getOffers');

//Route::group(['prefix'=>'offers'],function (){
   //Route::get('store','CrudController@store');
    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
        ],function (){
            Route::group(['prefix'=>'offers'],function (){
                Route::get('create','CrudController@create');
                Route::post('store','CrudController@store')->name('offers.store');
                Route::get('all','CrudController@getAllOffers');
            });
        //Route::get('create','CrudController@create');
    });

//});

/*Route::group(['prefix'=>'offers'],function (){
    //Route::get('store','CrudController@store');
    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
        ],function (){
        Route::get('create','CrudController@create');
    });

    Route::post('store','CrudController@store')->name('offers.store');
});*/
