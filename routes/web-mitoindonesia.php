<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\Frontend\HomeController@index')->name('local.frontend.home');