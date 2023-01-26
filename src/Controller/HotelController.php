<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hotel;

class HotelController extends AbstractController
{
    #[Route('/hotel/{id}', name: 'app_hotel')]
    public function index(ManagerRegistry $doctrine,int $id): Response
    {

        $hotelRepository = $doctrine->getRepository(Hotel::class);
        $hotel =  $hotelRepository->find($id);
//        dd($hotel);

        return $this->render('hotel/show.twig', [
            'controller_name' => 'HotelController',
            'hotel' => $hotel

        ]);
    }
}
