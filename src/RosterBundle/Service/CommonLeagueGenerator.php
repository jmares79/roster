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

    protected $team = array();
    protected $generator;
    protected $em;

    public function __construct(CommonBotGenerator $generator, EntityManager $entityManager)
    {
        $this->generator = $generator;
        $this->em = $entityManager;
    }

    public function generateLeague()
    {
        $league = new League();
        $league->setSalary(0);

        $league = $this->generateTeam($league);


        $this->em->persist($league);
        $this->em->flush($league);

        return $league;
    }

    protected function generateTeam(League $league)
    {
        echo "<pre>"; var_dump($league); echo "</pre>";
        $this->generateBotByType($league, self::ST);
        $this->generateBotByType($league, self::SUB);
    }

    protected function generateBotByType(League $league, $type)
    {
        $bot = $this->generator->generate($type);

        while ($this->isValid($league, $bot) && $this->teamIsFull($league, $type)) {
            $bot = $this->generator->generate($type);
            $bot->setType($type);

            $league->addBot($bot);
        }

        return $league;
    }

    protected function teamIsFull(League $league, $type)
    {
        return true;
    }

    protected function isValid(League $league, Bot $bot)
    {
        return true;
    }
}
