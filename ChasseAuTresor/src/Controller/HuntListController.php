<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HuntListController extends Controller
{
    /**
     * @Route("/chasses", name="huntList")
     */
    public function index()
    {
        return $this->render('hunt_list/chasses.html.twig', [
            'controller_name' => 'HuntListController',
        ]);
    }
}
