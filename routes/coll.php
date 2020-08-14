<?php



Route::get('collection','collectTut@index');

Route::get('mainoffers','collectTut@complex');

Route::get('main-offers','collectTut@complexFilter');

Route::get('main-offers3','collectTut@complexTransform');
