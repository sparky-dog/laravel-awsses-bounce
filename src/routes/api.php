<?php

Route::post('awsbounce','SesBounceController@store')->name('sesreg');
Route::post('awsbounce/send','SesBounceController@send')->name('sestest');
Route::post('awsbounce/get','SesBounceController@get')->name('sesget');
