<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    #[Route('/admin/aliment', name: 'admin_aliment')]
    public function index(AlimentRepository $respository): Response
    {
        $aliments = $respository->findAll();
        return $this->render('admin/admin/aliment/adminAliment.html.twig', [
            "aliments" => $aliments,
        ]);
    }


    #[Route('/admin/aliment/creation', name: 'admin_aliment_creation')]
    #[Route('/admin/aliment/modification/{id}', name: 'admin_aliment_modification', methods:'GET|POST')]
    public function ajoutEtModif(Aliment $aliment = null, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if(!$aliment) {
            $aliment = new Aliment();
        }

        $form = $this->createForm(AlimentType::class,$aliment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $aliment->getId() !== null;
            $entityManagerInterface->persist($aliment);
            $entityManagerInterface->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectuée" : "L'ajout a été effectuée");
            return $this->redirectToRoute("admin_aliment");
        }

        return $this->render('admin/admin/aliment/modifEtAjout.html.twig',[
            "aliment" => $aliment,
            "form" => $form->createView(),
            "isModification" => $aliment->getId() !== null
        ]);
    }

    #[Route('/admin/aliment/{id}', name: 'admin_aliment_suppression')]
    public function suppression(Aliment $aliment, Request $request, EntityManagerInterface $entityManagerInterface){
        if($this->isCsrfTokenValid("SUP". $aliment->getId(),$request->get('_token'))){
            $entityManagerInterface->remove($aliment);
            $entityManagerInterface->flush();
            $this->addFlash("success","La suppression a été effectuée");
        } else {
            $this->addFlash("error","La suppression a échoué, veuillez réessayer.");
        }
        return $this->redirectToRoute("admin_aliment");
    }


    
}
