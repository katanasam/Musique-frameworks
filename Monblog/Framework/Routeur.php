<?php

require_once 'Requete.php';
require_once 'Vue.php';

/*
 * Classe de routage des requêtes entrantes.
 *
 * Inspirée du framework PHP de Nathan Davison
 * (https://github.com/ndavison/Nathan-MVC)
 *
 * @version 1.0
 * @author Baptiste Pesquet
 */
class Routeur {

    /**
     * Méthode principale appelée par le contrôleur frontal
     * Examine la requête et exécute l'action appropriée
     */
    // Route une requête entrante : exécute l'action associée
    public function routerRequete() {
        try {
            // Fusion des paramètres GET et POST de la requête
            // je commente mon code
            $requete = new Requete(array_merge($_GET, $_POST));

            // return un objet de type controller
            $controleur = $this->creerControleur($requete);
            $action = $this->creerAction($requete);

            $controleur->executerAction($action);
        }
        catch (Exception $e) {
            $this->gererErreur($e);
        }
    }

    // Créer le contrôleur approprié en fonction de la requête reçue
    private function creerControleur(Requete $requete) {
        $controleur = "Accueil";  // Contrôleur par défaut

        //si tu recup ue valeur dans dans les paramètre $_GET ou $_POST
        // le controller
        if ($requete->existeParametre('controleur'))
        {
            //SI OUI TU récupère une valeur alors
            // alors on appel get paramètre pour récupérer la veleur associer au paramètr
            $controleur = $requete->getParametre('controleur');

            // Première lettre en majuscule
            // on travai la string récupérer pour qu'elle correspond
            // a notre nom de controleur <camelcase>
            $controleur = ucfirst(strtolower($controleur));
        }
        // Création du nom du fichier du contrôleur
        // les controleurs et les class on le meme nom
        // a la fin de cette opération nous auron le nom du controleur
        $classeControleur = "Controleur" . $controleur;
        //< ControleurBillet >

        //ici on cherhce a récupérer le fichier ou il se trouve < sont chemin>
        $fichierControleur = "Controleur/" . $classeControleur . ".php";
        //< Controleur/ControleurBillet.php >

        // On vérifie si le fichier existe
        if (file_exists($fichierControleur))
        {
            //si le fichier existe alors
            // on va chercher le fichier  avec un require
            // require "Controleur/ControleurBillet.php"
            require_once ($fichierControleur);

            // Instanciation du contrôleur adapté à la requête
            $obj_controleur = new $classeControleur(); // on récupère le nom de la class
         // $controleur = new ControleurBillet();
            // on creer une instance de la class en question

            // mon controleur et un objet
            $obj_controleur->setRequete($requete);

            return $obj_controleur;
        }
        else
            throw new Exception("Fichier '$fichierControleur' introuvable");
    }

    // Détermine l'action à exécuter en fonction de la requête reçue
    private function creerAction(Requete $requete)
    {
        $action = "index";  // Action par défaut
        if ($requete->existeParametre('action')) {
            $action = $requete->getParametre('action');
        }
        return $action;
    }
    // Gère une erreur d'exécution (exception)
    private function gererErreur(Exception $exception) {
        $vue = new Vue('erreur');
        $vue->generer(array('msgErreur' => $exception->getMessage()));
    }
}
