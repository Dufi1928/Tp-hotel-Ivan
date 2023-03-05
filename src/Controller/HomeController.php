<?php

namespace App\Controller;
use App\Entity\Hotel;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Suite;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HotelRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine,PaginatorInterface $paginator,Request $request,): Response
    {
        $hotelRepository = $doctrine->getRepository(Hotel::class);
        $hotels =  $hotelRepository->findAll();

        $hotels = $paginator->paginate(
            $hotels,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('home/index.html.twig', [
            'hotels' => $hotels,
            'controller_name' => 'HomeController',
        ]);
    }
}
