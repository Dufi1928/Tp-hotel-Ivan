<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Entity\Suite;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
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

        yield MenuItem::linkToCrud('Hotels', 'fas fa-hotel', Hotel::class)
            ->setController(HotelCrudController::class);

        yield MenuItem::linkToCrud('Suites', 'fas fa-person-booth', Suite::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
    }
}