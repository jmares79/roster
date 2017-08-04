<?php

namespace RosterBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use RosterBundle\Entity\League;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bot
 *
 * @ORM\Table(name="bot")
 * @ORM\Entity(repositoryClass="RosterBundle\Repository\BotRepository")
 * @UniqueEntity("totalScore")
 * @UniqueEntity("name")
 *
 * @ExclusionPolicy("all")
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
     * @ORM\ManyToOne(targetEntity="League", inversedBy="bots")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     *
     */
    private $league;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Expose
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="speed", type="float")
     *
     * @Expose
     */
    private $speed;

    /**
     * @var float
     *
     * @ORM\Column(name="strength", type="float")
     *
     * @Expose
     */
    private $strength;

    /**
     * @var float
     *
     * @ORM\Column(name="agility", type="float")
     *
     * @Expose
     */
    private $agility;

    /**
     * @var float
     *
     * @ORM\Column(name="totalScore", type="float")
     *
     * @Expose
     */
    private $totalScore;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     *
     * @Expose
     */
    private $type;

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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Bot
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set league
     *
     * @return Bot
     */
    public function setLeague($league)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return string
     */
    public function getLeague()
    {
        return $this->league;
    }
}

