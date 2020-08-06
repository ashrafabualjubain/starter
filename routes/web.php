<?php


Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/',function(){
   return 'Home';
});

Route::get('/redirect/{service}','SocialController@redirect');
Route::get('callback/{service}','SocialController@callback');



Route::get('fillable','CrudController@getOffers');

Route::group(['prefix'=>'offers'],function (){
   //Route::get('store','CrudController@store');
    Route::get('create','CrudController@create');
    Route::post('store','CrudController@store')->name('offers.store');
});


