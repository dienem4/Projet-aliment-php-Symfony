<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    #[Route('/admin/type', name: 'admin_types')]
    public function index(TypeRepository $repo): Response
    {
        $types = $repo->findAll();
        return $this->render('admin/type/adminType.html.twig',[
            "types" => $types
        ]);
    }

    
    #[Route('/admin/type/create', name: 'ajoutType')]
    #[Route('/admin/type/modification/{id}', name: 'modifType', methods:'GET|POST')]
    public function ajoutEtModif(Type $type = null,Request $request, EntityManagerInterface $om)
    {
        if(!$type){
            $type = new Type();
        }

        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om->persist($type);
            $om->flush();
            $this->addFlash('success', "L'action a été réalisée");
            return $this->redirectToRoute("admin_types");
        }

        return $this->render('admin/type/ajoutEtModif.html.twig',[
            "type" => $type,
            "form" => $form->createView(),
            "isModification" => $type->getId() !== null
        ]);
    }

    #[Route('/admin/type/{id}', name: 'supType')]
    public function suppression(Type $type, EntityManagerInterface $om, Request $request)
    {
       if($this->isCsrfTokenValid('SUP'.$type->getId(), $request->get('_token'))){
           $om->remove($type);
           $om->flush();
           $this->addFlash('success', "L'action a été réalisée");
           return $this->redirectToRoute("admin_types");
           $this->addFlash("success","La suppression a été effectuée");

        } else {

            $this->addFlash("error","La suppression a échoué, veuillez réessayer.");
        }
        return $this->redirectToRoute("admin_types");
    }

 
}
