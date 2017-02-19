<?php

//Create our class
class Rocket {
    public function blast()
    {
        return "Blasting off";
    }
}
//Create our Facade
use Illuminate\Support\Facades\Facade;

class Rocket extends Facade{
    protected static function getFacadeAccessor() { return 'rocket'; }
}
//Create our providers (notice how the facade returns 'rocket' above; this is essential
//for when being resolved from the container and registered by the provider
use Illuminate\Support\ServiceProvider;
use Rocket;

class TestFacadeProvider extends ServiceProvider
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
        $this->app->bind('rocket', function($app){
            return new RocketShip();
        });
    }
}
//Register an alias in config\app.php
//alises => [ ... 'Rocket' => Path\To\Our\Facade::class ... ]

/*
 * Now we can call the blast method on the Rocket class
 * by either 'newing' up a Rocket object or simply
 * calling Rocket::blast()
 */