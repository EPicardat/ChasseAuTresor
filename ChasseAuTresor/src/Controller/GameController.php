<?php

namespace App\Controller;

use App\Entity\Parties;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    /**
     * @Route("/game/{id}", name="game", requirements={"id":"[0-9]{1,12}"})
     */
    public function index($id)
    {
        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $partie = $partieRepo->find($id);


        // Renvoyer du json !
        return $this->render('game/game.html.twig', [
            'controller_name' => 'GameController',
            "id" => $id,
            "partie" => $partie,
        ]);
    }
}
