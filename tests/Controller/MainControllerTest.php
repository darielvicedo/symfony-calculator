<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    /**
     * Tests the calculator endpoint.
     *
     * @return void
     */
    public function testEndpoint(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/add/4/5');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');
    }

    /**
     * Tests wrong operator type.
     *
     * @return void
     */
    public function testWrongOperation(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/xsx/4/5');

        $this->assertResponseStatusCodeSame(400);
    }

    /**
     * Tests addition.
     *
     * @return void
     */
    public function testSum(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/add/4/5');

        $response = $client->getResponse();
        $result = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(9, $result['result']);
    }

    /**
     * Tests subtraction.
     *
     * @return void
     */
    public function testSub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sub/4/5');

        $response = $client->getResponse();
        $result = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(-1, $result['result']);
    }

    /**
     * Tests division.
     *
     * @return void
     */
    public function testDiv(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/div/4/2');

        $response = $client->getResponse();
        $result = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(2, $result['result']);

        $crawler = $client->request('GET', '/div/4/0');

        $this->assertResponseStatusCodeSame(500);
    }

    /**
     * Tests multiplication.
     *
     * @return void
     */
    public function testMul(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mul/4/5');

        $response = $client->getResponse();
        $result = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(20, $result['result']);
    }
}
