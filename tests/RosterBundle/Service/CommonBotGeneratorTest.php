<?php
use PHPUnit\Framework\TestCase;

use Doctrine\ORM\EntityManager;
use RosterBundle\Service\CommonBotGenerator;
use RosterBundle\Entity\League;
use RosterBundle\Entity\Bot;

class CommonBotGeneratorTest extends TestCase
{
    const LEAGUE_ID = 65;
    const TYPE_ST = 'starter';
    const TYPE_SUB = 'substitute';

    protected $mockedLeague;
    protected $container;
    protected $mockedEntityManager;

    public function setUp()
    {
        $this->mockedLeague = $this->createMock(League::class);
        $mockedEntityManager = $this->createMock(EntityManager::class);

        $this->commonBotGenerator = new CommonBotGenerator($mockedEntityManager);
    }

    /**
     * @dataProvider generatorProvider
     */
    public function testGenerate($leagueId, $type)
    {
        $this->mockedLeague
            ->method('getId')
            ->willReturn($leagueId);

        $bot = $this->commonBotGenerator->generate($this->mockedLeague, $type);

        $this->assertInstanceOf(Bot::class, $bot);
        $this->assertInstanceOf(League::class, $bot->getLeague());
        $this->assertEquals($bot->getType(), $type);
    }

    public function generatorProvider()
    {
        return array(
            array(self::LEAGUE_ID, self::TYPE_ST),
            array(self::LEAGUE_ID, self::TYPE_SUB)
        );
    }
}
