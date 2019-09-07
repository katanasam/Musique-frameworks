<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/09/2019
 * Time: 12:05
 */
/**
 * Classe de gestion des paramètres de configuration
 *
 * Inspirée du SimpleFramework de Baptiste Pesquet
 * (https://github.com/fguillot/simpleFramework)
 *
 * @version 11
 * @author  sam kan
 */
class Configuration
{
    /** Tableau des paramètres de configuration */
    private static $parametres;

    /**
     * Renvoie la valeur d'un paramètre de configuration
     *
     * @param string $nom Nom du paramètre
     * @param string $valeurParDefaut Valeur à renvoyer par défaut
     * @return string Valeur du paramètre
     */
    // Renvoie la valeur d'un paramètre de configuration
    public static function get($nom, $valeurParDefaut = null) {
        if (isset(self::getParametres()[$nom])) {
            $valeur = self::getParametres()[$nom];
        }
        else {
            $valeur = $valeurParDefaut;
        }
        return $valeur;
    }

    /**
     * Renvoie le tableau des paramètres en le chargeant au besoin depuis un fichier de configuration.
     * Les fichiers de configuration recherchés sont Config/dev.ini et Config/prod.ini (dans cet ordre)
     *
     * @return array Tableau des paramètres
     * @throws Exception Si aucun fichier de configuration n'est trouvé
     */
    // Renvoie le tableau des paramètres en le chargeant au besoin
    private static function getParametres() {
        if (self::$parametres == null) {
            $cheminFichier = "Config/prod.ini";
            if (!file_exists($cheminFichier)) {
                $cheminFichier = "Config/dev.ini";
            }
            if (!file_exists($cheminFichier)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            }
            else {
                self::$parametres = parse_ini_file($cheminFichier);
            }
        }
        return self::$parametres;
    }
}