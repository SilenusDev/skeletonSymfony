<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Form\Listing1Type;
use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/front/listing')]
class FrontListingController extends AbstractController
{
    #[Route('/', name: 'app_front_listing_index', methods: ['GET'])]
    public function index(ListingRepository $listingRepository): Response
    {
        return $this->render('front_listing/index.html.twig', [
            'listings' => $listingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_front_listing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListingRepository $listingRepository): Response
    {
        $listing = new Listing();
        $form = $this->createForm(Listing1Type::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listingRepository->add($listing, true);

            return $this->redirectToRoute('app_front_listing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front_listing/new.html.twig', [
            'listing' => $listing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_front_listing_show', methods: ['GET'])]
    public function show(Listing $listing): Response
    {
        return $this->render('front_listing/show.html.twig', [
            'listing' => $listing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_front_listing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Listing $listing, ListingRepository $listingRepository): Response
    {
        $form = $this->createForm(Listing1Type::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listingRepository->add($listing, true);

            return $this->redirectToRoute('app_front_listing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front_listing/edit.html.twig', [
            'listing' => $listing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_front_listing_delete', methods: ['POST'])]
    public function delete(Request $request, Listing $listing, ListingRepository $listingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listing->getId(), $request->request->get('_token'))) {
            $listingRepository->remove($listing, true);
        }

        return $this->redirectToRoute('app_front_listing_index', [], Response::HTTP_SEE_OTHER);
    }
}
