<?php namespace App\Http\Middleware;

use Closure;
use App\Models\Session;
use Illuminate\Http\Request;

class AuthenticateService {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct()
	{
		
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if (Session::getSession($request->header('X-APP-Token')))
		{
			return $next($request);
		}
		else{
			return response('Unauthorized.', 401);
		}

	}

}
