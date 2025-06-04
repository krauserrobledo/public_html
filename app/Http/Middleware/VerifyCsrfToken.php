<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    // Puedes agregar aquí excepciones para URIs que no quieras proteger si necesitas.
}
