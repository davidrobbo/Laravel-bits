<?php

//Middleware can be used to intercept the request and run either before
//or after it is handled
class BeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Perform action

        return $next($request);
    }
}

class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //Do stuff

        return $response;
    }
}

//App\Http\kernel.php controls middleware's handling of HTTP requests
//Global middleware is reg'd on $middleware, route-specific on $routeMiddleware
//and groups under middlwareGroups as 'groupName' => [\App\MW\A::class, \App\MW\B::class]

//MW can be assigned to a route using a chain method
Route::get('/', function(){})->middleware('auth'); //->middleware(Auth::class) also
//and grouping
Route::group(['middleware' => 'auth']...);

//Middlware can also take parameters
Route::get('/', function(){})->middleware('auth:abc,def');
// and the MW handle method would be as follows
// ... handle($request, Closure $next, $letterSetOne, $letterSetTwo){ if $letterSet == $request->something...

// adding a terminate method to middleware is called after the response is sent which accepts ($req, $res)