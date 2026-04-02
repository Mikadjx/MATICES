<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Photo;
use App\Entity\Song;
use App\Entity\User;
use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MATICES - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Contenu');
        yield MenuItem::linkToCrud('Photos', 'fas fa-images', Photo::class);
        yield MenuItem::linkToCrud('Vidéos', 'fas fa-video', Video::class);
        yield MenuItem::linkToCrud('Musique', 'fas fa-music', Song::class);
        yield MenuItem::linkToCrud('Événements', 'fas fa-calendar', Event::class);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Membres', 'fas fa-users', User::class);
        yield MenuItem::section('');
        yield MenuItem::linkToUrl('Voir le site', 'fas fa-eye', '/');
    }
}
