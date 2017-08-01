<?php

namespace RosterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bot
 *
 * @ORM\Table(name="bot")
 * @ORM\Entity(repositoryClass="RosterBundle\Repository\BotRepository")
 */
class Bot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="speed", type="float")
     */
    private $speed;

    /**
     * @var float
     *
     * @ORM\Column(name="strength", type="float")
     */
    private $strength;

    /**
     * @var float
     *
     * @ORM\Column(name="agility", type="float")
     */
    private $agility;

    /**
     * @var float
     *
     * @ORM\Column(name="totalScore", type="float")
     */
    private $totalScore;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Bot
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set speed
     *
     * @param float $speed
     *
     * @return Bot
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set strength
     *
     * @param float $strength
     *
     * @return Bot
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength
     *
     * @return float
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set agility
     *
     * @param float $agility
     *
     * @return Bot
     */
    public function setAgility($agility)
    {
        $this->agility = $agility;

        return $this;
    }

    /**
     * Get agility
     *
     * @return float
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * Set totalScore
     *
     * @param float $totalScore
     *
     * @return Bot
     */
    public function setTotalScore($totalScore)
    {
        $this->totalScore = $totalScore;

        return $this;
    }

    /**
     * Get totalScore
     *
     * @return float
     */
    public function getTotalScore()
    {
        return $this->totalScore;
    }
}

