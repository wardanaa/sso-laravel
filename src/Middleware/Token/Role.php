<?php 

namespace RistekUSDI\SSO\Laravel\Middleware\Token;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use RistekUSDI\SSO\Laravel\Exceptions\TokenException;

class Role {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(\Illuminate\Http\Request $request, Closure $next, ...$guards)
	{
		try {
            if (empty($guards) && Auth::guard('imissu-token')->check()) {
                return $next($request);
            }
            
            $roles = Auth::guard('imissu-token')->user()->roles;
            $guards = explode('|', ($guards[0] ?? ''));
            
            $result = array_intersect($roles, $guards);
            
            if (!empty($result)) {
                return $next($request);
            } else {
                throw new TokenException("Peran {$guards['0']} tidak diijinkan mengakses sumber ini", 403);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
	}
}