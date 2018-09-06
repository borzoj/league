<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Team;
use App\Entity\League;

class TeamsController extends AbstractController
{
    /**
     * @Route("/teams", name="teams_list", methods={"GET"})
     * @return JsonResponse json response
     */
    public function listAction(): JsonResponse
    {
        $teams = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findAll();

        return new JsonResponse(array_map(
            function(Team $t) {
                return [
                    'id' => $t->getId(),
                    'name' => $t->getName(),
                    'strip' => $t->getStrip(),
                    'league_id' => $t->getLeague()->getId(),
                ];
            },
            $teams
        ));
    }

    /**
     * @Route("/teams", name="teams_post", methods={"POST", "PUT"})
     * @param Request $request http request
     * @return JsonResponse json response
     */
    public function postAction(Request $request): JsonResponse
    {
        $name = $request->request->get('name');
        $strip = $request->request->get('strip');
        $leagueId = $request->request->get('league_id');

        $league = $this->getDoctrine()
            ->getRepository(League::class)
            ->find($leagueId);
        if (null === $league) {
            throw $this->createNotFoundException("League not found");
        }
        $team = new Team();
        $team->setName($name);
        $team->setStrip($strip);
        $team->setLeague($league);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($team);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league_id' => $team->getLeague()->getId(),
        ]);

    }

    /**
     * @Route("/teams/{id}", name="teams_put", methods={"PUT"})
     * @param Request $request http request
         * @param int $id team id
     * @return JsonResponse json response
     */
    public function putAction(Request $request, int $id): JsonResponse
    {
        $name = $request->request->get('name');
        $strip = $request->request->get('strip');
        $leagueId = $request->request->get('league_id');

        $team = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($id);

        if (null === $team) {
            throw $this->createNotFoundException("Team not found");
        }

        $league = $this->getDoctrine()
            ->getRepository(League::class)
            ->find($leagueId);
        if (null === $league) {
            throw $this->createNotFoundException("League not found");
        }

        $team->setName($name);
        $team->setStrip($strip);
        $team->setLeague($league);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($team);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league_id' => $team->getLeague()->getId(),
        ]);

    }

    /**
     * @Route("/teams/{id}", name="teams_get", methods={"GET"})
     * @param int $id team id
     * @return JsonResponse json response
     */
    public function getAction(int $id): JsonResponse
    {
        $team = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($id);

        if (null === $team) {
            throw $this->createNotFoundException("Team not found");
        }

        return new JsonResponse([
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league_id' => $team->getLeague()->getId(),
        ]);

    }
}
