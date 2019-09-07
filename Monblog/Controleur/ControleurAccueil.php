<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Billet.php';
require_once 'Framework/Vue.php';

/**
 * Contrôleur par default
 *
 * @author Baptiste Pesquet
 */
class ControleurAccueil extends Controleur {

    /**
     * instance de billet
     */
    private $billet;

    /**
     * Constructeur
     */
    public function __construct() {
        $this->billet = new Billet();
    }

    // Affiche la liste de tous les billets du blog
    public function index() {
        $billets = $this->billet->getBillets();
       // var_dump($billets);
        $this->genererVue(array('billets' => $billets));
    }
}

