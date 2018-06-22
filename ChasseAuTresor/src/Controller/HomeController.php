<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("", name="home")
     */
    public function index()
    {

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'userId' => $this->getUser()->getId(),
        ]);
    }
}
