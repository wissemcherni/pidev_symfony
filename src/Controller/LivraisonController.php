<?php

namespace App\Controller;

//require_once __DIR__ . '/vendor/autoload.php';
use App\Entity\Livraison;
use App\Form\LivraisonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

#[Route('/livraison')]
class LivraisonController extends AbstractController
{
    #[Route('/', name: 'app_livraison_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $livraisons = $entityManager
            ->getRepository(Livraison::class)
            ->findAll();

        return $this->render('livraison/index.html.twig', [
            'livraisons' => $livraisons,
        ]);
    }

    #[Route('/new', name: 'app_livraison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livraison);
            $entityManager->flush();
            $accountSid = 'AC7b7bbabbd4a2b15f6f8e498ad5bae700';
            $authToken = '7076298a2f4827cbf20924a594712b20';
            $twilioNumber = '+16318835849';
            $client = new Client($accountSid, $authToken);
        
            $message = $client->messages->create(
                '+21627738109', // numéro de téléphone du destinataire
                array(
                    'from' => $twilioNumber,
                    'body' => sprintf(
                        'Nouvelle livraison ajoutée avec succès ! ID: %s, Nom du livreur: %s, Date de livraison: %s',
                        $livraison->getIdLivraison(),
                        $livraison->getNomLivreur(),
                        $livraison->getDateLivraison()->format('Y-m-d')
                    )
                )
            );
        
            return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
        }
        
        
        
        
        
        
        
        

        return $this->renderForm('livraison/new.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }

    #[Route('/{idLivraison}', name: 'app_livraison_show', methods: ['GET'])]
    public function show(Livraison $livraison): Response
    {
        return $this->render('livraison/show.html.twig', [
            'livraison' => $livraison,
        ]);
    }

    #[Route('/{idLivraison}/edit', name: 'app_livraison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livraison/edit.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }

    #[Route('/{idLivraison}', name: 'app_livraison_delete', methods: ['POST'])]
    public function delete(Request $request, Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livraison->getIdLivraison(), $request->request->get('_token'))) {
            $entityManager->remove($livraison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
    }

  
#[Route('/livraisons/recherche', name: 'livraisons_recherche', methods: ['GET'])]
public function rechercheLivraisons(Request $request)
{
    $nomLivreur = $request->query->get('nom_livreur');

    // Recherche les livraisons par nom de livreur
    $livraisons = $this->getDoctrine()->getRepository(Livraison::class)->findBy([
        'nomLivreur' => $nomLivreur
    ]);

    // Convertit les livraisons en un tableau JSON
    $livraisonsJson = [];
    foreach ($livraisons as $livraison) {
        $livraisonsJson[] = [
            'idLivraison' => $livraison->getIdLivraison(),
            'nomLivreur' => $livraison->getNomLivreur(),
            'dateLivraison' => ($livraison->getDateLivraison() ? $livraison->getDateLivraison()->format('Y-m-d') : null),

            'numCommande' => [
                'idCommande' => $livraison->getNumCommande()->getIdCommande(),
            ],
        ];
    }

    // Retourne les résultats de la recherche sous forme de JSON
    return new JsonResponse([
        'livraisons' => $livraisonsJson,
    ]);
}



}
