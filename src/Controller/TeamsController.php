<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TeamsController extends AbstractController
{
    /**
     * @Route("/teams", name="teams_gets", methods={"GET"})
     */
    public function getsAction()
    {
        return new JsonResponse(['teams' => 'adasa']);
    }
}
