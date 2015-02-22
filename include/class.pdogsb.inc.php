<?php

/**
 * Classe d'accès aux données.. 

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * @package PDOGSB
 * @author Chrysinus@gmail.com
 * 
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
    private static $bdd = 'dbname=gsb3';
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
     * Execute une requete sql entrée parametre et retourne un tableau associatif, 
     * un element ou ne retourne rien en fonction du deuxieme parametre
     * 
     * @param string $req
     * @param string $fetch
     * @return NULL or array Retourne rien ou un tableau
     */
    public function executerRequete($req,$fetch){
        switch ($fetch){
            case 'fetch()':{
                $idJeu = PdoGsb::$monPdo->query($req);
                $lgJeu = $idJeu->fetch();
                return $lgJeu;
                break;
            }
            case 'fetchAll()':{
                $idJeu = PdoGsb::$monPdo->query($req);
                $lgJeu = $idJeu->fetchAll();
                return $lgJeu;
                break;
            }
            case 'exec':{
                PdoGsb::$monPdo->exec($req);
                break;
            }
            default:{
                echo "probleme execution de requete lié a une variable fetch choisir 'fetch()' ,'fetchAll()', ou 'exec' ";
                break;
            }
        }       
    }
    /**
     * Retourne les informations id, nom, prenom, d'un visiteur

     * @param string $login 
     * @param string $mdp
     * @return array Renvoie l'id, le nom et le prénom sous la forme d'un 
     * tableau associatif 
     */
    public function obtenirInfoVisiteur($login, $mdp) {
        
        $req = "SELECT Visiteur.id AS id, "
                . "Visiteur.nom AS nom, "
                . "Visiteur.prenom AS prenom FROM Visiteur "
        . "WHERE Visiteur.login = '$login' AND Visiteur.mdp = '$mdp'";
        $res = PdoGsb::$monPdo->query($req);
        $val=  $res->fetch();
        return $val;
    }

    /**
     * Retourne un tableau rempli des visiteurs(id,nom,prenom)
     * 
     * @return Array Tableau de visiteurs
     */
    public function obtenirListeVisiteurs() {
        $req = "SELECT Visiteur.id AS id, "
                . "Visiteur.nom AS nom, "
                . "Visiteur.prenom AS prenom "
                . "FROM Visiteur "
                . "WHERE Visiteur.types = 1 ";
        return $this->executerRequete($req, 'fetchAll()');
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais 
     * hors forfait concernées par les deux arguments.

     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return array Tous les champs des lignes de frais hors forfait sous la forme 
     * d'un tableau associatif 
     */
    public function obtenirLesFraisHorsForfait($idVisiteur, $mois) {
        $req = "SELECT * "
                . "FROM LigneFraisHorsForfait "
                . "WHERE LigneFraisHorsForfait.idVisiteur = '$idVisiteur' "
                . "AND LigneFraisHorsForfait.mois = '$mois'";
        $lgFraisHorsForf= $this ->executerRequete($req, 'fetchAll()');
        $nbLignes = count($lgFraisHorsForf);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lgFraisHorsForf[$i]['date'];
            $lgFraisHorsForf[$i]['date'] = DateGsb::dateAnglaisVersFrancais($date);
        }
        return $lgFraisHorsForf;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de 
     * frais au forfait concernées par les deux arguments(validé 20/01/2015)

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return array l'id, le libelle et la quantité sous la forme d'un tableau associatif 
     */
    public function obtenirLesFraisForfait($idVisiteur, $mois) {
        $req = "SELECT FraisForfait.id AS idFrais, "
                . "FraisForfait.libelle AS libelle, "
                . "FraisForfait.montant AS montant, "
                . "LigneFraisForfait.quantite AS quantite "
                . "FROM LigneFraisForfait INNER JOIN FraisForfait "
                . "ON FraisForfait.id = LigneFraisForfait.idFraisForfait "
                . "WHERE LigneFraisForfait.idVisiteur = '$idVisiteur' "
                . "AND LigneFraisForfait.mois = '$mois' "
                . "ORDER BY LigneFraisForfait.idFraisForfait";
        return $this ->executerRequete($req, 'fetchAll()');
    }

    /**
     * Retourne tous les id de la table FraisForfait

     * @return array  tableau associatif 
     */
    public function obtenirLesIdFrais() {
        $req = "SELECT FraisForfait.id AS idFrais "
                . "FROM FraisForfait "
                . "ORDER BY FraisForfait.id";
        return $this ->executerRequete($req, 'fetchAll()');
    }

    /**
     * Verification type de personnel connecté

     * Verifie si la personne connectée est un comptable
     * @param string $id  id du de la personne conectée
     * @return array  Tableau 
     */
    
    function verifierComptable($id) {
        $req = "SELECT TypePersonnel.libelle "
                . "FROM TypePersonnel "
                . "WHERE TypePersonnel.id IN"
                . "(select Visiteur.types from Visiteur where Visiteur.id = '$id')" ;
        $type = $this->executerRequete($req,'fetch()');
        return $type;
        
    }

    /**
     * Met à jour la table ligneFraisForfait

     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @param array $lesFrais tableau associatif de clé idFrais et de valeur la quantité 
     * pour ce frais
     * @return array Tableau associatif 
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais) {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $req = "update LigneFraisForfait 
                    set LigneFraisForfait.quantite = $qte
                    where LigneFraisForfait.idVisiteur = '$idVisiteur' 
                    and LigneFraisForfait.mois = '$mois'
                    and LigneFraisForfait.idFraisForfait = '$unIdFrais'";
            $this->executerRequete($req, 'exec');
        }
    }

  

    /**
     * Teste si le frais est le premier du mois

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return bool 
     */
    public function estPremierFraisMois($idVisiteur, $mois) {
        $ok = false;
        $req = "SELECT count( * ) AS nbLignesFrais "
                . "FROM FicheFrais "
                . "WHERE FicheFrais.mois = '$mois' "
                . "AND FicheFrais.idVisiteur = '$idVisiteur'";
        $lgFrais= $this->executerRequete($req, 'fetch()');
        if ($lgFrais['nbLignesFrais'] == 0) {
            $ok = true;
        }
        return $ok;
    }

    /**
     * Retourne le dernier mois en cours d'un visiteur(validé 10/12/2014)

     * @param string $idVisiteur 
     * @return string le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur) {
        $req = "SELECT max( mois ) AS dernierMois "
                . "FROM FicheFrais "
                . "WHERE FicheFrais.idVisiteur = '$idVisiteur'";
        $lgMois=$this->executerRequete($req, 'fetch()');
        $dernierMois = $lgMois['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour
     *  un visiteur et un mois donnés

     * Récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, 
     * crée une nouvelle fiche de frais avec un idEtat à 'CR' et crée les lignes de 
     * frais forfait de quantités nulles
     *  
     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois) {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->obtenirLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $req = "INSERT INTO FicheFrais "
                . "(idVisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) "
                . "VALUES('$idVisiteur','$mois',0,0,now(),'CR')";
        $this->executerRequete($req,'exec');
        $lesIdFrais = $this->obtenirLesIdFrais();
        foreach ($lesIdFrais as $uneLigneIdFrais) {
            $unIdFrais = $uneLigneIdFrais['idFrais'];
            $req = "INSERT INTO LigneFraisForfait "
                    . "(idVisiteur,mois,idFraisForfait,quantite) "
                    . "VALUES('$idVisiteur','$mois','$unIdFrais',0)";
            $this->executerRequete($req,'exec');
        }
    }

    /**
     * Crée un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre(verifié 10/12/2014)

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @param string $libelle : le libelle du frais
     * @param string $date : la date du frais au format français jj//mm/aaaa
     * @param float $montant : le montant
     */
    public function creeNouveauFraisHorsForfait
    ($idVisiteur, $mois, $libelle, $date, $montant) {
        $dateFr = DateGsb::dateFrancaisVersAnglais($date);
        $req = "INSERT INTO LigneFraisHorsForfait "
                . "VALUES('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
        $this->executerRequete($req,'exec');
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument(validé 10/12/2014)

     * @param string $idFrais 
     */
    public function supprimerFraisHorsForfait($idFrais) {
        $req = "DELETE FROM LigneFraisHorsForfait "
                . "WHERE LigneFraisHorsForfait.id =$idFrais ";
        $this->executerRequete($req,'exec');
    }

     /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais
     
     * @param string $idVisiteur
     * @param $periode string "all" selectionne tout les mois disponibles
     * "year" selectionne les 12 derniers mois 
     * @return array Tableau associatif de clé un mois -aaaamm- et de valeurs l'année 
     * et le mois correspondant 
     */
    public function obtenirLesMoisDisponibles($idVisiteur,$periode) {
        if($periode == "all"){
        $req = "SELECT FicheFrais.mois as mois "
                . "FROM  FicheFrais "
                . "WHERE FicheFrais.idVisiteur ='$idVisiteur' "
                . "ORDER BY FicheFrais.mois desc ";
        }else
            if($periode == "year"){
                $req = "SELECT DISTINCT(mois) AS mois "
                . "FROM FicheFrais "
                . "WHERE mois >= (select max(mois)-100 from FicheFrais WHERE FicheFrais.idVisiteur ='$idVisiteur')"
                . "ORDER BY mois DESC";
            }
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

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return array Tableau avec des champs de jointure entre une fiche de frais 
     * et la ligne d'état 
     */
    public function obtenirLesInfosFicheFrais($idVisiteur, $mois) {
        $req = "SELECT FicheFrais.idEtat AS idEtat, "
                . "FicheFrais.dateModif AS dateModif, "
                . "FicheFrais.nbJustificatifs AS nbJustificatifs, "
                . "FicheFrais.montantValide AS montantValide, "
                . "Etat.libelle AS libEtat "
                . "FROM FicheFrais INNER JOIN Etat "
                . "ON FicheFrais.idEtat = Etat.id "
                . "WHERE FicheFrais.idVisiteur = '$idVisiteur' "
                . "AND FicheFrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais

     * Modifie le champ idEtat et met la date de modif à aujourd'hui
     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @param string $etat Etat en cours
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat) {
        $req = "UPDATE FicheFrais "
                . "SET idEtat = '$etat', "
                . "dateModif = now() "
                . "WHERE FicheFrais.idVisiteur ='$idVisiteur' "
                . "AND FicheFrais.mois = '$mois'";
        $this->executerRequete($req,'exec');
    }

    /**
     * modifie le champs nb justificatif et montant valide d'une fiche de frais
     * @param string $idVisiteur
     * @param string $mois
     * @param string $montant
     * @param string $nbJustificatifs
     */
    public function majMontantFicheFrais($idVisiteur, $mois, $montant, 
                                         $nbJustificatifs) {
        $req = "UPDATE FicheFrais SET montantValide ='$montant',"
                . "nbJustificatifs='$nbJustificatifs' "
                . "WHERE FicheFrais.idVisiteur ='$idVisiteur' "
                . "AND FicheFrais.mois = '$mois'";
        $this->executerRequete($req,'exec');
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
        $req = "SELECT DISTINCT(mois) AS date "
                . "FROM FicheFrais "
                . "WHERE mois >= (select max(mois)-100 from FicheFrais)"
                . "ORDER BY mois DESC";
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
    public function ficheExiste($id, $date, $etat) {
        $req = "SELECT * from FicheFrais "
                . "WHERE FicheFrais.idVisiteur = '$id'"
                . "AND FicheFrais.mois = '$date'"
                . "AND idEtat='$etat'";
        return $this->executerRequete($req, 'fetch()');
    }
    /**
     * remplace le libelle par celui entré en parametre
     * 
     * @param string $id
     * @param string $libelle
     */
    public function changerLibelle($id,$libelle){
        $req="UPDATE LigneFraisHorsForfait SET libelle='$libelle'"
                . "WHERE id='$id'"; 
        $this->executerRequete($req,'exec');
    }
    /**
     * verifie la taille du libelle et reduit  si nécéssaire à 95 carractères
     * 
     * @param string $id
     */
    public function verifierTailleLibelle($id){
        $req="SELECT libelle from LigneFraisHorsForfait where id='$id'";
       $lgLibelle = $this->executerRequete($req, 'fetch()');
        $taille=(strlen($lgLibelle['libelle']));
        if($taille>95){
            $libelle=(substr($lgLibelle['libelle'],0,95));
            $this->changerLibelle($id,$libelle);
        }              
    }
    /**
     * Modifie le libelle d'un frais hors forfait refusé(verifié 10/12/2014)
     * 
     * @param int $id id de la fiche fraishorsforfait
     */
    public function refuserLigneFraisHorsForfait($id) {
        $this->verifierTailleLibelle($id);
        $req = "UPDATE LigneFraisHorsForfait "
                . "SET libelle = concat('REFUS',libelle) "
                . "WHERE id='$id'";
        $this->executerRequete($req,'exec');
    }
    /**
     * Retourne montant du frais forfait
     * @param type $id
     * @return float
     */
    public function valeurMontant($id) {
        $req = "SELECT montant FROM FraisForfait WHERE id='$id'";
        $lgMontant = $this->executerRequete($req, 'fetch()');
        return (float) $lgMontant[0];
    }

    /**
     * Recupere les fiche frais dont l'état est donné en paramètre
     * 
     * @param string $etat etat de la fiche 
     * @return array Retourne un tableau de ficheFrais 
     */
    public function obtenirFichesFrais($etat) {
        $req = "SELECT * FROM FicheFrais WHERE idEtat='$etat'";
        return $this->executerRequete($req, 'fetchAll()');
    }

    /**
     * calcul la somme totale d'une ligne de frais forfaitisée(alerte double emploi verifiée la fonction obtenircumulfraisforfait 10/12/2014)
     * @param array $lesFraisForfait tableau de frais forfait
     * @return float
     */
    public function sommeFrais($lesFraisForfait) {
        $montantValide = 0;
        foreach ($lesFraisForfait as $frais) {
            (float) $montantValide +=($frais['quantite']) 
                                     * ( $this->valeurMontant($frais['idFrais']));
        }
        return (float) $montantValide;
    }

    /**
     * Recupere le nom et le prenom d'un visiteur en fonction de l'id
     * @param string $id
     * @return array
     */
    public function obtenirNomVisiteur($id) {
        $req = "SELECT nom,prenom FROM Visiteur WHERE id='$id'";
        $lgNom = $this->executerRequete($req, 'fetch()');
        $nom = $lgNom['nom'] . " " . $lgNom['prenom'];
        return $nom;
    }
    
    /**
     * Calcul le cumul des frais hors forfait d'un visiteur suivant le mois
     * @param string $mois
     * @param string $visiteur
     * @return float Cumul des frais hors forfait
     */
    public function getCumulFraisHorsForfait($mois,$visiteur){
        $req = "SELECT SUM(montant) AS cumul from LigneFraisHorsForfait "
                . "WHERE LigneFraisHorsForfait.idVisiteur = '$visiteur' "
                . "AND LigneFraisHorsForfait.mois = '$mois' "
                . "AND LigneFraisHorsForfait.libelle NOT LIKE 'REFUS%' ";
                $lgMontant = $this->executerRequete($req, 'fetch()');
		$cumulMontantHorsForfait = $lgMontant['cumul'];                               
                return (float)$cumulMontantHorsForfait;
    }
    
    /**
     * alcul le cumul des frais  forfait d'un visiteur suivant le mois(verifié 10/12/2014)
     * @param string $mois
     * @param string $visiteur
     * @return float cumul des frais  forfait
     */
    public function getCumulFraisForfait($mois,$visiteur){
        $req = "SELECT SUM(LigneFraisForfait.quantite * FraisForfait.montant) AS cumul "
                . "FROM LigneFraisForfait, FraisForfait "
                . "WHERE LigneFraisForfait.idFraisForfait = FraisForfait.id "
                . "AND LigneFraisForfait.idVisiteur = '$visiteur' "
                . "AND LigneFraisForfait.mois = '$mois' ";
                $lgMontant = $this->executerRequete($req, 'fetch()');
		$cumulMontantForfait = $lgMontant['cumul'];
                return (float)$cumulMontantForfait;
    }
    /*
     *Validation de la campagne 
     * 
     * 
     */
    public function validationCampagne() {
        $day = (new \DateTime())->format('d');        
        $moisPrecedent=  DateGsb::obtenirMoisPrecedent();        var_dump($moisPrecedent); 
        //verifier que nous sommens entre le 10 et 20 du mois suivant
        if ((int) $day >= 10 && (int) $day <= 22) {
            //si oui on cloture les fiches du mois precedent qui ne le sont pas
            $req = "UPDATE ficheFrais SET idEtat = 'CL' "
                    . "WHERE ficheFrais.mois = '$moisPrecedent' "
                    . "AND ficheFrais.idEtat = 'CR'";
            $this->executerRequete($req,'exec');
        }
    }
    
   
}
?>
