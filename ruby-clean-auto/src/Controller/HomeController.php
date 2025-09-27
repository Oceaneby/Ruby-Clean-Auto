<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
   
    public function index(GalleryRepository $galleryRepository): Response
{
    $realisations = [];

    for ($i = 1; $i <= 4; $i++) {
        $avant = $galleryRepository->findOneBy([
            'nettoyageNumber' => $i,
            'photoType' => 'avant'
        ]);

        $apres = $galleryRepository->findOneBy([
            'nettoyageNumber' => $i,
            'photoType' => 'apres'
        ]);

        $realisations[$i] = [
            'avant' => $avant,
            'apres' => $apres
        ];
    }

    return $this->render('home/index.html.twig', [
        'realisations' => $realisations,
    ]);
}
}
