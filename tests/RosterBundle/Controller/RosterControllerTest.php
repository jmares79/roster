<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use RosterBundle\Entity\League;

class RosterControllerTest extends WebTestCase
{
    const BOT_KEY = 'bot';
    const VALID_ID = 1;
    const NULL_ID = null;
    protected $mockedLeague;
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->mockedLeague = $this->createMock(League::class);
    }

    /**
     * @dataProvider getBotProvider
     */
    public function testGetBotAction($id, $status)
    {
        $this->client->request('GET', '/bot/'.$id);
        $r = $this->client->getResponse()->getContent();
        $response = json_decode($r, true);

        $code = $this->client->getResponse()->getStatusCode();

        $this->assertArrayHasKey(self::BOT_KEY, $response);
        $this->assertEquals($status, $code);
    }

    public function getBotProvider()
    {
        return array(
            array(self::VALID_ID, Response::HTTP_NOT_FOUND)
        );
    }
}
