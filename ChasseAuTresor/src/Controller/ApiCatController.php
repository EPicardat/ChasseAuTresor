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

        // On compare ces coordonnées avec les coordonnées solutions de la partie (id partie)
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

        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $q =$request->query->get('q');
        $partie=$partieRepo->find($q);

        $latitudeSolution = $partie->getLatitude();
        $longitudeSolution = $partie->getLongitude();
        $accuracySolution = $partie->getAccuracy();

        // on récupère les coordonnées soumises

        $latitudeSoumise = ;
        $longitudeSoumise = ;
        $accuracySoumise = ;

        // on compare les deux accuracies. On travaille avec la plus grandes des deux.
        $accuracyUtile = $accuracySoumise;
        if($accuracySolution>$accuracySoumise){
            $accuracyUtile = $accuracySolution;
        }

        // on récupère la distance à vol d'oiseau en mètre (orthodromique) entre la position soumise et la position solution

        $d = distance_orthodromique($latitudeSoumise, $latitudeSolution, $longitudeSoumise, $longitudeSolution);

        // Si la $d est inférieure ou égale à l'accuracy utile, le joueur à bien trouvé le lieu du trésor : on passe le booléen found à true
        if ($d<= $accuracyUtile){
            $found = true;
        }

        // on renvoie le booléen $found

        return $found;
    }

    private function distance_orthodromique($latitudeSoumise, $latitudeSolution, $longitudeSoumise, $longitudeSolution, $precision = 3, $r = 6378.14)
    {
        // La variable $r correspond au rayon de la Terre.
        // $latitudeSoumise, $longitudeSoumise sont les latitudes de chaques points respectifs.
        // $latitudeSolution, $y$longitudeSolution2 sont les longitudes de chaques points respectifs.
        // $precision permet d'obtenir le nombre de chiffre après la virgule.
        // Elle est définit à 3 par défaut permettant d'obtenir une précision au mètre. Il vous suffira de la multiplier par 1000.

        // On convertit les latitudes et longitudes en radian.
        $latitudeSoumise = deg2rad($latitudeSoumise);
        $longitudeSoumise = deg2rad($longitudeSoumise);
        $latitudeSolution = deg2rad($latitudeSolution);
        $longitudeSolution = deg2rad($longitudeSolution);

        // On calcule des distances entre les deux points.
        $dlat = $longitudeSoumise - $latitudeSoumise;
        $dlong = $longitudeSolution - $latitudeSolution;

        // On applique la formule.
        $a = sin($dlat/2)*sin($dlat/2) + cos($latitudeSoumise)*cos($longitudeSoumise)*sin($dlong/2)*sin($dlong/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        // On récupère la valeur du résutat arrondi avec la précision.
        $d =  round($r*$c,  $precision)*1000;

        // On renvoie la distance en m
        return $d;
    }
}
