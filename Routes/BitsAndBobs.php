<?php

//Available HTTP verbs
Route::get($uri, $callback);
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);

//Allowing multiple actions
Route::match(['get, post'], 'URI', function(){

});
Route::any('URI', function(){

});

//Basics - parameters
Route::get('/a/{b}/c/{d?}', function($b, $d = 'DEFAULT HERE'){

});

//Using Regex for parameters
Route::get('/a/{b}/c/{d}', function($b, $d){

})->where(['b' => '[a-z]', 'd' => '[A-Z]']);

//Using global regex constraints registered in the RouteServiceProvider's boot method
//Now 'id' must always match the regex when used as a route parameter
/**
 * Define your route model bindings, pattern filters, etc.
 *
 * @return void
 */
public function boot()
{
    Route::pattern('id', '[0-9]+');

    parent::boot();
}

//Using named routes (A MUST!!!)
Route::get('user/profile', 'UserController@showProfile')->name('profile');
//Notice how 'name' is now chained as opposed to within the get parameters

//Route groups allows routes to share common features such as middleware or Path name
Route::group(['middleware' => 'auth', 'prefix' => 'shared', 'namespace' => 'Admin', 'domain' => '{acc}.me.com'], function () {
    Route::get('/', function ($acc)    {
        // Uses Auth Middleware and matches '/shared'
    });

    Route::get('user/profile', function ($acc) {
        // Uses Auth Middleware and matches '/shared/user/profile'
    });
    Route::get('something', 'SomeController@doSomething');
    //Due to the namespace definition above, the controller is now found in
    //App\Http\Controllers\Admin (addition of 'Admin')
});

//Implicit Route Model Binding
Route::get('/{user}/show', function (User $user){
   //Here the User object is injected based on the route parameter being the ID
   //of the resource we want injected.
});
//Overiding the parameter used to resolve our object
/**
 * Get the route key for the model.
 * Below we get the object by 'slug' as opposed to 'id'
 *
 * @return string
 */
public function getRouteKeyName()
{
    return 'slug';
}

//Customizing the resolution logic
public function boot()
{
    parent::boot();

    Route::bind('user', function ($value) {
        return App\User::where('name', $value)->first();
    });
}
//In the above, whenever 'user' is a route parameter, the URI segment is passed
//into the bind closure.

//Form method spoofing. As browsers currently only recognise POST and GET requests,
//We cannot actually perform the other verbs. However, in order to promote
//HTTP best practices, we can spoof the method and match the type in the
//routes
{{ method_field('PUT') }}
