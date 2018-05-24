<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameCreationController extends Controller
{
    /**
     * @Route("/creationChasse", name="creation")
     */
    public function index()
    {
        return $this->render('hunt_creation/creation.html.twig', [
            'controller_name' => 'GameCreationController',
        ]);
    }
}
