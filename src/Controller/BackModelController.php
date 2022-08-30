<?php

namespace App\Controller;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/model')]
class BackModelController extends AbstractController
{
    #[Route('/', name: 'app_back_model_index', methods: ['GET'])]
    public function index(ModelRepository $modelRepository): Response
    {
        return $this->render('back_model/index.html.twig', [
            'models' => $modelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_model_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ModelRepository $modelRepository): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modelRepository->add($model, true);

            return $this->redirectToRoute('app_back_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_model/new.html.twig', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_model_show', methods: ['GET'])]
    public function show(Model $model): Response
    {
        return $this->render('back_model/show.html.twig', [
            'model' => $model,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_model_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Model $model, ModelRepository $modelRepository): Response
    {
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modelRepository->add($model, true);

            return $this->redirectToRoute('app_back_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_model/edit.html.twig', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_model_delete', methods: ['POST'])]
    public function delete(Request $request, Model $model, ModelRepository $modelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) {
            $modelRepository->remove($model, true);
        }

        return $this->redirectToRoute('app_back_model_index', [], Response::HTTP_SEE_OTHER);
    }
}
