<?php

namespace App\Controller\Admin;

use App\Entity\ChargingStation;
use App\Entity\Tenant;
use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(ChargingStationCrudController::class)->generateUrl());
        // return $routeBuilder;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tenants', 'fa fa-home', Tenant::class);
        yield MenuItem::linkToCrud('Stores', 'fa fa-home', Store::class);
        yield MenuItem::linkToCrud('Charging stations', 'fa fa-home', ChargingStation::class);
    }
}
