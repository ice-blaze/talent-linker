<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class MiddlewareTest extends TestCase
{
    use DatabaseTransactions;
   
    public function providerAllUrisWithResponseCode()
    {
        return [
            ['GET', '/', 200, 'guest'],
            ['GET', '/about', 200, 'guest'],
            ['GET', '/feedbacks', 200, 'auth'], // Feedback
            ['GET', '/feedbacks', 302, 'guest'],

            ['GET', '/talents/1/edit', 200, 'auth'], // Users
            ['GET', '/talents/1', 200, 'auth'],
            ['GET', '/talents/1/chat', 200, 'auth'],
            //['POST', '/talents/1/chat', 200, 'auth'],
            ['GET', '/talents/1/projects', 200, 'auth'],
            ['GET', '/chat/1/edit', 200, 'auth'], // Chat
            //['DELETE', '/chat/{chat}/delete', 200, ''],
            //['PATCH', '/chat/{chat}', 200, 'auth'],
            ['GET', '/projects/create', 200, 'auth'], // Project
            //['POST', '/projects/create', 200, 'auth'],
            ['GET', '/projects/1/edit', 200, 'auth'],
            //['PATCH', '/projects/{project}', 200, 'auth'],
            //['DELETE', '/projects/{project}', 200, 'auth'],
            //['POST', '/projects/{project}/comments', 200, 'auth'], // Project comments
            ['GET', '/comments/1/edit', 200, 'auth'],
            //['PATCH', '/comments/{comment}', 200, 'auth'],
            //['DELETE', '/comments/{comment}', 200, 'auth'],
            ['GET', '/projects/1/privateComments', 200, 'auth'], // Private project comment
            //['POST', '/projects/{project}/privateComments', 200, 'auth'],
            ['GET', '/projects/1/invitations', 200, 'auth'], // Invitations
            //['POST', '/projects/{project}/invitations', 200, 'auth'],
            ['GET', '/projects/1/join', 200, 'auth'],
            //['PATCH', '/invitations/{project}/1/accept', 200, 'auth'],
            //['DELETE', '/invitations/{project}/1/{invitation}', 200, 'auth'],
            ['GET', '/talents/1/invitations', 200, 'auth'],
            ['GET', '/talents/4/recruit', 200, 'auth'],
            //['POST', '/talents/1/recruit', 200, 'auth'],

            ['GET', '/projects', 200, 'auth'], // Project
            //['POST', '/projects', 200, 'auth'],
            ['GET', '/projects/1', 200, 'auth'],
            ['GET', '/talents', 200, 'auth'], // Users
            //['POST', '/talents', 200, 'auth'],
            ['GET', '/talents/1', 200, 'auth'],

            ['GET', '/projects', 200, 'guest'], // Project
            //['POST', '/projects', 200, 'guest'],
            ['GET', '/projects/1', 200, 'guest'],
            ['GET', '/talents', 200, 'guest'], // Users
            //['POST', '/talents', 200, 'guest'],
            ['GET', '/talents/1', 200, 'guest'],
        ];
    }

    /**
    * This is kind of a smoke test
    *
    * @dataProvider providerAllUrisWithResponseCode
    **/
    public function testApplicationUriResponses($type, $uri, $responseCode, $middleware)
    {
        if ($middleware == 'auth') {
            $user = App\User::find(1);
            Auth::login($user);
        }

        print sprintf('checking URI : %s - to be %d - %s', $uri, $responseCode, PHP_EOL);
        
        $response = $this->call($type, $uri);
        $this->assertEquals($responseCode, $response->status());
    }
}
