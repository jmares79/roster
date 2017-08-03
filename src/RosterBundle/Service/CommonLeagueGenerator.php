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
    protected $generator;
    protected $em;

    public function __construct(CommonBotGenerator $generator, EntityManager $entityManager)
    {
        $this->generator = $generator;
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

        for ($i = 0; $i < $capacity; $i++) {
            $this->generator->generate($this->league, $type);
        }
    }

    protected function isValid(Bot $bot)
    {
        return true;
    }
}
