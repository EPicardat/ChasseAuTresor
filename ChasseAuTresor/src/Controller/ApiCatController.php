<?php

namespace App\Controller;

use App\Entity\Indices;
use App\Entity\Parties;
use App\Entity\PersonneGpsPartie;
use App\Entity\PersonnePartieResolue;
use App\Entity\Personnes;
use App\Entity\PropositionGPS;
use App\Entity\TypeIndice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiCatController extends Controller
{

    /**
     * @Route("/user", name="user", methods={"GET"})
     */
    public function getLoggedUser()
    {
        if ($this->getUser() != null) {
            return $this->json([
                'user' => $this->getUser()->getId()
            ]);
        } else {
            return $this->json([
                'user' => 'anonymousUser'
            ]);
        }
    }

    // Fonction qui récupère la liste des parties disponibles

    /**
     * @Route("/gameList", name="gameList", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getGameList()
    {
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function setPartie(Request $request)
    {
        // On récupère les paramètres de la request. Certains vont être stockés dans Partie, d'autres dans Indices,
        // d'autres enfin dans la table de liaison

        $accuracy = $request->query->get('acc');
        $latitude = $request->query->get('lat');
        $longitude = $request->query->get('lon');
        $messageFin = $request->query->get('messageFin');
        $nom = $request->query->get('nom');
        $photo = $request->query->get('img');
        $privee = false;
        $indice1 = "Pas d'indice disponible pour cette chasse ! Courage !";
        $indice2 = "Il n'y a vraiment aucun indice pour cette chasse. Pas la peine d'insister.";

        if (null != $request->query->get('indice1')) {
            $indice1 = $request->query->get('indice1');
        }

        if (null != $request->query->get('indice2')) {
            $indice2 = $request->query->get('indice2');
        }

        $personne = $request->query->get('personne');

        // On crée un nouvelle instance de Partie
        $partie = new Parties();
        $partie->setAccuracy((int)$accuracy);
        $partie->setDateDebut(new \DateTime());
        $partie->setLatitude($latitude);
        $partie->setLongitude($longitude);
        $partie->setMessageFin($messageFin);
        $partie->setNom($nom);
        $partie->setPhoto($photo);
        $partie->setPrivee($privee);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($partie);
        $entityManager->flush();

        // On crée un nouvelle instance de PersonnePartieResolue
        $personnePartieResolue = new PersonnePartieResolue();
        $personnePartieResolue->setRole("Createur");
        $personnePartieResolue->setResolue(false);
        $personnePartieResolue->setPartie($partie);
        $personnePartieResolue->setPersonne($personne);

        // On sauve la nouvelle partie et la table de liaison
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($partie);
        $entityManager->persist($personnePartieResolue);
        $entityManager->flush();

        // On crée un nouvelle instance d'indice et on la sauve.
        //Pour cela, on récupére le type d'indice dont l'id est égale à 1 (bouchonnage)
        $typeIndRepo = $this->getDoctrine()->getRepository(TypeIndice::class);
        $typeInd = $typeIndRepo->findOneBy(['id' => 1]);

        $indice1BO = new Indices;
        $indice1BO->setTypeIndice($typeInd);
        $indice1BO->setPartie($partie);
        $indice1BO->setIndice($indice1);
        $entityManager->persist($indice1BO);
        $entityManager->flush();

        $indice2BO = new Indices;
        $indice2BO->setTypeIndice($typeInd);
        $indice2BO->setPartie($partie);
        $indice2BO->setIndice($indice2);
        $entityManager->persist($indice2BO);
        $entityManager->flush();

        return new \Symfony\Component\HttpFoundation\Response();
    }

    //Fonction qui permet de recuperer les indices au chargement de la partie

    /**
     * @Route("/getFirstClues", name="getFirstClues", methods={"GET"})
     * @param $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getFirstCluesLoc(Request $request)
    {
        $id = $request->query->get('id');
        $personne = $request->query->get('personne');

        $listeIndices = $this->getClues($id, $personne);

        return $this->json([
            "status" => "ok",
            "message" => "Sale petit Hobbit jouflu !",
            "data" => $listeIndices,
        ]);
    }


    //Fonction qui permet de soumettre une position GPS

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
        $tabNbProposition = $PersonnneGPSPartiesRepo->countProposition($id, $personne);
        $nbProposition = $tabNbProposition[0][1];

        //  Si ce nombre est supérieur ou égal à 3, on recupère le premier indice, et on le set dans la liste.
        if ($nbProposition >= 3) {
            // On récupère la liste d'indices
            $indicesRepo = $this->getDoctrine()->getRepository(Indices::class);
            $indices = $indicesRepo->getClues($id);

            $listeIndices[0] = $indices[0];
            // Si ce nombre est supérieur à 6, on recupère aussi le second indice, et on le set dans la liste.
            if ($nbProposition >= 6) {
                $listeIndices[1] = $indices[1];
            }
        }
        return $listeIndices;
    }

    // Fonction permettant de sauvegarder la proposition dans la table Proposition GPS.

    /**
     * @Route("/submitLoc", name="submitLoc", methods={"GET"})
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

        $reponse = 'Cherche encore';

        // On enregistre les coordonnées dans la la table propositionGPS
        $this->setLoc($id, $personne, $latitudeSoumise, $longitudeSoumise);

        // On crée l'entité PersonnePartieResolue
        $personnePartieResolueRepo = $this->getDoctrine()->getRepository(PersonnePartieResolue::class);
        $personnePartieResolue = $personnePartieResolueRepo->findPPR($id, $personne);

        if(null == $personnePartieResolue){
            $personnePartieResolue = new PersonnePartieResolue();

            $partieRepo = $this->getDoctrine()->getRepository(Parties::class);
            $partie = $partieRepo->find($id);

            $personneRepo = $this->getDoctrine()->getRepository(Personnes::class);
            $qui = $personneRepo->find($personne);

            $personnePartieResolue->setPersonne($qui);
            $personnePartieResolue->setPartie($partie);
            $personnePartieResolue->setRole("Joueur");
            $personnePartieResolue->setResolue(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personnePartieResolue);
            $entityManager->flush();
        }

        // On compare ces coordonnées avec les coordonnées solutions de la partie (id partie)
        $found = $this->compareLoc($id, $latitudeSoumise, $longitudeSoumise, $accuracySoumise);

        if ($found) {
            $reponse = 'Bravo, c\'est trouvé !';
        }

        $listeIndices = null;
        $messageFin = null;

        if ($found) {
            $messageFin = $this->getSuccessMessage($id);
            $this->setResolved($id, $personne);
        } else {
            $listeIndices = $this->getClues($id, $personne);
        }

        $answer = array($reponse, $listeIndices, $messageFin);

        return $this->json([
            "status" => "ok",
            "message" => "C'est vilain de fouiller dans le Json !",
            "data" => $answer,
        ]);
    }

    // Fonction permettant de comparer les coordonnées GPS soumises avec les coordonnées GPS solution

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

        $partiesRepo = $this->getDoctrine()->getRepository(Parties::class);
        $partie = $partiesRepo->find($id);

        $personneRepo = $this->getDoctrine()->getRepository(Personnes::class);
        $personneEnt = $personneRepo->find($personne);

        $personneGPSPartie = new PersonneGpsPartie();

        $personneGPSPartie->setPartie($partie);
        $personneGPSPartie->setPersonne($personneEnt);
        $personneGPSPartie->setGps($propositionGPS);

        // On sauve la nouvelle partie et la table de liaison
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($propositionGPS);
        $entityManager->persist($personneGPSPartie);
        $entityManager->flush();
    }

    // Fonction permettant le calcul de la distance à vol d'oiseau entre les coordonnées soumises et les coordonnées solution

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

    // Fonction permettant de récuperer le message de fin de jeu lorsque la position du trésor a été trouvée

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
        // $latitudeSolution, $longitudeSolution sont les longitudes des points respectifs.
        // $precision permet d'obtenir le nombre de chiffre après la virgule.
        // Elle est définie à 3 par défaut permettant d'obtenir une précision au mètre. Il suffit de la multiplier par 1000.

        // On convertit les latitudes et longitudes en radian.

        $latitudeSoumise = deg2rad($latitudeSoumise);
        $longitudeSoumise = deg2rad($longitudeSoumise);
        $latitudeSolution = deg2rad($latitudeSolution);
        $longitudeSolution = deg2rad($longitudeSolution);

        // On calcule des distances entre les deux points.
        $dlat = $latitudeSoumise - $latitudeSolution;
        $dlong = $longitudeSoumise - $longitudeSolution;


        // On applique la formule.
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($latitudeSoumise) * cos($longitudeSoumise) * sin($dlong / 2) * sin($dlong / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // On récupère la valeur du résutat arrondi avec la précision.
        $d = round($r * $c, $precision) * 1000;

        // On renvoie la distance en metres
        return $d;
    }

    // Fonction permettant de passer l'attribut du booléen resolu à true dans la table de liaison PersonnePartieResolue.

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

// Fonction permettant de récupérer les indices

    /**
     * @param $id
     * @param $personne
     */
    private function setResolved($id, $personne)
    {
        $personnePartieResolueRepo = $this->getDoctrine()->getRepository(PersonnePartieResolue::class);
        $personnePartieResolue = $personnePartieResolueRepo->findPPR($id, $personne);

        $personnePartieResolue->setResolue(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($personnePartieResolue);
        $entityManager->flush();
    }
}
