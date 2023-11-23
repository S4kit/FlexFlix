<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Add the routes you want to exclude from CSRF protection
        //the CSRFToken excluded so you can easily test the application
        '/register',
        '/login',
        '/logout',
        '/movies/favorites/add/*',
        '/movies/favorites/remove/*',
        '/series/favorites/add/*',
        '/series/favorites/remove/*',


    ];

}
