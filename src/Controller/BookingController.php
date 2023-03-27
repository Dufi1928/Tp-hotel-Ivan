<?php

namespace App\Controller;

use App\Entity\Suite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\Persistence\ManagerRegistry;

class BookingController extends AbstractController
{
    #[Route('/booking/{suite_id}' , name: 'book_suite')]
    public function index(Request $request, ManagerRegistry $doctrine, int $suite_id): Response
    {
        $suiteRepository = $doctrine->getRepository(Suite::class);
        $suite = $suiteRepository -> find($suite_id);

        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('confirmation_page');
        }

        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
            'suite' => $suite,
            'form' => $form->createView(),
        ]);
    }
}
