<?php


use core\route;

$app = new core\route();

Route::get('/', 'home@index');
Route::get('/users/', 'home@users');
Route::get('/:id', 'home@index');


Route::disPatch();
