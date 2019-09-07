<?php

require_once 'Framework/Modele.php';

/**
 * entité billet
 *
 * @author sam kan
 */
class Billet extends Modele {

    /**
     * Renvoie la liste des billets du blog
     * @take all billet in data base
     * @return PDOStatement La liste des billets
     */
    public function getBillets() {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
            . ' BIL_TITRE as titre, BIL_CONTENU as contenu from T_BILLET'
            . ' order by BIL_ID desc';
        // la methodes executé requette vient de l'héritage de Modèle
        $billets = $this->executerRequete($sql);
        return $billets;
    }

    /**
     * Renvoie les informations sur un billet
     * @param int $id L'identifiant du billet
     * @return array Le billet
     * @throws Exception Si l'identifiant du billet est inconnu
     */
    public function getBillet($idBillet) {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
            . ' BIL_TITRE as titre, BIL_CONTENU as contenu from T_BILLET'
            . ' where BIL_ID=?';
        // la methodes executé requette vient de l'héritage de Modèle
        $billet = $this->executerRequete($sql, array($idBillet));
        if ($billet->rowCount() > 0)

            // Accès à la première ligne de résultat
            // on récuperat l'ensemble du tableau avec une boucle
            return $billet->fetch();
        else
            //on recupere un erreur PDO  statement
            throw new Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
    }

}