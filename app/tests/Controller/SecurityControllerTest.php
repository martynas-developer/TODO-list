<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private string $email = 'test@test.com';
    private string $password = 'testtest';

    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        parent::setUp();
    }

    /**
     * @group integration
     */
    public function testRegisterFail(): void
    {
        $this->client->request(
            'POST', 
            $_ENV['ENV_URL'] . '/api/register',
            [],
            [],
            [],
            json_encode(['email' => '', 'password' => ['password' => '', 'confirm' => '']])
        );
        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        $responseBodyAsArray = json_decode($this->client->getResponse()->getContent(), true);
        self::assertArrayHasKey('email', $responseBodyAsArray);
        self::assertArrayHasKey('password', $responseBodyAsArray);
    }

    /**
     * @group integration
     */
    public function testRegisterSuccess(): void
    {
        $this->client->request(
            'POST',
            $_ENV['ENV_URL'] . '/api/register',
            [],
            [],
            [],
            json_encode(['email' => $this->email, 'password' => ['password' => $this->password, 'confirm' => $this->password]]),
        );
        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group integration
     */
    public function testLogin(): void
    {
        $this->client->request(
            'POST',
            $_ENV['ENV_URL'] . '/api/login',
            [],
            [],
            [],
            json_encode(['email' => $this->email, 'password' => $this->password]),
        );
        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $responseBodyAsArray = json_decode($this->client->getResponse()->getContent(), true);

        self::assertArrayHasKey('token', $responseBodyAsArray);
        self::assertNotEmpty($responseBodyAsArray['token']);
        self::assertArrayHasKey('expiresAt', $responseBodyAsArray);
        self::assertNotFalse(strtotime($responseBodyAsArray['expiresAt']));
    }

    /**
     * @group integration
     */
    public function testLoginFail(): void
    {
        $this->client->request(
            'POST',
            $_ENV['ENV_URL'] . '/api/login',
            [],
            [],
            [],
            json_encode(['email' => '', 'password' => '']),
        );
        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        $responseBodyAsArray = json_decode($this->client->getResponse()->getContent(), true);
        self::assertArrayHasKey('password', $responseBodyAsArray);
    }
}