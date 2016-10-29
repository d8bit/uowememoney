<?php

namespace App\Http\Middleware;

use Closure;

class ApiKey
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $apiKey = \Request::header('ApiKey');
    if($apiKey == getenv("API_KEY")) {
      return $next($request);
    } else {
      $response = array('message' => 'Wrong token');
      return \Response::json($response, 401);
    }

    return $next($request);
  }
}
