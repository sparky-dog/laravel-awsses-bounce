<?php

Route::post('awsbounce','SesBounceController@store');
Route::post('awsbounce/send','SesBounceController@send');