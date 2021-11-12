<?php

Route::group(['middleware' => ['auth:api', 'role:Admin']], function () {
    Route::post('awsbounce','SesBounceController@store')->name('sesreg');
    Route::post('awsbounce/send','SesBounceController@send')->name('sestest');

    Route::get('awsbounce/get','SesBounceController@get')->name('sesget');
    Route::post('block-contact','SesBounceController@Block');
    Route::get('unblock-contact/{id}','SesBounceController@Unblock');
});