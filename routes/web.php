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

Route::group(['middleware' => ['auth', 'leader']], function () {

    Route::post('first', 'AppController@first')->name('first');

    // Настройки
    /*Route::resource('settings', 'SystemController', [
        'only' => ['index', 'edit', 'update'],
        'names' => [
            'index' => 'settings',
            'edit' => 'settings.edit',
            'update' => 'settings.update'
        ]
    ]);*/
    Route::group(['prefix' => 'settings'], function(){
        Route::get('/', 'SystemController@index')->name('settings');
        Route::get('/{parameter}', 'SystemController@edit')->name('settings.edit');
        Route::put('/{parameter}', 'SystemController@update')->name('settings.update');
    });



    // Должности
    Route::group(['prefix' => 'positions'], function () {
        Route::get('/', 'PositionController@index')->name('positions');
        Route::get('/new', 'PositionController@new')->name('positions.create');
        Route::get('/delete/{position}', 'PositionController@delete')->name('positions.delete');
        Route::post('/store', 'PositionController@store')->name('positions.store');
        Route::post('/update', 'PositionController@update')->name('positions.update');
        Route::get('/show/{position}', 'PositionController@show')->name('positions.show');
        Route::get('/edit/{position}', 'PositionController@show')->name('positions.edit');;
    });

    // Пользователи
    Route::group(['prefix' => 'users'], function () {
       Route::get('/', 'UserController@index')->name('users');
        Route::get('/new', 'UserController@create')->name('users.create');
        Route::post('/new', 'UserController@store')->name('users.store');
        Route::get('/edit/{user}', 'UserController@edit')->name('users.edit');
        Route::post('/update/{user}', 'UserController@update')->name('users.update');
        Route::get('/password', 'UserController@editPassword')->name('users.password');
        Route::post('/password/{user}', 'UserController@updatePassword')->name('users.update.password');
        Route::get('/show/{user}', 'UserController@show')->name('users.show');
        Route::get('/delete/{user}', 'UserController@destroy')->name('users.delete');
        Route::get('/statistics/{user}', 'UserController@statistics'); // TODO убрать или переделать
        Route::get('/password/reset/{user}', 'AuthController@sendLinkResetPassword')->name('users.reset');
    });

});

Route::group(['middleware' => 'auth'], function () {
    // Страница пользователя
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::get('/statistics', 'ProfileController@statistics')->name('users.statistics');

    // Заявки
    Route::group(['prefix' => 'holidays'], function () {
       Route::get('/', 'HolidaysController@index');
        Route::get('/new', 'HolidaysController@create');
        Route::post('/store', 'HolidaysController@store')->name('holidays.store');
        Route::post('/update', 'HolidaysController@update');
        Route::get('/edit/{holiday}', 'HolidaysController@edit');
        Route::get('/show/{holiday}', 'HolidaysController@show');
    });

    Route::get('logout', 'AuthController@logout')->name('auth.logout');
});

//Auth::routes();
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'AuthController@showLoginForm')->name('auth.login.form');
    Route::post('login', 'AuthController@authenticate')->name('auth.login');
    Route::get('reset/{token?}', 'AuthController@resetPasswordForm')->name('auth.reset.form');
    Route::post('reset', 'AuthController@resetPassword')->name('auth.reset');
    Route::get('recovery', 'AuthController@sendLinkResetPasswordForm')->name('auth.recovery');
    Route::post('recovery', 'AuthController@sendLinkResetPassword')->name('auth.sendmail');
});

Route::get('/home', 'HomeController@index')->name('home');

