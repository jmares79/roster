<?php

namespace RosterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RosterBundle\Service\CommonLeagueGenerator;

class RosterController extends Controller
{
    /**
     * @Route("/bots")
     * @Method({"GET"})
     */
    public function getBotsAction()
    {
        die('HERE');
    }

    /**
     * Generates a new valid league, that consists of 10 starters and 5 substitutes
     * @Route("/league")
     * @Method({"POST"})
     */
    public function newLeagueAction(Request $request, CommonLeagueGenerator $generator)
    {
        var_dump($generator);
        die('NEW BOT');
    }
}
