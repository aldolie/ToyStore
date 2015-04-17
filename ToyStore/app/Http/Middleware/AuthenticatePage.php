<?php namespace App\Http\Middleware;

use Closure;
use App\Models\Session as SessionTable;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Http\Request;

class AuthenticatePage {

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
		if (Session::get('user'))
		{
			return $next($request);
		}
		else{
			return redirect('signin');
		}

	}

}
