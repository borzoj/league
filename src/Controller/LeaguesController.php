<?php

namespace App\Controller;

use App\Entity\League;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LeaguesController extends AbstractController
{
    /**
     * @Route("/leagues", name="leagues_list", methods={"GET"})
     * @return JsonResponse json response
     */
    public function listAction(): JsonResponse
    {
        $leagues = $this->getDoctrine()
            ->getRepository(League::class)
            ->findAll();

        return new JsonResponse(array_map(
            function(League $l) {
                return [
                    'id' => $l->getId(),
                    'name' => $l->getName(),
                ];
            },
            $leagues
        ));
    }

    /**
     * @Route("/leagues", name="leagues_post", methods={"POST", "PUT"})
     * @param Request $request http request
     * @return JsonResponse json response
     */
    public function postAction(Request $request): JsonResponse
    {
        $name = $request->request->get('name');

        $league = new League();
        $league->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($league);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $league->getId(),
            'name' => $league->getName(),
        ]);

    }

    /**
     * @Route("/leagues/{id}", name="leagues_delete", requirements={"page"="\d+"}, methods={"DELETE"})
     * @param int $id league id
     * @return JsonResponse json response
     */
    public function deleteAction(int $id): JsonResponse
    {
        $league = $this->getDoctrine()
            ->getRepository(League::class)
            ->find($id);
        if (null === $league) {
            throw $this->createNotFoundException("League not found");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($league);
        $entityManager->flush();
        return new JsonResponse();
    }

    /**
     * @Route("/leagues/{id}", name="leagues_get", methods={"GET"})
     * @param int $id league id
     * @return JsonResponse json response
     */
    public function getAction(int $id): JsonResponse
    {
        $team = $this->getDoctrine()
            ->getRepository(League::class)
            ->find($id);

        if (null === $team) {
            throw $this->createNotFoundException("League not found");
        }

        return new JsonResponse([
            'id' => $team->getId(),
            'name' => $team->getName(),
        ]);

    }
}
