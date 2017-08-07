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
use JMS\SerializerBundle\JMSSerializerBundle;
use RosterBundle\Entity\League;
use RosterBundle\Entity\Bot;

class RosterController extends Controller
{
    /**
     * @Route("/bot/{id}", name="get_bot")
     * @Method({"GET"})
     */
    public function getBotAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $bot = $em->getRepository('RosterBundle:Bot')->findOneById($id);

        if (null == $bot) { return new JsonResponse(array('bot' => $bot), Response::HTTP_NOT_FOUND); }

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();

        return new Response(array('bot'=> $serializer->serialize($bot, 'json')), Response::HTTP_OK);
    }

    /**
     * @Route("/bot/{leagueId}")
     * @Method({"POST"})
     */
    public function newBotAction(Request $request, CommonBotGenerator $generator, $leagueId)
    {
        if (null == $leagueId) { return new JsonResponse(array(), Response::HTTP_BAD_REQUEST); }

        $repository = $this->getDoctrine()->getRepository(League::class);
        $league = $repository->findOneById($leagueId);

        if (null == $league) { return new JsonResponse(array(), Response::HTTP_NOT_FOUND); }

        try {
            $bot = $generator->generate($league);
            $this->em->persist($bot);
            $this->em->flush();

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

    /**
     * @Route("/league/{id}", name="get_league")
     * @Method({"GET"})
     */
    public function getLeagueAction(Request $request, $id)
    {
        if (null == $id) { return new JsonResponse(array(), Response::HTTP_BAD_REQUEST); }

        $repository = $this->getDoctrine()->getRepository(League::class);
        $league = $repository->findOneById($leagueId);

        if (null == $league) { return new JsonResponse(array(), Response::HTTP_NOT_FOUND); }

        return new JsonResponse(array('data' => $league), Response::HTTP_OK);
    }

    /**
     * Generates a new valid league, that will be neccesary to hold a team
     * @Route("/league")
     * @Method({"POST"})
     */
    public function newLeagueAction(Request $request, CommonLeagueGenerator $generator)
    {
        try {
            $league = $generator->generateLeague();

            $response = new JsonResponse();
            $response->setStatusCode(Response::HTTP_CREATED);

            $response->headers->set('Location',
                $this->generateUrl('get_league', array('id' => $league->getId()), true)
            );

            return $response;
        } catch (LeagueGenerationException $e) {
            return new JsonResponse($e->getMessage, Response::HTTP_BAD_REQUEST);
        }
    }
}
