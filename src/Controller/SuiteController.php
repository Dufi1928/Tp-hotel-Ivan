<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Suite;

class SuiteController extends AbstractController
{

    #[Route('/room/show/ {suiteId}', name: 'app_room_show')]
    public function showRoom(ManagerRegistry $doctrine, int $suiteId): Response
    {
        $suiteRepository = $doctrine->getRepository(Suite::class);
        $suite = $suiteRepository -> find($suiteId);
        return $this->render('room_show/index.html.twig', [
            'controller_name' => 'SuiteController',
            'suite' => $suite
        ]);
    }
}
