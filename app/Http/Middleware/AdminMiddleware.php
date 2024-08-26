<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Assuming you are using the default auth guard
        $user = Auth::user();

        if ($user && $this->isAdmin($user->email)) {
            return $next($request);
        }

        return redirect('/');
    }

    private function isAdmin($email)
    {
        // Assuming your Admin model is App\Models\Admin
        return \App\Models\Admin::where('email', $email)->exists();
    }
}
