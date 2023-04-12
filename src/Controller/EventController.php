<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Event::class);
        $Event=$repo->findAll();
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',  'Event'=>$Event
        ]);
    }
    #[Route('/frontevent', name: 'frontevent')]
    public function indexfront(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Event::class);
        $Event=$repo->findAll();
        return $this->render('event/frontevent.html.twig', [
            'controller_name' => 'EventController',  'Event'=>$Event
        ]);
    }
    #[Route('/addevent', name: 'addevent')] 

   
    public function addevent(Request $req,ManagerRegistry $doctrine){
        $Event = new Event();
        $form = $this->createForm(EventType::class,$Event);
        $form->handleRequest($req);
        $entitymanager=$doctrine->getManager();
        if($form->isSubmitted()){
            $entitymanager->persist($Event);
            $entitymanager->flush();
            return $this->redirectToRoute('app_event');
        }
        return $this->render('event/addevent.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route('/updateevent/{id}',name: 'event_update')]
    public function updateevent(Request $req,$id,EventRepository $repo,ManagerRegistry $doctrine){
        $Event = $repo->find($id);
        $form = $this->createForm(EventType::class,$Event);
        $form->handleRequest($req);
        $entitymanager=$doctrine->getManager();
        if($form->isSubmitted()){
            $entitymanager->flush();
            return $this->redirectToRoute('app_event');
        }
        return $this->render('event/addevent.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route('/deleteevent/{id}',name: 'event_delete')]
    public function deleteevent($id,EventRepository $repo){
        $Event = $repo->find($id);
        $repo->remove($Event,true);
        return $this->redirectToRoute('app_event');
    }
    
}
