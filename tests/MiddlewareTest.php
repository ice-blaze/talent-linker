<?php

use App\Traits\DatabaseTransactionWorking;

class MiddlewareTest extends TestCase
{
    use DatabaseTransactionWorking;

    public function providerAllUrisWithResponseCode()
    {
        return [
            ['GET', '/', 200, 'guest'],
            ['GET', '/about', 200, 'guest'],
            ['GET', '/feedbacks', 200, 'auth'],
            ['GET', '/feedbacks', 302, 'guest'],
            ['GET', '/', 200, 'auth'],
            ['GET', '/about', 200, 'auth'],
            ['GET', '/talents/1/edit', 200, 'auth'],
            ['GET', '/talents/1', 200, 'auth'],
            ['GET', '/talents/1/chat', 200, 'auth'],
            ['GET', '/talents/1/projects', 200, 'auth'],
            ['GET', '/chat/1/edit', 200, 'auth'],
            ['GET', '/projects/create', 200, 'auth'],
            ['GET', '/projects/1/edit', 200, 'auth'],
            ['GET', '/comments/1/edit', 200, 'auth'],
            ['GET', '/projects/1/privateComments', 200, 'auth'],
            ['GET', '/projects/1/invitations', 200, 'auth'],
            ['GET', '/projects/1/join', 200, 'auth'],
            ['GET', '/talents/1/invitations', 200, 'auth'],
            ['GET', '/talents/4/recruit', 200, 'auth'],
            ['GET', '/projects', 200, 'auth'],
            ['GET', '/projects/1', 200, 'auth'],
            ['GET', '/talents', 200, 'auth'],
            ['GET', '/talents/1', 200, 'auth'],
            ['GET', '/projects', 200, 'guest'],
            ['POST', '/projects', 200, 'guest'],
            ['GET', '/projects/1', 200, 'guest'],
            ['GET', '/talents', 200, 'guest'],
            ['POST', '/talents', 200, 'guest'],
            ['GET', '/talents/1', 200, 'guest'],
            ['GET', '/projects/create', 302, 'guest'],
            ['GET', '/talents/1/edit', 302, 'guest'],
            ['GET', '/talents/1/chat', 302, 'guest'],
            ['GET', '/talents/1/projects', 302, 'guest'],
            ['GET', '/chat/1/edit', 302, 'guest'],
            ['GET', '/projects/create', 302, 'guest'],
            ['GET', '/projects/1/edit', 302, 'guest'],
            ['GET', '/comments/1/edit', 302, 'guest'],
            ['GET', '/projects/1/privateComments', 302, 'guest'],
            ['GET', '/projects/1/invitations', 302, 'guest'],
            ['GET', '/projects/1/join', 302, 'guest'],
            ['GET', '/talents/1/invitations', 302, 'guest'],
            ['GET', '/talents/4/recruit', 302, 'guest'],
        ];
    }

    /**
     * Test every routes | GET and some POST
     *
     * Guest and Auth only
     *
     * @dataProvider providerAllUrisWithResponseCode
     **/
    public function testApplicationUriResponses($type, $uri, $responseCode, $middleware)
    {
        if ($middleware == 'auth') {
            $user = App\User::find(1);
            Auth::login($user);
        }
        
        $response = $this->call($type, $uri);
        echo sprintf('[%s - %s] : %d - %d | %s %s', $middleware, $type, $responseCode, $response->status(), $uri, PHP_EOL);
        $this->assertEquals($responseCode, $response->status());
    }
}
