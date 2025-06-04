<?php
namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
class Authenticate extends Middleware
{
    protected function redirectTo($request) {
    if ($request->expectsJson()) {
        return response()->json(['message' => 'No autenticado'], 401);
    }

    // Redirección diferenciada para admin/cliente
    return match(true) {
        $request->is('admin*') => route('login', ['redirect' => 'admin']),
        default => route('login')
    };
}
    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*')) {
            abort(response()->json([
                'message' => 'Token de acceso inválido o expirado',
                'code' => 401
            ], 401));
        }
        parent::unauthenticated($request, $guards);
    }
}