<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GalleryRepository;
use Symfony\Component\Routing\Attribute\Route;

final class GalleryController extends AbstractController
{
    #[Route('/galerie', name: 'gallery_index')]
    public function index(GalleryRepository $galleryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $galleryRepository->createQueryBuilder('g')
            ->orderBy('g.createdAt', 'DESC');

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            20 /* limit per page */
        );

        return $this->render('gallery/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
