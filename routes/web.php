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


Route::get('/', 'UserController@index');
Route::get('/register', 'UserController@render_register');
Route::get('/home', 'HomeController@render_home');
Route::get('/logout', 'UserController@logout');
Route::get('/Allcourses', 'HomeController@render_course');
Route::get('/test', 'HomeController@query');
Route::get('/ImportNewCourses', 'AdminController@render_import');

Route::post('/ImportNewCourses', 'AdminController@insert_into_database');
Route::post('/register', 'UserController@create_register');
Route::post('/', 'UserController@create_login');
Route::post('/home', 'HomeController@unenroll');
Route::post('/Allcourses', 'HomeController@query_course');
Route::post('/enroll', 'HomeController@enroll');
Route::post('/query', 'HomeController@query');
