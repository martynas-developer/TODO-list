<?php

namespace Tests\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends TestCase
{
    public function testThatYourComputerWorks()
    {
        $client = new Client();
        $response = $client->request(
            'POST',
            'nginx/register',
            [
//                RequestOptions::HEADERS => [
//                    'Accept' => 'application/ld+json',
//                    'Content-Type' => 'application/json',
//                    'Authorization' => "Bearer {$this->token}",
//                ],
                RequestOptions::BODY => json_encode([
                    "email"=> "afe@sdf.gfd1us",
                    "password" => [
                        "password" => "testtest",
                        "confirm" => "testtest"
                    ]
                ]),
            ]
        );
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}