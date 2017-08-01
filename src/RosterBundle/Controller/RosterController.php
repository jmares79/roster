<?php

namespace RosterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/bot")
     * @Method({"POST"})
     */
    public function newBotAction(Request $request)
    {
        die('NEW BOT');
    }
}
