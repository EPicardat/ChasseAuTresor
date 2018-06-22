<?php

namespace App\Controller;

use App\Entity\Personnes;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     * @param $request
     * @param $passwordEncoder
     * @return
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new Personnes();
        $form = $this->createForm(RegisterType::class, $user);

        // 2) handle the submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User
            $entityManager = $this->getDoctrine()->getManager();
            $user->setDateInscription(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();

            // Add a flash message to confirm the registration.
            $this->addFlash("success", "Your account has been created.");
            return $this->redirect('http://localhost:8081/chasseautresor/IHM/#/connexion');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
