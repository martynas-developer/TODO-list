<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    private string $email = 'test@test.com';
    private string $password = 'testtest';
    private array $headers = [];
    private $client;

    /**
     * @group integration
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            $_ENV['ENV_URL'] . '/api/login',
            [],
            [],
            [],
            json_encode(['email' => $this->email, 'password' => $this->password]),
        );

        $responseBodyAsArray = json_decode($this->client->getResponse()->getContent(), true);
        $this->headers = [
            'HTTP_Authorization' => 'Bearer ' . $responseBodyAsArray['token']
        ];

        parent::setUp();
    }

    /**
     * @group integration
     */
    public function testCreateTask(): void
    {
        $this->client->request(
            'POST',
            $_ENV['ENV_URL'] . '/api/tasks',
            [],
            [],
            $this->headers,
        );
        $responseBodyAsArray = json_decode($this->client->getResponse()->getContent(), true);
        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('id', $responseBodyAsArray);
        self::assertNotEmpty($responseBodyAsArray['id']);
    }

    /**
     * @group integration
     */
    public function testViewTask(): void
    {
        $this->client->request(
            'GET',
            $_ENV['ENV_URL'] . '/api/tasks/1',
            [],
            [],
            $this->headers,
        );
        $responseBodyAsArray = json_decode($this->client->getResponse()->getContent(), true);
        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('id', $responseBodyAsArray);
        self::assertNotEmpty($responseBodyAsArray['id']);
    }
}