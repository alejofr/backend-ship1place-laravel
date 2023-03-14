<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( $request->user()->getRoleNames()->first() != 'Admin' ){
            return $this->errorResponse('Not authorized for this request.', HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
