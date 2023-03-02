<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Suite;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HotelRepository;


class HotelController extends AbstractController
{
    #[Route('/hotel/{hotelId}', name: 'app_hotel')]
    public function index(ManagerRegistry $doctrine,int $hotelId, PaginatorInterface $paginator,Request $request, EntityManagerInterface $entityManager): Response
    {
        $suiteRepository = $entityManager->getRepository(Suite::class);
        $suites = $suiteRepository->findAllSuitesByHotelId($hotelId);
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        $hotel =  $hotelRepository->findById($hotelId);

        $suites = $paginator->paginate(
            $suites,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('hotel/show.twig', [
            'controller_name' => 'HotelController',
            'suites' => $suites,
            'hotel'=> $hotel
        ]);
    }

}



