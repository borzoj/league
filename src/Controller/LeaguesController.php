<?php

namespace App\Controller;

use App\Entity\League;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LeaguesController extends AbstractController
{
    /**
     * @Route("/leagues", name="leagues_gets", methods={"GET"})
     */
    public function getsAction()
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
     * @Route("/leagues/{id}", name="leagues_delete", requirements={"page"="\d+"}, methods={"DELETE"})
     */
    public function deleteAction(int $id)
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
}
