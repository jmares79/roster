<?php

namespace RosterBundle\Service;

use Doctrine\ORM\EntityManager;
use RosterBundle\Interfaces\LeagueGeneratorInterface;
use RosterBundle\Service\CommonBotGenerator;
use RosterBundle\Entity\League;

class CommonLeagueGenerator implements LeagueGeneratorInterface
{
    const STARTERS_AMOUNT = 10;
    const SUBSTITUTES_AMOUNT = 5;
    const MAX_TEAM_SALARY = 175;
    protected $starters = array();
    protected $substitutes = array();
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function generateLeague()
    {
        $league = new League();

        $league->setSalary(0);

        $this->em->persist($league);
        $this->em->flush($league);

        return $league;
    }
}
