<?php
namespace RosterBundle\Interfaces;

use RosterBundle\Entity\League;

interface BotGeneratorInterface
{
    public function generate(League $league, $type);
}
