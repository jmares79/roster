<?php

namespace RosterBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * League
 *
 * @ORM\Table(name="league")
 * @ORM\Entity(repositoryClass="RosterBundle\Repository\LeagueRepository")
 *
 * @ExclusionPolicy("all")
 */
class League
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
     * @var float
     *
     * @ORM\Column(name="salary", type="float")
     *
     * @Expose
     */
    private $salary;

    /**
     * @ORM\OneToMany(targetEntity="Bot", mappedBy="league")
     *
     * @Expose
     */
    private $bots;

    public function __construct()
    {
        $this->bots = new ArrayCollection();
    }

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
     * Set salary
     *
     * @param float $salary
     *
     * @return League
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    public function getBots($type = null)
    {
        if (null == $type) {
            return $this->bots;
        } else {
            return $this->bots->filter(function($bot) use ($type) {
                return $bot->getType() == $type;
            });
        }
    }

    public function addBot(Bot $bot)
    {
        $this->bots->add($bot);
    }
}
