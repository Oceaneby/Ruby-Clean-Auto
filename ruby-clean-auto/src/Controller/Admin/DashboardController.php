<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Admin;
use App\Entity\Service;
use App\Entity\Gallery;
use App\Entity\HomeContent;
use App\Entity\ContactRequest;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
       $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Par défaut, on redirige vers la gestion des admins
        return $this->redirect($adminUrlGenerator->setController(AdminCrudController::class)->generateUrl());
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ruby Clean Auto');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Admins', 'fas fa-user-shield', Admin::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-cogs', Service::class);
        yield MenuItem::linkToCrud('Galleries', 'fas fa-image', Gallery::class);
        yield MenuItem::linkToCrud('Home Contents', 'fas fa-home', HomeContent::class);
        yield MenuItem::linkToCrud('Contact Requests', 'fas fa-envelope', ContactRequest::class);
    }
}
