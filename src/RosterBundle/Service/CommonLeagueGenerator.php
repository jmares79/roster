<?php

namespace RosterBundle\Service;

use Doctrine\ORM\EntityManager;
use RosterBundle\Interfaces\LeagueGeneratorInterface;
use RosterBundle\Service\CommonBotGenerator;
use RosterBundle\Entity\League;
use RosterBundle\Entity\Bot;

class CommonLeagueGenerator implements LeagueGeneratorInterface
{
    const STARTERS_AMOUNT = 10;
    const SUBSTITUTES_AMOUNT = 5;
    const MAX_TEAM_SALARY = 175;
    const ST = 'starter';
    const SUB = 'substitute';

    protected $league;
    protected $botGenerator;
    protected $em;

    public function __construct(CommonBotGenerator $generator, EntityManager $entityManager)
    {
        $this->botGenerator = $generator;
        $this->em = $entityManager;
    }

    public function generateLeague()
    {
        $this->league = new League();
        $this->league->setSalary(0);

        $this->generateTeam();

        $this->em->persist($this->league);
        $this->em->flush();

        return $this->league;
    }

    protected function generateTeam()
    {
        $this->generateBotByType(self::ST);
        $this->generateBotByType(self::SUB);
    }

    protected function generateBotByType($type)
    {
        $capacity = $type == self::ST ? self::STARTERS_AMOUNT : self::SUBSTITUTES_AMOUNT;
        $amount = 0;

        $bot = $this->botGenerator->generate($this->league, $type);

        while ($this->isValidLeague($bot) && $amount < $capacity) {
            $this->em->persist($bot);
            $this->league->addBot($bot);

            $bot = $this->botGenerator->generate($this->league, $type);

            $amount++;
        }
    }

    protected function isValidLeague(Bot $bot)
    {
        $exists = $this->league->getBots()->exists(function($key, $item) use ($bot) {
            return $item->getTotalScore() == $bot->getTotalScore();
        });

        return !$exists;
    }
}
