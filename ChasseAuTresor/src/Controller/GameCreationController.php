<?php

namespace App\Controller;

use App\Entity\Parties;
use App\Form\GameCreatorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameCreationController extends Controller
{
    /**
     * @Route("/create", name="creation")
     */
    public function register(Request $request)
    {
        // 1) build the form
        $game = new Parties();
        $form = $this->createForm(GameCreatorType::class, $game);

        // 2) handle the submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

           //

            // Add a flash message to confirm the registration.
            $this->addFlash("success", "Your game has been created.");

            return $this->redirectToRoute("");
        }

        return $this->render(
            'hunt_creation/creation.html.twig',
            array('form' => $form->createView())
        );
    }
}
