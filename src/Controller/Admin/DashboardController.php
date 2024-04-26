<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Borrowing;
use App\Entity\Equipment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BorrowingCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProjetBeethoven');
    }

    public function configureMenuItems(): iterable
    {
        return [ 
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        MenuItem::linkToRoute('Retour au site', 'fa fa-home', 'home'),
        MenuItem::section('Livres'),
        MenuItem::linkToCrud('Emprunts', 'fa fa-tags', Borrowing::class),
        MenuItem::linkToCrud('Livres', 'fa fa-tags', Book::class),
        MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class),

        MenuItem::section('Utilisateurs'),
        MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),

        MenuItem::section('Salles'),
        MenuItem::linkToCrud('Salles', 'fa fa-tags', Room::class),
        MenuItem::linkToCrud('Equipements', 'fa fa-tags', Equipment::class),
        ];
    }
    
}
