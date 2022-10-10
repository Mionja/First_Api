<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/student',
        'api/module',
        'api/teacher',
        'api/student/pass/{id}',
        'api/student/redouble/{id}',
        'api/student/finish/{id}',
        'api/student/quit/{id}',
        'api/student/retake_exam/{id}',
        'api/mark',
        'api/teacher/add/module/{id}',
        'api/teacher/detach/module/{id}',
    ];
}
