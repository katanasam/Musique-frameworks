<?php
/**
 * Classe modélisant une vue
 *
 * @version 11
 * @author SAM kAN
 */
class Vue {

    // Nom du fichier associé à la vue
    private $fichier;
    
    // Titre de la vue (défini dans le fichier vue)
    private $titre;

    /**
     * Constructeur
     *
     * @param string $action Action à laquelle la vue est associée
     * @param string $controleur Nom du contrôleur auquel la vue est associée
     */
    public function __construct($action, $controleur = "") {
        // Détermination du nom du fichier vue à partir de l'action et du constructeur
        // premiere declaration de la variable $fichier
        $fichier = "Vue/";

        // si la variable controleur n'est pas vide alors fait ca
        if ($controleur != "") {

            // reecriture de la variable fichier
            $fichier = $fichier . $controleur . "/";
        }
        // reecriture de la variable fichier et affectation définitive
        $this->fichier = $fichier . $action . ".php";
        // on obtien a la fin < Vue/($controlleur = Billet)/($action = Index).php >
        // identique a la fin < Vue/Billet/Index.php >
    }

    // ATTENTION $DONNEE ELLE PEUT PORTER A CONFUSION
    // C4EST JUSTE UN PARAMETRE RIEN D'AUTRE

    /**
     * Génère et affiche la vue
     *
     * @param array $donnees Données nécessaires à la génération de la vue
     */
    // Génère et affiche la vue
    public function generer($donnees_para) {

        // Génération de la partie spécifique de la vue
        // creation du contenue grace a générer fichier, les donneés passer en parmètre
        $contenu = $this->genererFichier($this->fichier, $donnees_para);
        // on récuper juste le flux stoké en attente detre libérer
        // on ne récupere pas de visuel de la vue mais un flux...

        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web
        // Nécessaire pour les URI de type controleur/action/id

        // utliser pur netoyer les url  il vient tout a la fin du frramewoks  ne pas s'en occuper avant la fin
        // sous perte de confusion
        $racineWeb = Configuration::get("MonBlog", "/");

        // Génération du gabarit commun utilisant la partie spécifique
        $vue = $this->genererFichier('Vue/gabarit.php',
                array('titre' => $this->titre, 'contenu' => $contenu,'racineWeb'=> $racineWeb));

        // Renvoi de la vue au navigateur
        //  cette fois ci on affiche la vue et le flux sera libéré
        echo $vue;
    }


    /**
     * Génère un fichier vue et renvoie le résultat produit
     *
     * @param string $fichier Chemin du fichier vue à générer
     * @param array $donnees Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    // Génère un fichier vue et renvoie le résultat produit
    //// il prend en paramètre un fichier ex <Vue/Billet/Index>
    private function genererFichier($fichier, $donnees) {
        if (file_exists($fichier)) {
            // Rend les éléments du tableau $donnees accessibles dans la vue
            // fonction extrack transphorme un tableau associatife en variable
            extract($donnees);
            // Démarrage de la temporisation de sortie
            ob_start();
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            require_once $fichier;
            // Arrêt de la temporisation et renvoi du tampon de sortie
            return ob_get_clean();
        }
        else {
            throw new Exception("Fichier '$fichier' introuvable");
        }
    }

}