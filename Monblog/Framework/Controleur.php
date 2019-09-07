<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/09/2019
 * Time: 15:50
 */

require_once 'Requete.php';
require_once 'Vue.php';

/**
 * Classe abstraite Controleur
 * Fournit des services communs aux classes Controleur dérivées
 *tous les controller  doivent en hérité
 * @version 11
 * @author Sam kan
 */
abstract class Controleur {

    /**
     * Action à réaliser
     */
    private $action;

    /**
     * Requête entrante
     */
    protected $requete;

    /**
     * Définit la requête entrante
     *
     * @param Requete $requete Requete entrante
     */
    public function setRequete(Requete $requete)
    {
        // on stock la requette passe en para dans une propriete
        $this->requete = $requete;
    }

    /**
     * Exécute l'action à réaliser.
     * Appelle la méthode portant le même nom que l'action sur l'objet Controleur courant
     *
     * @throws Exception Si l'action n'existe pas dans la classe Controleur courante
     */
    // Exécute l'action à réaliser
    public function executerAction($action) {
        // si la laction demander existe dans la classe actuelle <THIS>
        if (method_exists($this, $action)) {
            //affectation de action
            $this->action = $action;

            // conplexe lol
            //cette methode et implémenter par tous les heritiers
            $this->{$this->action}();

            // equivalent a <ControleurBillet->index()>
            // equivalent a <ControleurXXXX->index()>
        }
        else {
            $classeControleur = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classeControleur");
        }
    }

    /**
     * Méthode abstraite correspondant à l'action par défaut
     * Oblige les classes dérivées à implémenter cette action par défaut
     */
//     Méthode abstraite correspondant à l'action par défaut
//     Oblige les classes dérivées à implémenter cette action par défaut
    public abstract function index();


    /**
     * Génère la vue associée au contrôleur courant
     *
     * @param array $donneesVue Données nécessaires pour la génération de la vue
     */
    // Génère la vue associée au contrôleur courant
    protected function genererVue($donneesVue = array()) {

        // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
        //get_class — Retourne le nom de la classe d'un objet en l'ocurence
        // ce sera le controlleur utilisant cette métohde, sachant que tout les ControleurXxxx.. hérite de Controleur abstract
        // ex <ControleurBillet> est stocker car il va générer sa vue
        $classeControleur = get_class($this);
        // ex <ControleurBillet> est stocker

        $controleur = str_replace("Controleur", "", $classeControleur);
        // <Billet> est stocker

        // Instanciation et génération de la vue
        // la vue prend une action en paramètre et un controleur qui correspond au dossier dans le quelle la vue doit etre contenue
        // action recuperer         nom de controlleur sans controleur <Billet> et envoie a la vue
        $vue = new Vue($this->action, $controleur);

        // elle a besoin d'un tableau de donnée
        $vue->generer($donneesVue);
    }
}
