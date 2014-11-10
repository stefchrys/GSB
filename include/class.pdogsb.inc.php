<?php

/**
 * Classe d'accès aux données. 

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * @package default
 * @author Chrysinus@gmail.com
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */
class PdoGsb {

    /**
     * Attributs de connexion
     * 
     * @var type 
     * @var String $serveur Adresse du serveur
     * @var String $bdd Nom de la base de donnée
     * @var String $user Identifiant utilisateur
     * @var String$mdp Mot de passe
     * @var PDO $monPdo objet PDO
     * @var $monPdoGsb objet 
     */
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsbV2';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     * 
     */
    private function __construct() {
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . 
                ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct() {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe

     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();

     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb() {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Retourne les informations d'un visiteur

     * @param $login 
     * @param $mdp
     * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
     */
    public function getInfosVisiteur($login, $mdp) {
        $req = "select visiteur.id as id, 
                    visiteur.nom as nom, 
                    visiteur.prenom as prenom 
                    from visiteur 
                    where visiteur.login='$login' and visiteur.mdp='$mdp'";
        $idJeuVisiteurs = PdoGsb::$monPdo->query($req);
        $lgJeuVisiteur = $idJeuVisiteurs->fetch();
        return $lgJeuVisiteur;
    }
    
   
    /**
     * Retourne un tableau rempli des visiteurs(id,nom,prenom)
     * 
     * @return Array
     */
    public function getListeVisiteurs(){
        $req="select visiteur.id as id,
            visiteur.nom as nom,
            visiteur.prenom as prenom
            from visiteur
            where visiteur.id 
             not in
            (select * from comptable)";
        $idJeuVisiteurs = PdoGsb::$monPdo->query($req);
        $lgJeuVisiteur = $idJeuVisiteurs->fetchAll();
        return $lgJeuVisiteur;
    }
    
    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais 
     * hors forfait concernées par les deux arguments

     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return tous les champs des lignes de frais hors forfait sous la forme 
     * d'un tableau associatif 
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois) {
        $req = "select * from lignefraishorsforfait "
                . "where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
                and lignefraishorsforfait.mois = '$mois' ";
        $idJeuFraisHorsForf = PdoGsb::$monPdo->query($req);
        $lgFraisHorsForf = $idJeuFraisHorsForf->fetchAll();
        $nbLignes = count($lgFraisHorsForf);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lgFraisHorsForf[$i]['date'];
            $lgFraisHorsForf[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lgFraisHorsForf;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return le nombre entier de justificatifs 
     */
    public function getNbjustificatifs($idVisiteur, $mois) {
        $req = "select fichefrais.nbjustificatifs as nb from  fichefrais "
                . "where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        $idJeuJustif = PdoGsb::$monPdo->query($req);
        $lgJustif = $idJeuJustif->fetch();
        return $lgJustif['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de 
     * frais au forfait concernées par les deux arguments

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
     */
    public function getLesFraisForfait($idVisiteur, $mois) {
        $req = "select fraisforfait.id as idfrais, 
                fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite 
                from lignefraisforfait 
                inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' "
                . "and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";
        $idJeuFrais = PdoGsb::$monPdo->query($req);
        $lgFrais = $idJeuFrais->fetchAll();
        return $lgFrais;
    }

    /**
     * Retourne tous les id de la table FraisForfait

     * @return un tableau associatif 
     */
    public function getLesIdFrais() {
        $req = "select fraisforfait.id as idfrais "
                . "from fraisforfait order by fraisforfait.id";
        $idJeuId = PdoGsb::$monPdo->query($req);
        $lgId = $idJeuId->fetchAll();
        return $lgId;
    }
     /**
     * Verification type de personnel connecté
     
     * Verifie si la personne connectée est un visiteur ou un comptable
     * @param $id String id du de la personne conectée
     * @return un tableau associatif
     */
    function verifierComptable($id) {
        $req="select comptable.id "
                ."from comptable where comptable.id='$id'";
        $idJeu = PdoGsb::$monPdo->query($req);
        $lg = $idJeu->fetchAll();
        return $lg;
    }
    /**
     * Met à jour la table ligneFraisForfait

     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité 
     * pour ce frais
     * @return un tableau associatif 
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais) {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $req = "update lignefraisforfait "
                    . "set lignefraisforfait.quantite = $qte
                    where lignefraisforfait.idvisiteur = '$idVisiteur' "
                    . "and lignefraisforfait.mois = '$mois'
                    and lignefraisforfait.idfraisforfait = '$unIdFrais'";
            PdoGsb::$monPdo->exec($req);
        }
    }

    /**
     * met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @param $nbJustificatifs Nombre de justificatifs
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs) {
        $req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
                where fichefrais.idvisiteur = '$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Teste si le frais est le prmeir du mois

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return vrai ou faux 
     */
    public function estPremierFraisMois($idVisiteur, $mois) {
        $ok = false;
        $req = "select count(*) as nblignesfrais 
                from fichefrais 
                where fichefrais.mois = '$mois' "
                . "and fichefrais.idvisiteur = '$idVisiteur'";
        $idJeuFiche = PdoGsb::$monPdo->query($req);
        $lgFiche = $idJeuFiche->fetch();
        if ($lgFiche['nblignesfrais'] == 0) {
            $ok = true;
        }
        return $ok;
    }

    /**
     * Retourne le dernier mois en cours d'un visiteur

     * @param $idVisiteur 
     * @return le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur) {
        $req = "select max(mois) as dernierMois "
                . "from fichefrais "
                . "where fichefrais.idvisiteur = '$idVisiteur'";
        $idJeuMois = PdoGsb::$monPdo->query($req);
        $lgMois = $idJeuMois->fetch();
        $dernierMois = $lgMois['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour
     *  un visiteur et un mois donnés

     * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, 
     * crée une nouvelle fiche de frais avec un idEtat à 'CR' et crée les lignes de 
     * frais forfait de quantités nulles
     *  
     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois) {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $req = "insert into fichefrais
                (idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
        PdoGsb::$monPdo->exec($req);
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $uneLigneIdFrais) {
            $unIdFrais = $uneLigneIdFrais['idfrais'];
            $req = "insert into lignefraisforfait
                    (idvisiteur,mois,idFraisForfait,quantite) 
                    values('$idVisiteur','$mois','$unIdFrais',0)";
            PdoGsb::$monPdo->exec($req);
        }
    }

    /**
     * Crée un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @param $libelle : le libelle du frais
     * @param $date : la date du frais au format français jj//mm/aaaa
     * @param $montant : le montant
     */
    public function creeNouveauFraisHorsForfait
    ($idVisiteur, $mois, $libelle, $date, $montant) {
        $dateFr = dateFrancaisVersAnglais($date);
        $req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument

     * @param $idFrais 
     */
    public function supprimerFraisHorsForfait($idFrais) {
        $req = "delete from lignefraishorsforfait "
                . "where lignefraishorsforfait.id =$idFrais ";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais

     * @param $idVisiteur 
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année 
     * et le mois correspondant 
     */
    public function getLesMoisDisponibles($idVisiteur) {
        $req = "select fichefrais.mois as mois "
                . "from  fichefrais "
                . "where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
        $idJeuMoisFiche = PdoGsb::$monPdo->query($req);
        $lesMois = array();
        $lgMoisFiche = $idJeuMoisFiche->fetch();
        while ($lgMoisFiche != null) {
            $mois = $lgMoisFiche['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois["$mois"] = array(
                "mois" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $lgMoisFiche = $idJeuMoisFiche->fetch();
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur 
     * pour un mois donné

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return un tableau avec des champs de jointure entre une fiche de frais 
     * et la ligne d'état 
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois) {
        $req = "select ficheFrais.idEtat as idEtat, 
                ficheFrais.dateModif as dateModif, 
                ficheFrais.nbJustificatifs as nbJustificatifs, 
		ficheFrais.montantValide as montantValide, 
                etat.libelle as libEtat 
                from  fichefrais inner join Etat 
                on ficheFrais.idEtat = Etat.id 
		where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        $idJeuFraisEtat = PdoGsb::$monPdo->query($req);
        $lgFraisEtat = $idJeuFraisEtat->fetch();
        return $lgFraisEtat;
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais

     * Modifie le champ idEtat et met la date de modif à aujourd'hui
     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @param $etat Etat en cours
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat) {
        $req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }   
    /**
     * modifie le champs nb justificatif et montant valide d'une fiche de frais
     * @param type $idVisiteur
     * @param type $mois
     * @param type $montant
     * @param type $nbJustificatifs
     */
    public function majMontantFicheFrais($idVisiteur, $mois, $montant,$nbJustificatifs){
        $req="update fichefrais set montantValide ='$montant',"
                . "nbJustificatifs='$nbJustificatifs' "
                . "where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }
    
    /**
     * renvoie un tableau composé des 12 derniers mois 
     * 
     * Le tableau est un tableau multi dimmensionnel
     * composé de la clé mois et de la clé année et de la date au format aaaamm
     * @return Array
     */
    public function getDouzeMois() {
        //choisir les 12 derniers mois de la fiche de frais
        $req = "select distinct(mois) as date "
                . "from fichefrais "
                . "where mois >= (select max(mois)-100 from fichefrais)"
                . "order by mois desc";
        $idJeuMois = PdoGsb::$monPdo->query($req);
        $lgMois = $idJeuMois->fetch();
        $tableauDate = array();
        //on rempli le tableau assciatif
        while ($lgMois != null) {
            $mois = $lgMois['date'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $tableauDate["$mois"] = array(
                "date" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $lgMois = $idJeuMois->fetch();
        }
        return $tableauDate;
    }

    /**
     * Teste si une fiche de frais cloturee existe concernant 
     * le visiteur l'etat et le mois passé en paramètre renvoie un tab
     * @param string $id 
     * @param string $date
     * @param string $etat
     * @return Array or NULL
     */
    public function ficheExiste($id,$date,$etat){
        $req = "select * from ficheFrais "
                . "where ficheFrais.idVisiteur = '$id'"
                . "and ficheFrais.mois = '$date'"
                . "and idEtat='$etat'";
        $idjeuFiche = PdoGsb::$monPdo->query($req);
        $lgFiche = $idjeuFiche->fetch();
        return $lgFiche;
    } 
    
    /**
     * Modifie le libelle d'un frais hors forfait refusé
     * 
     * @param int $id id de la fiche fraishorsforfait
     */
    public function refuserLigneFraisHorsForfait($id){
        $req="update ligneFraisHorsForfait "
                . "set libelle = concat('REFUS',libelle) "
                . "where id='$id'";              
         PdoGsb::$monPdo->exec($req);
    }
  
    public function valeurMontant($id){
        $req="select montant from fraisForfait where id='$id'";
        $idJeuMontant=PdoGsb::$monPdo->query($req);
        $lgMontant=$idJeuMontant->fetch();
        return (float)$lgMontant[0];
    }
}
?>