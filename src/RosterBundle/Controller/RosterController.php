<?php

namespace RosterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use RosterBundle\Exception\LeagueGenerationException;
use RosterBundle\Exception\InvalidBotGenerationException;
use RosterBundle\Service\CommonLeagueGenerator;
use RosterBundle\Service\CommonBotGenerator;

class RosterController extends Controller
{
    /**
     * @Route("/bot/{id}", name="get_bot")
     * @Method({"GET"})
     */
    public function getBotAction(Request $request, $id)
    {
        die('BOT GET');
    }

    /**
     * Generates a new valid league, that consists of 10 starters and 5 substitutes
     * @Route("/league")
     * @Method({"POST"})
     */
    public function newLeagueAction(Request $request, CommonLeagueGenerator $generator)
    {
        try {
            $league = $generator->generateLeague();

            return new JsonResponse($league, Response::HTTP_CREATED);
        } catch (LeagueGenerationException $e) {
            return new JsonResponse($e->getMessage, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/bot")
     * @Method({"POST"})
     */
    public function newBotAction(Request $request, CommonBotGenerator $generator)
    {
        try {
            $bot = $generator->generate();
            $response = new JsonResponse();

            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Location',
                $this->generateUrl('get_bot', array('id' => $bot->getId()), true)
            );

            return $response;
        } catch (InvalidBotGenerationException $e) {
            return new JsonResponse($e->getMessage, Response::HTTP_BAD_REQUEST);
        }
    }
}
