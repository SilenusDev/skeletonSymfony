<?php

namespace App\Controller;

use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ListingRepository $listingRepository, Request $request, 
    PaginatorInterface $paginator,): Response
    {

        $qb = $listingRepository->getQbAll();
        // Paginator
        $listings = $paginator->paginate(
            $qb,
            $request->query->getInt('page',1),12
        );
        return $this->render('front/home/index.html.twig', [
            
            'listings' => $listings,
        
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
