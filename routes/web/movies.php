<?php

Route::get('/', 'Movies\DownloadController@index');
Route::post('/download', 'Movies\DownloadController@store');
Route::get('/show', 'MovieController@index');
