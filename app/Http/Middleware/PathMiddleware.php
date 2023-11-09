<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Path;
use Illuminate\Support\Facades\Log;


class PathMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $urls = Path::all();
        foreach($urls as $url){
            if ($url->url === $request->path()) return $next($request);
        }
        
        $path = new Path;
        $path->url = $request->path();
        $path->save();
        return $next($request);
    }
}
