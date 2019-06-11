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

$router->get('/', array('as' => 'home-page', 'uses' => 'IndexController@index'));
$router->post('/', array('as' => 'home-page-with-appointments', 'uses' => 'IndexController@getAppointments'), 'IndexController@getAppointments');
