<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (auth()->check()) {
    
            $role = auth()->user()->role; 
            $current = $request->path();

            if (in_array($current, ['login', 'register', '/'])) {
                return match($role) {
                    'admin'      => redirect()->route('admin.dashboard'),
                    'medecin'    => redirect()->route('medecin.dashboard'),
                    'secretaire' => redirect()->route('secretaire.dashboard'),
                    'patient'    => redirect()->route('patient.dashboard'),
                };
            }
        }

        return $next($request);
    }
}