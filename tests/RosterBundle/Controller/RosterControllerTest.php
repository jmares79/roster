<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use RosterBundle\Entity\League;

class RosterControllerTest extends WebTestCase
{
    const BOT_KEY = 'bot';
    const VALID_ID = 1;
    protected $mockedLeague;
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider getBotProvider
     */
    public function testGetBotAction($id, $status)
    {
        $this->client->request('GET', '/bot/'.$id);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey(self::BOT_KEY, $response);
        $this->assertEquals($status, $this->client->getResponse()->getStatusCode());
    }

    public function getBotProvider()
    {
        return array(
            array(self::VALID_ID, Response::HTTP_NOT_FOUND)
        );
    }

    public function testNewLeagueAction()
    {
        $this->client->request('POST', '/league');

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'The response is a JSON one'
        );

        $this->assertArrayHasKey(
            'location',
            $this->client->getResponse()->headers->all(),
            'Fail to test Header Location exists'
        );

        $this->assertContains(
            '/league/',
            $this->client->getResponse()->headers->get('location'),
            'Fail to test Header Location has /league/ response'
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $this->assertEquals(
            Symfony\Component\HttpFoundation\Response::HTTP_CREATED,
            $this->client->getResponse()->getStatusCode()
        );
    }
}
