<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Hotel;
use App\Entity\Suite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Manager;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TP Hotel Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Managers', 'fas fa-people-roof', Manager::class);
        yield MenuItem::linkToCrud('Hotels', 'fas fa-hotel', Hotel::class);
        yield MenuItem::linkToCrud('Suites', 'fas fa-person-booth', Suite::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-users', Client::class);
    }
}
