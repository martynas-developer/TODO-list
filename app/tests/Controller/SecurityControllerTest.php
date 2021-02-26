<?php

namespace Tests\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends TestCase
{
    private string $email = 'test@test.com';
    private string $password = 'testtest';

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
    }

    public function testRegisterFail(): void
    {
        $response = $this->client->request('POST', 'nginx/register', [
            'http_errors' => false,
            RequestOptions::BODY => json_encode([
                "email" => '',
                "password" => [
                    "password" => '',
                    "confirm" => ''
                ]
            ]),
        ]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $responseBodyAsArray = json_decode($response->getBody(), true);
        self::assertArrayHasKey('email', $responseBodyAsArray);
        self::assertArrayHasKey('password', $responseBodyAsArray);
    }

    public function testRegisterSuccess(): void
    {
        $response = $this->client->request('POST', 'nginx/register', [
            RequestOptions::BODY => json_encode([
                "email" => $this->email,
                "password" => [
                    "password" => $this->password,
                    "confirm" => $this->password
                ]
            ]),
        ]);
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }



    public function testLogin(): void
    {
        $client = new Client();
        $response = $client->request(
            'POST',
            'nginx/login',
            [
                RequestOptions::BODY => json_encode([
                    "email" => $this->email,
                    "password" => $this->password
                ]),
            ]
        );
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseBodyAsArray = json_decode($response->getBody(), true);

        self::assertArrayHasKey('token', $responseBodyAsArray);
        self::assertNotEmpty($responseBodyAsArray['token']);
        self::assertArrayHasKey('expiresAt', $responseBodyAsArray);
        self::assertNotFalse(strtotime($responseBodyAsArray['expiresAt']));
    }

    public function testLoginFail(): void
    {
        $client = new Client();
        $response = $client->request(
            'POST',
            'nginx/login',
            [
                'http_errors' => false,
//                RequestOptions::HEADERS => [
//                    'Accept' => 'application/ld+json',
//                    'Content-Type' => 'application/json',
//                    'Authorization' => "Bearer {$this->token}",
//                ],
                RequestOptions::BODY => json_encode([
                    "email" => $this->email,
                    "password" => ''
                ]),
            ]
        );
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $responseBodyAsArray = json_decode($response->getBody(), true);
        self::assertArrayHasKey('password', $responseBodyAsArray);
    }
}