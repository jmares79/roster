<?php

namespace RosterBundle\Service;

use RosterBundle\Interfaces\LeagueGeneratorInterface;
use RosterBundle\Service\CommonBotGenerator;

class CommonLeagueGenerator implements LeagueGeneratorInterface
{
    const STARTERS_AMOUNT = 10;
    const SUBSTITUTES_AMOUNT = 5;
    const MAX_TEAM_SALARY = 175;
    protected $generator;
    protected $starters = array();
    protected $substitutes = array();
    protected $substitutes = array();

    public function __construct(CommonBotGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function generateLeague()
    {

    }

    protected function calculateTotalScore()
    {

    }

    protected function isValid()
    {

    }
}
