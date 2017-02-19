<?php
/*
 * Why use Service Providers?
 * Service providers are the central bootstrapping location
 * of a Laravel application. The request lifecycle begins
 * in index.php before instantiating our app/service
 * container. Next the kernel bootstraps our application
 * including registering our service providers.
 * In the example below, we use a service
 * provider to typehint interfaces in a controller
 * action, but have an implementation of a concrete
 * class injected.
 */

// App\Contracts\Rocket.php
interface Rocket {
    public function blast();
}
// App\Models\RocketShipPrototype.php
class RocketShipPrototype implements Rocket {
    public function blast()
    {
        return "Generating a lot of thrust";
    }
}
//App\Providers\RocketShipProvider.php

use Illuminate\Support\ServiceProvider;
use RocketShipPrototype;

class TestProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\Rocket', function($app){
            return new RocketShipPrototype();
        });
    }
}

//config\app.php
/* providers => [
*   add our provider to this list
*/

/*
 * Why use this?
 * In the example above, if we use dependency injection to resolve
 * a resource, whenever we typehint a 'Rocket', we will receive
 * a resolved instance of RocketShipPrototype. This is great,
 * as in the future our prototype is likely to become outdated
 * and improved, which means we only need change what is resolved
 * from the container above in the service providers register method.
 *
 */