<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return [
            'name' => 'Students service',
            'routes' => [
                [
                    'url' => 'api/students',
                    'description' => 'Lists all students.',
                    'method' => 'GET'
                ],
                [
                    'url' => 'api/students',
                    'description' => 'Create a student.',
                    'method' => 'POST'
                ],
                [
                    'url' => 'api/students/{id}',
                    'description' => 'Get specific student.',
                    'method' => 'GET'
                ],
                [
                    'url' => 'api/students/{id}',
                    'description' => 'Update specific student.',
                    'method' => 'PATCH'
                ],
                [
                    'url' => 'api/students/{id}',
                    'description' => 'Delete a specific student.',
                    'method' => 'DELETE',
                ]
            ]
        ];
    }
}
