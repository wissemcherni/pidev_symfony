<?php

namespace App\Controller;

use App\Entity\ProduitEchange;
use App\Form\ProduitEchangeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit/echange')]
class ProduitEchangeController extends AbstractController
{
    #[Route('/', name: 'app_produit_echange_index', methods: ['GET'])]
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $produitEchanges = $entityManager->getRepository(ProduitEchange::class);
        $query = $produitEchanges->findAll();
        var_dump($query->getSQL());
        /*return $this->render('produit_echange/index.html.twig', [
            'produit_echanges' => $produitEchanges,
        ]);*/
    }

    #[Route('/new', name: 'app_produit_echange_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produitEchange = new ProduitEchange();
        $form = $this->createForm(ProduitEchangeType::class, $produitEchange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produitEchange);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_echange_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit_echange/new.html.twig', [
            'produit_echange' => $produitEchange,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_echange_show', methods: ['GET'])]
    public function show(ProduitEchange $produitEchange): Response
    {
        return $this->render('produit_echange/show.html.twig', [
            'produit_echange' => $produitEchange,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_echange_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProduitEchange $produitEchange, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitEchangeType::class, $produitEchange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_echange_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit_echange/edit.html.twig', [
            'produit_echange' => $produitEchange,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_echange_delete', methods: ['POST'])]
    public function delete(Request $request, ProduitEchange $produitEchange, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produitEchange->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produitEchange);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_echange_index', [], Response::HTTP_SEE_OTHER);
    }
}
