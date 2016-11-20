<?php

use App\Traits\DatabaseRefreshMigrations;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Auth\Events\Authenticated;
use Mockery as m;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Attempting;
use Symfony\Component\HttpFoundation\Request;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Middleware\Authenticate;

class MiddlewareTest extends TestCase
{
    //use DatabaseTransactions;
   
   public function providerAllUrisWithResponseCode()
    {
        return [
            ['GET', '/feedbacks', 200, 'auth'],
            ['GET', '/feedbacks', 401, 'guest'],
            ['GET', '/', 200, 'guest'],
            ['GET', '/about', 200, 'guest'],
            ['GET', '/', 200, 'guest'],
        ];
    }
    /**
    * This is kind of a smoke test
    *
    * @dataProvider providerAllUrisWithResponseCode
    **/
    public function testApplicationUriResponses($type, $uri, $responseCode, $middleware)
    {
        if($middleware == 'auth'){
            $user = factory(App\User::class)->create();
            $this->actingAs($user);
        }

        print sprintf('checking URI : %s - to be %d - %s', $uri, $responseCode, PHP_EOL);
        
        $response = $this->call($type, $uri);
        $this->assertEquals($responseCode, $response->status());

    }








  
    /*public function tearDown()
    {
        Mockery::close();
    }

    public function testwesh()
    { 
        $user = factory(App\User::class)->create();
            $this->mock =Mockery::mock('Feedback');
        $this->mock
            ->shouldReceive('all')
            ->once()
            ->andReturn('foo');

        $this->app->instance('Post',$this->mock);

        $fdp = $this->call('GET', 'feedbacks');
        //dd($fdp);
        $this->assertViewHas('posts');
    }

    public function testAllRoutes()
    {
        $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
        foreach ($routeCollection as $value) {
            $response = $this->call($value->getMethods()[0], $value->getPath());
            dd($response);
            $this->assertEquals(200, $response->status(),"{$value->getMethods()[0]} {$value->getPath()}");
        }
    }

    public function testS()
    {*/

        /*
            'auth'       => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'bindings'   => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'can'        => \Illuminate\Auth\Middleware\Authorize::class,
            'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,         
            'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'admin'    
        */

         // Login as someone
       /* $user = factory(App\User::class)->create();
        
         
        // Call as AJAX request.
        //$server = array('HTTP_X-Requested-With' => 'XMLHttpRequest');
        //$response = $this->call('get', '/feedbacks', array(), array(), $server);

        //$this->assertEquals(200, $response->getStatusCode());


        $routeCollection = Route::getRoutes();
        $middlewareName = "auth.basic";
        $routeHasFilter = [];

        foreach ($routeCollection as $route) {
            $middleware = $route->middleware();
            if (count($middleware) > 0) {
                if (in_array($middlewareName, $middleware)) {
                    $routeHasFilter[] = $route;
                    
                    //dd($route->getPath());
                    $this->actingAs($user);
                    $response = $this->action($route->getMethods()[0], $route->getPath());
                    $this->assertEquals(200, $response->status(),"{$route->getMethods()[0]} {$route->getPath()}");
                }
            }
        }
        dd($routeHasFilter);

        //Create the mock
        $drawController = \Mockery::mock('App\Http\Controllers\ChatUserController[index]');
        $drawController->shouldReceive('index')->once();

        // Bind instance of my controller to the mock
        App::instance('App\Http\Controllers\ChatUserController', $drawController);
        
        //Act
        $this->call('GET','/talents/1/chat');
    }*/
}
