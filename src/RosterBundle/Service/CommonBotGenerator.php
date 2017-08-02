<?php

namespace RosterBundle\Service;

use Doctrine\ORM\EntityManager;
use RosterBundle\Exception\InvalidBotGenerationException;
use RosterBundle\Interfaces\BotGeneratorInterface;
use RosterBundle\Entity\Bot;

class CommonBotGenerator implements BotGeneratorInterface
{
    const MAX_TOTAL_SCORE = 100;
    protected $attributes = array('speed', 'strength', 'agility');
    protected $bot;
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function generate($type = null)
    {
        $bot = new Bot();

        $bot = $this->generateAttributes($bot);
        $bot = $this->generateName($bot);
        $bot->setType($type);

        if (!$this->isValid($bot)) { throw new InvalidBotGenerationException(); }

        $this->em->persist($bot);
        $this->em->flush($bot);

        return $bot;
    }

    protected function generateAttributes(Bot $bot)
    {
        $totalScore = 0;
        shuffle($this->attributes);
        $remaining = self::MAX_TOTAL_SCORE;

        foreach ($this->attributes as $attribute) {
            $setAttribute = "set".ucfirst($attribute);
            $getAttribute = "get".ucfirst($attribute);

            $value = rand(1, $remaining);
            $bot->$setAttribute($value);

            $totalScore += $value;
            $remaining = $remaining - $bot->$getAttribute();
        }

        $bot->setTotalScore($totalScore);

        return $bot;
    }

    protected function generateName($bot)
    {
        return $bot->setName(uniqid('', true));
    }

    protected function isValid(Bot $bot)
    {
        return ($bot->getTotalScore() <= self::MAX_TOTAL_SCORE);
    }
}
