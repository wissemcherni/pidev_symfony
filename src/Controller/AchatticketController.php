<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Achatticket;
use App\Form\AchatticketType;
use App\Repository\AchatticketRepository;
class AchatticketController extends AbstractController
{
    #[Route('/achatticket', name: 'app_achatticket')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Achatticket::class);
        $Achatticket=$repo->findAll();
        return $this->render('achatticket/index.html.twig', [
            'controller_name' => 'AchatticketController', 'Achatticket'=>$Achatticket
        ]);
    }
    #[Route('/addticket', name: 'addticket')] 

   
    public function addticket(Request $req,ManagerRegistry $doctrine){
        $Achatticket = new Achatticket();
        $form = $this->createForm(AchatticketType::class,$Achatticket);
        $form->handleRequest($req);
        $entitymanager=$doctrine->getManager();
        if($form->isSubmitted()){
            $entitymanager->persist($Achatticket);
            $entitymanager->flush();
            return $this->redirectToRoute('app_achatticket');
        }
        return $this->render('achatticket/addticket.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route('/updateticket/{id}',name: 'ticket_update')]
    public function updateticket(Request $req,$id,AchatticketRepository $repo,ManagerRegistry $doctrine){
        $Achatticket = $repo->find($id);
        $form = $this->createForm(AchatticketType::class,$Achatticket);
        $form->handleRequest($req);
        $entitymanager=$doctrine->getManager();
        if($form->isSubmitted()){
            $entitymanager->flush();
            return $this->redirectToRoute('app_achatticket');
        }
        return $this->render('achatticket/addticket.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route('/deleteticket/{id}',name: 'ticket_delete')]
    public function delete($id,AchatticketRepository $repo){
        $Achatticket = $repo->find($id);
        $repo->remove($Achatticket,true);
        return $this->redirectToRoute('app_achatticket');
    }
    
}

