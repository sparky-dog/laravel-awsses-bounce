<?php
Route::get('/welcome', function(){
    return view('SesBounce::welcome');
});

Route::get('/gui', function(){
    return view('SesBounce::gui');
});