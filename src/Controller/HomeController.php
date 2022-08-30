<?php

namespace App\Controller;

use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ListingRepository $listingRepository): Response
    {
        return $this->render('front/home/index.html.twig', [
            
            'listings' => $listingRepository->findAll([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/show/{id}', name: 'app_show')]
    public function show(ListingRepository $listingRepository, $id): Response
    {
        return $this->render('front/home/show.html.twig', [
            'listing' => $listingRepository->find($id),
        ]);
    }
}
