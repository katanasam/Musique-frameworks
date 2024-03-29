<?php

require_once 'Framework/Modele.php';
/**
 * entité commentaire
 *
 * @author sam kan
 */
class Commentaire extends Modele {

// Renvoie la liste des commentaires associés à un billet
/*
 * @param$idbillet int
 * @return all commentaire link to $idBillet
 */
    public function getCommentaires($idBillet) {
        $sql = 'select COM_ID as id, COM_DATE as date,'
            . ' COM_AUTEUR as auteur, COM_CONTENU as contenu from T_COMMENTAIRE'
            . ' where BIL_ID=?';
        $commentaires = $this->executerRequete($sql, array($idBillet));
        return $commentaires;
    }

    // Ajoute un commentaire dans la base
    /* permet d'ajouter un commentaire prend 3 paramètre
     * @param $auteur string
     * @param $contenu string
     * @param $idbillet int
     *
     */
    public function ajouterCommentaire($auteur, $contenu, $idBillet) {
        $sql = 'insert into T_COMMENTAIRE(COM_DATE, COM_AUTEUR, COM_CONTENU, BIL_ID)'
            . ' values(?, ?, ?, ?)';

        // class php <DateTime> nous renvoie l'heure actuelle
        $time = new DateTime();
        //$date = date(DATE_W3C);  // Récupère la date courante
        $date=$time->format('Y-m-d H:i:s');
        $this->executerRequete($sql, array($date, $auteur, $contenu, $idBillet));
    }
}