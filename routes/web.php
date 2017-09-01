<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//заходим на главную страницу первый раз
//если нет пользователей в БД, то сразу страница создания первого пользователя как руководителя и настройка приложения

//если есть пользователи, то загрузка страницы входа
//если пользователь авторизован, то в зависимости кто он - руководитель или пользователь
//руководитель - открыть дашборд руководителя
//пользователь - дашборд пользователя

// TODO пользователь не может выполнять действия, пока его профиль не заполнен

Route::get('/', 'AppController@index')->name('app');

Route::group(['middleware' => ['auth', 'leader' , 'active']], function () {
    // Настройки
    Route::group(['prefix' => 'settings'], function(){
        Route::get('/', 'SystemController@index')->name('settings');
        Route::get('/{parameter}', 'SystemController@edit')->name('settings.edit');
        Route::put('/{parameter}', 'SystemController@update')->name('settings.update');
    });

    // Должности
    Route::group(['prefix' => 'positions'], function () {
        Route::get('/', 'PositionController@index')->name('positions');
        Route::get('/create', 'PositionController@create')->name('positions.create');
        Route::post('/', 'PositionController@store')->name('positions.store');
        Route::delete('/{position}', 'PositionController@destroy')->name('positions.delete');
        Route::get('/{position}', 'PositionController@edit')->name('positions.edit');;
        Route::put('/{position}', 'PositionController@update')->name('positions.update');
    });

    // Пользователи
    Route::group(['prefix' => 'users'], function () {
       Route::get('/', 'UserController@index')->name('users');
        Route::get('/create', 'UserController@create')->name('users.create');
        Route::post('/', 'UserController@store')->name('users.store');
        Route::get('/{user}', 'UserController@edit')->name('users.edit');
        Route::put('/{user}', 'UserController@update')->name('users.update');
    });

});

Route::group(['middleware' => ['auth', 'active']], function () {
    // Страница пользователя
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::get('/statistics', 'ProfileController@statistics')->name('users.statistics');

    // Заявки
    Route::group(['prefix' => 'holidays'], function () {
        Route::get('/', 'HolidaysController@index')->name('holidays');
        Route::get('/create', 'HolidaysController@create')->name('holidays.create');
        Route::post('/', 'HolidaysController@store')->name('holidays.store');
        Route::get('/{holiday}', 'HolidaysController@edit')->name('holidays.edit');
        Route::put('/{holiday}', 'HolidaysController@update')->name('holidays.update');
        Route::delete('/{holiday}', 'HolidaysController@update')->name('holidays.delete');
    });

    Route::get('logout', 'AuthController@logout')->name('auth.logout');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'AuthController@index')->name('auth.login.form'); // TODO rename
    Route::post('login', 'AuthController@authenticate')->name('auth.login'); // TODO rename
    Route::get('reset/{token}', 'ResetPasswordController@newPasswordForm')->name('auth.reset.form');
    Route::post('reset', 'ResetPasswordController@reset')->name('auth.reset');
    Route::get('recovery', 'ResetPasswordController@emailForm')->name('auth.recovery');
    Route::post('recovery', 'ResetPasswordController@sendLink')->name('auth.sendmail');
});

Route::get('/home', 'HomeController@index')->name('home');
