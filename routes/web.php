<?php

/** @var \Laravel\Lumen\Routing\Router $router */


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'HomeController@index');

/**
 * @version 1
 */
$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // students
    $router->get('students', 'StudentController@index');
    $router->post('students', 'StudentController@store');
    $router->get('students/{id}', 'StudentController@show');
    $router->patch('students/{id}', 'StudentController@update');
    $router->delete('students/{id}', 'StudentController@destroy');

    // courses
    $router->get('courses', 'CourseController@index');
    $router->post('courses', 'CourseController@store');
    $router->get('courses/{id}', 'CourseController@show');
    $router->patch('courses/{id}', 'CourseController@update');
    $router->delete('courses/{id}', 'CourseController@destroy');
});
