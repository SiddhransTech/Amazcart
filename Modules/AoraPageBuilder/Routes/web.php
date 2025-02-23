<?php

use Illuminate\Support\Facades\Route;


// Route::prefix('page-builder/')->as('page_builder.')->middleware(['auth'])->group(function () {
//     Route::resource('pages', 'PageBuilderController')->except(['destroy', 'create']);
//     Route::post('page/delete', 'PageBuilderController@destroy')->name('pages.destroy');
//     Route::post('page/status', 'PageBuilderController@status')->name('pages.status');
//     Route::get('page/design/{id}', 'PageBuilderController@design')->name('pages.design');
//     Route::put('page/design/update/{id}', 'PageBuilderController@designUpdate')->name('pages.design.update');
//     Route::get('snippet', 'PageBuilderController@affSnippet')->name('snippet');
// });4

Route::prefix('page-builder/')->middleware(['auth','admin'])->as('page_builder.')->group(function () {
    Route::resource('pages', 'PageBuilderController')->except(['destroy','create']);
    Route::post('update','PageBuilderController@update')->name('pages.update');
    Route::post('page/delete', 'PageBuilderController@destroy')->name('pages.destroy')->middleware('prohibited_demo_mode');
    Route::post('page/status', 'PageBuilderController@status')->name('pages.status')->middleware('prohibited_demo_mode');
    Route::get('page/design/{id}', 'PageBuilderController@design')->name('pages.design');
    Route::put('page/design/update/{id}', 'PageBuilderController@designUpdate')->name('pages.design.update')->middleware('prohibited_demo_mode');
    Route::get('snippet', 'PageBuilderController@snippet')->name('snippet');
    Route::post('slug-generate', 'PageBuilderController@slugGenerate')->name('slug_generate');
    Route::post('new-upload','PageBuilderController@upload')->name('pageBuilderUpload');
    Route::get('delete-model/{id}','PageBuilderController@deleteModal')->name('pages.deleteModal');
});


