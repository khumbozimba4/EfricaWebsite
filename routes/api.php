<?php

use Illuminate\Support\Facades\Route;

// Routes for ArticleController
Route::get('/v1/article/getAllArticles', 'App\Http\Controllers\API\V1\ArticleController@index')->name('getAllArticles');
Route::post('/v1/article/addArticle', 'App\Http\Controllers\API\V1\ArticleController@store')->name('addArticle');
Route::get('/v1/article/{id}/getArticleById', 'App\Http\Controllers\API\V1\ArticleController@show')->name('getArticleById');
Route::put('/v1/article/{id}/updateArticleById', 'App\Http\Controllers\API\V1\ArticleController@update')->name('updateArticleById');
Route::delete('/v1/article/{id}/deleteArticleById', 'App\Http\Controllers\API\V1\ArticleController@destroy')->name('deleteArticleById');


// Routes for ServiceController
Route::get('/v1/service/getAllServices', 'App\Http\Controllers\API\V1\ServiceController@index')->name('getAllServices');
Route::post('/v1/service/addService', 'App\Http\Controllers\API\V1\ServiceController@store')->name('addService');
Route::get('/v1/service/{id}/getServiceById', 'App\Http\Controllers\API\V1\ServiceController@show')->name('getServiceById');
Route::put('/v1/service/{id}/updateServiceById', 'App\Http\Controllers\API\V1\ServiceController@update')->name('updateServiceById');
Route::delete('/v1/service/{id}/deleteServiceById', 'App\Http\Controllers\API\V1\ServiceController@destroy')->name('deleteServiceById');


// Routes for SettingController
Route::get('/v1/setting/getAllSettings', 'App\Http\Controllers\API\V1\SettingController@index')->name('getAllSettings');
Route::post('/v1/setting/addSetting', 'App\Http\Controllers\API\V1\SettingController@store')->name('addSetting');
Route::get('/v1/setting/{id}/getSettingById', 'App\Http\Controllers\API\V1\SettingController@show')->name('getSettingById');
Route::put('/v1/setting/{id}/updateSettingById', 'App\Http\Controllers\API\V1\SettingController@update')->name('updateSettingById');
Route::delete('/v1/setting/{id}/deleteSettingById', 'App\Http\Controllers\API\V1\SettingController@destroy')->name('deleteSettingById');


// Routes for UserController
Route::get('/v1/user/getAllUsers', 'App\Http\Controllers\API\V1\UserController@index')->name('getAllUsers');
Route::post('/v1/user/addUser', 'App\Http\Controllers\API\V1\UserController@store')->name('addUser');
Route::get('/v1/user/{id}/getUserById', 'App\Http\Controllers\API\V1\UserController@show')->name('getUserById');
Route::put('/v1/user/{id}/updateUserById', 'App\Http\Controllers\API\V1\UserController@update')->name('updateUserById');
Route::delete('/v1/user/{id}/deleteUserById', 'App\Http\Controllers\API\V1\UserController@destroy')->name('deleteUserById');


