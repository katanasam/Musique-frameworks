
<?php
require_once 'Configuration.php';

/**
* Classe abstraite Modèle.
* Centralise les services d'accès à une base de données.
* Utilise l'API PDO de PHP
*tout les ENTITES ou MODELES doivent en hérité
* @version 11
* @author sam kan
*/
abstract class Modele {

    /**
     * Objet PDO d'accès à la BD
     * Statique donc partagé par toutes les instances des classes dérivées
     */
    private static $bdd;

    /**
    * Exécute une requête SQL
    *
    * @param string $sql Requête SQL
    * @param array $params Paramètres de la requête  se pamramètre est une option
    * @return PDOStatement Résultats de la requête
    */
    protected function executerRequete($sql, $params = null) {
    if ($params == null) {
    $resultat = self::getBdd()->query($sql);   // exécution directe
    }
    else {
    $resultat = self::getBdd()->prepare($sql); // requête préparée
    $resultat->execute($params);
    }
    return $resultat;
    }

    /**
    * Renvoie un objet de connexion à la BDD en initialisant la connexion au besoin
    *
    * @return PDO Objet PDO de connexion à la BDD
    */
    private static function getBdd() {
    if (self::$bdd === null) {

    // Récupération des paramètres de configuration Base de Donnée
        // que se soit pour dev.in ou orid.in, ils on les meme nom de donneé
    $dsn = Configuration::get("dsn");
    $login = Configuration::get("login");
    $mdp = Configuration::get("mdp");
    // Création de la connexion
    self::$bdd = new PDO($dsn, $login, $mdp,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    return self::$bdd;
    }

}