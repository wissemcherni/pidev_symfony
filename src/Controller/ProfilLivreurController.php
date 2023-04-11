<?php

namespace App\Controller;

use App\Entity\ProfilLivreur;
use App\Form\ProfilLivreurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil/livreur')]
class ProfilLivreurController extends AbstractController
{
    #[Route('/', name: 'app_profil_livreur_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $profilLivreurs = $entityManager
            ->getRepository(ProfilLivreur::class)
            ->findAll();

        return $this->render('profil_livreur/index.html.twig', [
            'profil_livreurs' => $profilLivreurs,
        ]);
    }

    #[Route('/new', name: 'app_profil_livreur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profilLivreur = new ProfilLivreur();
        $form = $this->createForm(ProfilLivreurType::class, $profilLivreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profilLivreur);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_livreur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil_livreur/new.html.twig', [
            'profil_livreur' => $profilLivreur,
            'form' => $form,
        ]);
    }

    #[Route('/{idLivreur}', name: 'app_profil_livreur_show', methods: ['GET'])]
    public function show(ProfilLivreur $profilLivreur): Response
    {
        return $this->render('profil_livreur/show.html.twig', [
            'profil_livreur' => $profilLivreur,
        ]);
    }

    #[Route('/{idLivreur}/edit', name: 'app_profil_livreur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProfilLivreur $profilLivreur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfilLivreurType::class, $profilLivreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_livreur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil_livreur/edit.html.twig', [
            'profil_livreur' => $profilLivreur,
            'form' => $form,
        ]);
    }

    #[Route('/{idLivreur}', name: 'app_profil_livreur_delete', methods: ['POST'])]
    public function delete(Request $request, ProfilLivreur $profilLivreur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profilLivreur->getIdLivreur(), $request->request->get('_token'))) {
            $entityManager->remove($profilLivreur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profil_livreur_index', [], Response::HTTP_SEE_OTHER);
    }
}
