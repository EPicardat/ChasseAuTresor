<?php

namespace App\Controller;

use App\Entity\Indices;
use App\Entity\Parties;
use App\Entity\PersonneGpsPartie;
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
        $partiesRepo = $this->getDoctrine()->getRepository(Parties::class);
        $id = $request->query->get('id');
        $partie = $partiesRepo->find($id);

        return $this->json([
            "status" => "ok",
            "message" => "",
            "data" => $partie,
        ]);
    }

    /**
     * @Route("/apiCat/v1/setPartie", name="set_partie", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function setPartie(Request $request)
    {
        // On crée une instance de partie vide
        $partie = new Parties();
        // on crée le formulaire et lui associe notre instance de partie vide
        $form = $this->createForm(Parties::class, $partie);
        // On prend les données du formulaire et les injecte dans la partie vide
        $form->handleRequest($request);

        // On récupère et set la date actuelle (== date début de partie)
        $partie->setDateDebut(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partie);
            $em->flush();
            return $this->redirectToRoute(""
            //TODO
            );
        }
        return $this->render("", [
            "form" => $form->createView()
            //TODO
        ]);
    }

    /**
     * @Route("/apiCat/v1/submitLocGPS", name="submit_loc_gps", methods={"GET"})
     * @param $request
     * @param $latitudeSoumise
     * @param $longitudeSoumise
     * @param $accuracySoumise
     * @return array
     */
    public function submitLocGPS(Request $request, $latitudeSoumise, $longitudeSoumise, $accuracySoumise)
    {
        $listeIndices = null;

        // On enregistre les coordonnées dans la la table propositionGPS
        $this->setLocGPS($request, $latitudeSoumise, $longitudeSoumise, $accuracySoumise);

        // On compare ces coordonnées avec les coordonnées solutions de la partie (id partie)
        $found = $this->compareLocGPS($request, $latitudeSoumise, $longitudeSoumise, $accuracySoumise);

        // Si $found est faux : on récupère le nombre de propositions déjà soumises
        // et on paramètre la liste d'indices en fonction.

        if (!$found) {
            $listeIndices = $this->getClues($request);
        }

        // Le tableau $answer contient à la fois le booléen $found et le tableau d'indices. Par défaut, $answer contient (false, null)
        $answer = array($found, $listeIndices);
        return $answer;
    }

    // Fonction permettant de sauvegarder la proposition dans la table Proposition GPS.
    private function setLocGPS(Request $request, $latitudeSoumise, $longitudeSoumise, $accuracySoumise)
    {
        //TODO
    }

    // Fonction permettant de comparer les coordonnées GPS soumises avec les coordonnées GPS solution
    private function compareLocGPS(Request $request, $latitudeSoumise, $longitudeSoumise, $accuracySoumise)
    {
        // On set le booléen à faux par défault
        $found = false;

        // On récupère les coordonnées solutions
        $partiesRepo = $this->getDoctrine()->getRepository(Parties::class);
        $id = $request->query->get('id');
        $partie = $partiesRepo->find($id);

        $latitudeSolution = $partie->getLatitude();
        $longitudeSolution = $partie->getLongitude();
        $accuracySolution = $partie->getAccuracy();

        // On compare les deux accuracies. On travaille avec la plus grande des deux.
        $accuracyUtile = $accuracySoumise;
        if ($accuracySolution > $accuracySoumise) {
            $accuracyUtile = $accuracySolution;
        }

        // On récupère la distance à vol d'oiseau en mètre (orthodromique) entre la position soumise et la position solution
        $d = $this->distanceOrthodromique($latitudeSoumise, $latitudeSolution, $longitudeSoumise, $longitudeSolution);

        // Si la $d est inférieure ou égale à l'accuracy utile, le joueur a bien trouvé le lieu du trésor : on passe le booléen $found à true
        if ($d <= $accuracyUtile) {
            $found = true;
        }

        // On renvoie le booléen $found
        return $found;
    }

    // Fonction permettant le calcul de la distance à vol d'oiseau entre les coordonnées soumises et les coordonnées solution

    /**
     * @param $latitudeSoumise
     * @param $latitudeSolution
     * @param $longitudeSoumise
     * @param $longitudeSolution
     * @param $precision = 3
     * @param $r = 6378.14
     * @return double
     */
    private function distanceOrthodromique($latitudeSoumise, $latitudeSolution, $longitudeSoumise, $longitudeSolution, $precision = 3, $r = 6378.14)
    {
        // La variable $r correspond au rayon de la Terre.
        // $latitudeSoumise, $longitudeSoumise sont les latitudes des points respectifs.
        // $latitudeSolution, $y$longitudeSolution sont les longitudes des points respectifs.
        // $precision permet d'obtenir le nombre de chiffre après la virgule.
        // Elle est définie à 3 par défaut permettant d'obtenir une précision au mètre. Il suffit de la multiplier par 1000.

        // On convertit les latitudes et longitudes en radian.
        $latitudeSoumise = deg2rad($latitudeSoumise);
        $longitudeSoumise = deg2rad($longitudeSoumise);
        $latitudeSolution = deg2rad($latitudeSolution);
        $longitudeSolution = deg2rad($longitudeSolution);

        // On calcule des distances entre les deux points.
        $dlat = $longitudeSoumise - $latitudeSoumise;
        $dlong = $longitudeSolution - $latitudeSolution;

        // On applique la formule.
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($latitudeSoumise) * cos($longitudeSoumise) * sin($dlong / 2) * sin($dlong / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // On récupère la valeur du résutat arrondi avec la précision.
        $d = round($r * $c, $precision) * 1000;

        // On renvoie la distance en metres
        return $d;
    }

    // Fonction permettant de récupérer la liste d'indices

    /**
     * @param Request $request
     * @return array $listeIndices
     */
    private function getClues(Request $request)
    {
        $listeIndices = null;

        // On récupere le nombre de soumission(s) déjà effectuée(s)
        $PersonnneGPSPartiesRepo = $this->getDoctrine()->getRepository(PersonneGpsPartie::class);
        $id = $request->query->get('id');
        $who = $request->query->get('who');
        $nbProposition = $PersonnneGPSPartiesRepo->countProposition($id, $who);

        //  Si ce nombre est supérieur ou égal à 3, on recupère le premier indice, et on le set dans la liste.
        if ($nbProposition >= 3) {

            // On récupère la liste d'indices
            $indicesRepo = $this->getDoctrine()->getRepository(Indices::class);
            $id = $request->query->get('id');
            $indices = $indicesRepo->getClues($id);

            // Si le premier élément de l'array n'est pas null (
            if (empty($indices[0])) {
                $listeIndices[0] = "Pas d'indice disponible pour cette chasse ! Courage !";
            } else {
                $listeIndices[0] = $indices[0]->getIndice;
            }

            // Si ce nombre est supérieur à 6, on recupère aussi le second indice, et on le set dans la liste.
            if ($nbProposition >= 6) {

                // Si le second élément de l'array n'est pas null (
                if (empty($indices[1])) {
                    $listeIndices[1] = "Il n'y a vraiment aucun indice pour cette chasse. Pas la peine d'insister.";
                } else {
                    $listeIndices[1] = $indices[1]->getIndice;
                }
            }
        }
        return $listeIndices;
    }

    /**
     * @Route("/game/{id}", name="game", requirements={"id":"[0-9]{1,12}"})
     */
    public function getGameInfo($id) {
        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $partie = $partieRepo->find($id);

        return $this->json([
            "status" => "ok",
            "message" => "",
            "data" => $partie,
        ]);
    }

    /**
     * @Route("/chasses", name="huntList", methods={"GET"})
     */
    public function getGameList(Request $request)
    {
        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $partie = $partieRepo->findBy(
            array('resolue' => 0)
        );


        return $this->json([
            "status" => "ok",
            "message" => "",
            "data" => $partie,
        ]);
    }
}
