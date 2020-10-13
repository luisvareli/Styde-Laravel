<?php

use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return 'Home';
});

Route::get('/usuarios', 'UserController@index')
    ->name('users.index');

Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::get('/usuarios/nuevo', 'UserController@create')->name('users.create');

Route::post('/usuarios','UserController@store');

Route::get('/usuarios/{user}/editar','UserController@edit')->name('users.edit');

//Route::get('/usuarios/{id}/editar','UserController@edit')->name('users.edit');

Route::put('/usuarios/{user}','UserController@update');

Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController');