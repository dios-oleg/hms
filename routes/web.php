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

Route::get('/', 'AppController@index')->name('app');

Route::group(['middleware' => ['auth', 'head']], function () {
    
    Route::post('first', 'AppController@first')->name('first');
    
    // Настройки
    Route::get('/settings', 'SystemController@index');
    Route::post('/settings', 'SystemController@index');
    
    
    // Должности
    Route::group(['prefix' => 'positions'], function () {
        Route::get('/', 'PositionController@index');
        Route::get('/new', 'PositionController@new');
        Route::get('/delete/{position}', 'PositionController@delete');
        Route::post('/store', 'PositionController@store');
        Route::post('/update', 'PositionController@update');
        Route::get('/show/{position}', 'PositionController@show');
        Route::get('/edit/{position}', 'PositionController@show');
    });

    // Пользователи
    Route::group(['prefix' => 'users'], function () {
       Route::get('/', 'UserController@index')->name('users');
        Route::get('/new', 'UserController@create');
        Route::post('/new', 'UserController@store')->name('create-user');
        Route::get('/edit/{user}', 'UserController@edit');
        Route::post('/update', 'UserController@update');
        Route::get('/show/{user}', 'UserController@show')->name('view-user');
        Route::get('/delete/{user}', 'UserController@destroy');
        Route::get('/statistics/{user}', 'UserController@statistics'); 
    });

});

Route::group(['middleware' => 'auth'], function () {
    // Страница пользователя
    Route::get('/account', 'UserController@show');
    Route::get('/statistics', 'UserController@statistics');
    
    // Заявки
    Route::group(['prefix' => 'holidays'], function () {
       Route::get('/', 'HolidaysController@index'); // TODO Разный у пользователя и руководителя
        Route::get('/new', 'HolidaysController@new');
        Route::post('/store', 'HolidaysController@store');
        Route::post('/update', 'HolidaysController@update');
        Route::get('/edit/{holiday}', 'HolidaysController@edit');
        Route::get('/show/{holiday}', 'HolidaysController@show'); 
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

