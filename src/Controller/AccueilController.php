<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController {

    #[Route('/accueil')]
    public function accueil(Request $request) {
        $ng = rand(1, 1_000_000);
        $jdls = [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi',
            'Dimanche'
        ];

        return $this->render('accueil.html.twig', [
            'numero_gagnant' => $ng,
            'semaine' => $jdls,
            'date_du_jour' => new \DateTime()
        ]);
    }
}
