<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    #[Route('/', name: 'aliments')]
    public function index(AlimentRepository $alimentRepository): Response
    {
        $aliments = $alimentRepository->findAll();

        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => false
        ]);
    }

    #[Route('/aliments/calorie/{calorie}', name: 'alimentsParCalorie')]
    public function alimentsMoinsCaloriques(AlimentRepository $repository,$calorie)
    {
        $aliments = $repository->getAlimentParPropriete('calorie','<',$calorie);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true,
            'isGlucide' => false
        ]);
    }
    
    #[Route('/aliments/glucides/{glucide}', name: 'alimentsParGlucides')]
    public function alimentsAvecMoinsGlucides(AlimentRepository $repository,$glucide)
    {
        $aliments = $repository->getAlimentParPropriete('glucides','<',$glucide);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => true
        ]);
    }
}
