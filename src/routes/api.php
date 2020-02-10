<?php

Route::post('awsbounce','SesBounceController@store')->name('sesreg');
Route::post('awsbounce/send','SesBounceController@send')->name('sestest');