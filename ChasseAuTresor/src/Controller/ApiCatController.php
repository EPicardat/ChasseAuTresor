<?php

namespace App\Controller;

use App\Entity\Parties;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiCatController extends Controller
{
    /**
     * @Route("/apiCat/v1/getPartie", name="get_partie", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPartie(Request $request)
    {
        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $q =$request->query->get('q');
        $parties=$partieRepo->find($q);

        return $this->json([
            "status"=>"ok",
            "message"=>"",
            "data"=>$parties,
        ]);
    }

    /**
     * @Route("/apiCat/v1/setPartie", name="set_partie", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function setPartie(Request $request)
    {
        //On crée une instance de partie vide
        $partie=new Parties();
        //On crée le formulaire et lui associe notre instance de partie vide
        $form=$this->createForm(Parties::class,$partie);
        //On prend les données du formulaire et les injecte dans la partie vide
        $form->handleRequest($request);

        //On récupère et set la date actuelle (== date début de partie)
        $partie->setDateDebut(new \DateTime());

        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($partie);
            $em->flush();
            return $this->redirectToRoute(""
                //TODO
            );
        }
        return $this->render("",[
            "form"=>$form->createView()
                //TODO
        ]);
    }

    /**
     * @Route("/apiCat/v1/submitLocGPS", name="submit_loc_gps", methods={"GET"})
     */
    public function submitLocGPS(Request $request)
    {
        // on enregistre les coordonnées dans la la table propositionGPS
        $this->setLocGPS($request);

        // On compare ces coordonnées avec les coordonnées solutions de la partie
        $found = $this->compareLocGPS($request);

        return $found;
    }

    private function setLocGPS(Request $request)
    {
    //TODO
    }

    private function compareLocGPS(Request $request)
    {
    //TODO

        //On set le booléen à faux par défault
        $found = false;

        // on récupère les coordonnées solutions

        // on les compare avec celles soumises

        // on renvoie un booléen true/false en fonction du résultat de la comparaison

        return $found;
    }
}
