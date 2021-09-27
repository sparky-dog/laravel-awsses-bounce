<?php
Route::get('/sesbounce', function(){
    return view('SesBounce::welcome');
});

Route::get('/gui', function(){
    return view('SesBounce::gui');
});