<?php
// app/Http/Middleware/KiemTraAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->vai_tro !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }
        return $next($request);
    }
}
