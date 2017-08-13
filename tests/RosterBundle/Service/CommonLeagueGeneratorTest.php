<?php
use PHPUnit\Framework\TestCase;

use Doctrine\ORM\EntityManager;
use RosterBundle\Service\CommonLeagueGenerator;
use RosterBundle\Service\CommonBotGenerator;
use RosterBundle\Entity\League;
use RosterBundle\Entity\Bot;

class CommonLeagueGeneratorTest extends TestCase
{
    public function setUp()
    {
        $mockedBot = $this->createMock(Bot::class);
        $mockedBotGenerator = $this->createMock(CommonBotGenerator::class);
        $mockedEntityManager = $this->createMock(EntityManager::class);

        $mockedBotGenerator
            ->method('generate')
            ->willReturn($mockedBot);

        $mockedBot
            ->method('getTotalScore')
            ->will($this->onConsecutiveCalls(10, 15, 20, 25, 30, 35, 40, 45, 50, 55));

        $this->commonLeagueGenerator = new CommonLeagueGenerator($mockedBotGenerator, $mockedEntityManager);
    }

    public function testGenerateLeague()
    {
        $league = $this->commonLeagueGenerator->generateLeague();

        $this->assertInstanceOf(League::class, $league);
        $this->assertInstanceOf("Doctrine\Common\Collections\ArrayCollection", $league->getBots());
    }
}
