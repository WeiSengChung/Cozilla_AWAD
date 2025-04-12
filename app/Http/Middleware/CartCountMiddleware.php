<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CartController;

class CartCountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $cartController = new CartController();
        // Make sure we always have a valid value by using null coalescing operator
        View::share('cartItemCount', $cartController->getCartItemCount() ?? 0);
        
        return $next($request);
    }
}