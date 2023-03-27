<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\SeqrchAvalableRoomsType;
use App\Repository\HotelRepository;
use App\Repository\SuiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, PaginatorInterface $paginator, SuiteRepository $suiteRepository, Request $request): Response
    {
        $hotelRepository = $doctrine->getRepository(Hotel::class);
        $hotels =  $hotelRepository->findAll();
        $hotels = $paginator->paginate(
            $hotels,
            $request->query->getInt('page', 1),
            9
        );

        $form = $this->createForm(SeqrchAvalableRoomsType::class);
        $form->handleRequest($request);

        $suites = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('app_search_results', [
                'city' => $data['city'],
                'checkInDate' => $data['checkInDate']->format('Y-m-d'),
                'checkOutDate' => $data['checkOutDate']->format('Y-m-d'),
                'beds' => $data['beds'],
            ]);
        }

        return $this->render('home/index.html.twig', [
            'hotels' => $hotels,
            'form' => $form->createView(),
            'suites' => $suites,
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/search-results', name: 'app_search_results')]
    public function searchResults(SuiteRepository $suiteRepository, Request $request): Response
    {
        $data = $request->query->all();
        $checkInDate = \DateTime::createFromFormat('Y-m-d', $data['checkInDate']);
        $checkOutDate = \DateTime::createFromFormat('Y-m-d', $data['checkOutDate']);

        $suites = $suiteRepository->findAvailableSuites(
            $data['city'],
            $checkInDate,
            $checkOutDate,
            (int) $data['beds']
        );

        return $this->render('home/search_results.html.twig', [
            'suites' => $suites,
        ]);
    }




}