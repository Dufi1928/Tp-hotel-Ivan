<?php

namespace App\Controller\Manager;

use App\Entity\Hotel;
use App\Entity\Suite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerDashboardController extends AbstractDashboardController
{
    #[Route('/manager', name: 'manager')]
    public function index(): Response
    {
        return $this->render('manager/index.html.twig');
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TP Hotel Manager');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Suites', 'fas fa-person-booth', Suite::class)
            ->setController(ManagerSuitsController::class);

        yield MenuItem::linkToCrud('Hotel', 'fas fa-person-booth', Hotel::class)
            ->setController(ManagerCrudHotelCrudController::class);


    }
}
