<?php

namespace App\Controller;

use App\Entity\Indices;
use App\Entity\Parties;
use App\Entity\PersonneGpsPartie;
use App\Entity\PersonnePartieResolue;
use App\Entity\PropositionGPS;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiCatController extends Controller
{
    // Fonction qui récupère TOUTES les infos de la partie
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getGame(Request $request)
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

    // Fonction qui récupère les infos DE BASE de la partie

    /**
     * @Route("/game/{id}", name="game", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getGameInfo(Request $request)
    {
        $partiesRepo = $this->getDoctrine()->getRepository(Parties::class);
        $id = $request->query->get('id');
        $partie = $partiesRepo->findBasic($id);

        return $this->json([
            "status" => "ok",
            "message" => "Petit(e) curieux(se)",
            "data" => $partie,
        ]);
    }

    /**
     * @Route("/gameList", name="gameList", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getGameList(Request $request)
    {
        $id = $request->query->get('id');
        $personne = $request->query->get('personne');

        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $partie = $partieRepo->findGameList();

        return $this->json([
            "status" => "ok",
            "message" => "Petit(e) curieux(se)",
            "data" => $partie,
        ]);
    }

    // Fonction qui sauvegarde les paramètres d'une nouvelle partie

    /**
     * @Route("/setGame", name="setGame", methods={"POST"})
     * @param Request $request
     */
    public function setPartie(Request $request)
    {
        // On récupère les paramètres de la request. Certains vont être strockés dans Partie, d'autres dans Indices,
        // d'autres enfin dans la table de liaison

        $id = $request->query->get('id');

        $accuracy = $request->query->get('acc');
        //$dateFin = $request->query->get('fin');
        $latitude = $request->query->get('lat');
        $longitude = $request->query->get('lon');
        $messageFin = $request->query->get('messageFin');
        $nom = $request->query->get('nom');
        $photo = $request->query->get('img');
        $privee = $request->query->get('pri');

        if (null != $request->query->get('ind1')) {
            $indice1 = $request->query->get('ind1');
        } else {
            $indice1 = "Pas d\'indice disponible pour cette chasse ! Courage !";
        }

        if (null != $request->query->get('ind2')) {
            $indice2 = $request->query->get('ind2');
        } else {
            $indice2 = "Il n'y a vraiment aucun indice pour cette chasse. Pas la peine d'insister.";
        }

        $personne = $request->query->get('personne');

        // On crée un nouvelle instance de Partie
        $partie = new Parties();
        $partie->setAccuracy($accuracy);
        $partie->setDateDebut(new \DateTime());
        //$partie->setDateFin($dateFin);
        $partie->setLatitude($latitude);
        $partie->setLongitude($longitude);
        $partie->setMessageFin($messageFin);
        $partie->setNom($nom);
        $partie->setPhoto($photo);
        $privee->setPhoto($privee);

        // On crée un nouvelle instance de PersonnePartieResolue
        $personnePartieResolue = new PersonnePartieResolue();
        $personnePartieResolue->setRole("Createur");
        $personnePartieResolue->setResolue(false);
        $personnePartieResolue->addPartieId($id);
        $personnePartieResolue->addPersonneId($personne);

        // On sauve la nouvelle partie et la table de liaison
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($partie);
        $entityManager->persist($personnePartieResolue);
        $entityManager->flush();

        // On crée un nouvelle instance d'indice et on la sauve.
        $indice = new Indices;
        // V2 :Temporaire : on set le type d'indice à 1.
        $indice->setTypeIndice(1);
        $indice->setPartie($id);

        // V2 : Faire une scrogneugneu de boucle sur une liste d'indice

        $indice->setIndice($indice1);
        $entityManager->persist($indice);
        $entityManager->flush();

        $indice->setIndice($indice2);
        $entityManager->persist($indice);
        $entityManager->flush();
    }

    /**
     * @Route("/submitLoc", name="submitLoc", methods={"POST"})
     * @param $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function submitLoc(Request $request)
    {
        $id = $request->query->get('id');
        $personne = $request->query->get('personne');
        $latitudeSoumise = $request->query->get('lat');
        $longitudeSoumise = $request->query->get('lon');
        $accuracySoumise = $request->query->get('acc');

        // On enregistre les coordonnées dans la la table propositionGPS
        $this->setLoc($id, $personne, $latitudeSoumise, $longitudeSoumise);

        // On compare ces coordonnées avec les coordonnées solutions de la partie (id partie)
        $found = $this->compareLoc($id, $latitudeSoumise, $longitudeSoumise, $accuracySoumise);

        $nbProposition = null;
        $indice1 = null;
        $indice2 = null;
        $messageFin = null;

        if ($found) {
            $messageFin = $this->getSuccessMessage($id);
            $this->setResolved($id, $personne);
        } else {
            $listeIndices = $this->getClues($id, $personne);
            $nbProposition = $listeIndices[0];
            $indice1 = $listeIndices[1];
            $indice2 = $listeIndices[2];
        }

        $answer = array($found, $nbProposition, $indice1, $indice2, $messageFin);

        return $this->json([
            "status" => "ok",
            "message" => "",
            "data" => $answer,
        ]);

    }

    // Fonction permettant de sauvegarder la proposition dans la table Proposition GPS.

    /**
     * @param $id
     * @param $personne
     * @param $latitudeSoumise
     * @param $longitudeSoumise
     */
    private function setLoc($id, $personne, $latitudeSoumise, $longitudeSoumise)
    {
        // On instancie une nouvelle Proposition GPS
        $propositionGPS = new PropositionGPS();
        $propositionGPS->setLatitude($latitudeSoumise);
        $propositionGPS->setLongitude($longitudeSoumise);
        // On récupère l'id de l'entity
        $GPS = $propositionGPS->getId();

        // On instancie une nouvelle PersonneGPSPartie
        $personneGPSPartie = new PersonneGpsPartie();
        $personneGPSPartie->setPartie($id);
        $personneGPSPartie->setPersonne($personne);
        $personneGPSPartie->setGps($GPS);

        // On sauve la nouvelle partie et la table de liaison
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($propositionGPS);
        $entityManager->persist($personneGPSPartie);
        $entityManager->flush();
    }

    // Fonction permettant de comparer les coordonnées GPS soumises avec les coordonnées GPS solution

    /**
     * @param $id
     * @param $latitudeSoumise
     * @param $longitudeSoumise
     * @param $accuracySoumise
     * @return bool
     */
    private function compareLoc($id, $latitudeSoumise, $longitudeSoumise, $accuracySoumise)
    {
        // On set le booléen à faux par défault
        $found = false;

        // On récupère les coordonnées solutions
        $partiesRepo = $this->getDoctrine()->getRepository(Parties::class);
        $partie = $partiesRepo->find($id);

        $latitudeSolution = $partie->getLatitude();
        $longitudeSolution = $partie->getLongitude();
        $accuracySolution = $partie->getAccuracy();

        // On compare les deux accuracies. On travaille avec la plus grande des deux.
        $accuracyUtile = $accuracySoumise;
        if ($accuracySolution > $accuracySoumise) {
            $accuracyUtile = $accuracySolution;
        }

        // On récupère la distance à vol d'oiseau en mètre(orthodromique) entre la position soumise et la position solution
        $d = $this->distanceOrthodromique($latitudeSoumise, $latitudeSolution, $longitudeSoumise, $longitudeSolution);

        // Si la $d est inférieure ou égale à l'accuracy utile, le joueur a bien trouvé le lieu du trésor : on passe le booléen $found à true
        if ($d <= $accuracyUtile) {
            $found = true;
        }

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

    // Fonction permettant de récuperer le message de fin de jeu; lorsque la position du trésor a été trouvée

    /**
     * @param Request $request
     * @return string
     */
    private function getSuccessMessage($id)
    {
        $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
        $messageFin = $partieRepo->findSuccessMessage($id);

        return $messageFin;
    }

    // Fonction permettant de récupérer la liste d'indices.
    // Le tabeau $listeIndices contient : le nombre de propositions soumises, le premier indice, le second indice.

    /**
     * @param $id
     * @param $personne
     */
    private function setResolved($id, $personne)
    {
        $criteria=[$id, $personne];
        $personnePartieResolueRepo = $this->getDoctrine()->getRepository(PersonneGpsPartie::class);
        $personnePartieResolue = $personnePartieResolueRepo->findOneBy($criteria);

        $personnePartieResolue->setResolue(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($personnePartieResolue);
        $entityManager->flush();
    }

    // Fonction permettant de passer l'attribut du booléen resolu à true dans la table de liaison PartiePersonne.

    /**
     * @param $id
     * @param $personne
     * @return array
     */

    private function getClues($id, $personne)
    {
        $listeIndices = null;

        // On récupere le nombre de soumission(s) déjà effectuée(s)
        $PersonnneGPSPartiesRepo = $this->getDoctrine()->getRepository(PersonneGpsPartie::class);
        $nbProposition = $PersonnneGPSPartiesRepo->countProposition($id, $personne);

        $listeIndices[0] = $nbProposition;

        //  Si ce nombre est supérieur ou égal à 3, on recupère le premier indice, et on le set dans la liste.
        if ($nbProposition >= 3) {

            // On récupère la liste d'indices
            $indicesRepo = $this->getDoctrine()->getRepository(Indices::class);
            $indices = $indicesRepo->getClues($id);
            $listeIndices[1] = $indices[0]->getIndice;
            // Si ce nombre est supérieur à 6, on recupère aussi le second indice, et on le set dans la liste.
            if ($nbProposition >= 6) {
                $listeIndices[2] = $indices[1]->getIndice;
            }
        }
        return $listeIndices;
    }

}
