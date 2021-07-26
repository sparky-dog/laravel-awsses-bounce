<?php
Route::get('SesBounce', function(){
    return view('SesBounce::welcome');
});

Route::get('SesBounce/gui', function(){
    return view('SesBounce::gui');
});