<?php

Route::post('awsbounce','SesBounceController@store')->name('sesreg');
Route::post('awsbounce/send','SesBounceController@send')->name('sestest');
Route::post('awsbounce/edit','SesBounceController@edit')->name('sesedit');
Route::get('awsbounce/get','SesBounceController@get')->name('sesget');
