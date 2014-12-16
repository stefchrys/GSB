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
    private static $bdd = 'dbname=gsbv3';
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
     * execute une requete en parametre et retourne un tableau associatif, un element ou 
     * ne retourne rien en fonction du deuxieme parametre
     * 
     * @param string $req
     * @param string $fetch
     * @return NULL or array retourne rien ou un tableau
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
     * Retourne les informations d'un visiteur(validé 10/12/2014)

     * @param string $login 
     * @param string $mdp
     * @return array renvoie l'id, le nom et le prénom sous la forme d'un 
     * tableau associatif 
     */
    public function obtenirInfoVisiteur($login, $mdp) {
        $req = "select visiteur.id as id, 
                    visiteur.nom as nom, 
                    visiteur.prenom as prenom 
                    from visiteur 
                    where visiteur.login='$login' and visiteur.mdp='$mdp'";       
        return $this->executerRequete($req,'fetch()');
    }

    /**
     * Retourne un tableau rempli des visiteurs(id,nom,prenom)(validé 10/12/2014)
     * 
     * @return Array Tableau de visiteurs
     */
    public function obtenirListeVisiteurs() {
        $req = "select visiteur.id as id,
            visiteur.nom as nom,
            visiteur.prenom as prenom
            from visiteur
            where visiteur.id 
             not in
            (select * from comptable)";
        return $this->executerRequete($req, 'fetchAll()');
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais 
     * hors forfait concernées par les deux arguments(validé 12/10/2014)

     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return array tous les champs des lignes de frais hors forfait sous la forme 
     * d'un tableau associatif 
     */
    public function obtenirLesFraisHorsForfait($idVisiteur, $mois) {
        $req = "select * from lignefraishorsforfait "
                . "where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
                and lignefraishorsforfait.mois = '$mois' ";
        $lgFraisHorsForf= $this ->executerRequete($req, 'fetchAll()');
        $nbLignes = count($lgFraisHorsForf);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lgFraisHorsForf[$i]['date'];
            $lgFraisHorsForf[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lgFraisHorsForf;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné(alerte 11/12/2014 semble inutilisée)

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return int Le nombre entier de justificatifs 
     */
    /*public function obtenirNbjustificatifs($idVisiteur, $mois) {
        $req = "select fichefrais.nbjustificatifs as nb from  fichefrais "
                . "where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        $idJeuJustif = PdoGsb::$monPdo->query($req);
        $lgJustif = $idJeuJustif->fetch();
        return $lgJustif['nb'];
    }*/

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de 
     * frais au forfait concernées par les deux arguments(validé 10/12/2014)

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return array l'id, le libelle et la quantité sous la forme d'un tableau associatif 
     */
    public function obtenirLesFraisForfait($idVisiteur, $mois) {
        $req = "select fraisforfait.id as idfrais, 
                fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite 
                from lignefraisforfait 
                inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' "
                . "and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";
        return $this ->executerRequete($req, 'fetchAll()');
    }

    /**
     * Retourne tous les id de la table FraisForfait

     * @return array  tableau associatif 
     */
    public function obtenirLesIdFrais() {
        $req = "select fraisforfait.id as idfrais "
                . "from fraisforfait order by fraisforfait.id";
        return $this ->executerRequete($req, 'fetchAll()');
    }

    /**
     * Verification type de personnel connecté(alerte 10/12/2014 le renvoie d'un tableau associatif est inutile, renvoyer juste un bool)

     * Verifie si la personne connectée est un comptable
     * @param string $id  id du de la personne conectée
     * @return array  Tableau associatif
     */
    function verifierComptable($id) {
        $req = "select comptable.id "
                . "from comptable where comptable.id='$id'";
        return $this->executerRequete($req,'fetchAll()');
    }

    /**
     * Met à jour la table ligneFraisForfait(validé 10/12/2014)

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
            $req = "update lignefraisforfait "
                    . "set lignefraisforfait.quantite = $qte
                    where lignefraisforfait.idvisiteur = '$idVisiteur' "
                    . "and lignefraisforfait.mois = '$mois'
                    and lignefraisforfait.idfraisforfait = '$unIdFrais'";
            $this->executerRequete($req, 'exec');
        }
    }

    /**
     * met à jour le nombre de justificatifs de la table ficheFrais(alerte 11/12/2014 semble inutilisée)
     * pour le mois et le visiteur concerné

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @param int $nbJustificatifs Nombre de justificatifs
     */
    /*public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs) {
        $req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
                where fichefrais.idvisiteur = '$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }*/

    /**
     * Teste si le frais est le premier du mois(verifié 10/12/2014)

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return bool vrai ou faux 
     */
    public function estPremierFraisMois($idVisiteur, $mois) {
        $ok = false;
        $req = "select count(*) as nblignesfrais 
                from fichefrais 
                where fichefrais.mois = '$mois' "
                . "and fichefrais.idvisiteur = '$idVisiteur'";
        $lgFrais= $this->executerRequete($req, 'fetch()');
        if ($lgFrais['nblignesfrais'] == 0) {
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
        $req = "select max(mois) as dernierMois "
                . "from fichefrais "
                . "where fichefrais.idvisiteur = '$idVisiteur'";
        $lgMois=$this->executerRequete($req, 'fetch()');
        $dernierMois = $lgMois['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour
     *  un visiteur et un mois donnés(verifié 10/12/2014)

     * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, 
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
        $req = "insert into fichefrais
                (idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
        $this->executerRequete($req,'exec');
        $lesIdFrais = $this->obtenirLesIdFrais();
        foreach ($lesIdFrais as $uneLigneIdFrais) {
            $unIdFrais = $uneLigneIdFrais['idfrais'];
            $req = "insert into lignefraisforfait
                    (idvisiteur,mois,idFraisForfait,quantite) 
                    values('$idVisiteur','$mois','$unIdFrais',0)";
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
        $dateFr = dateFrancaisVersAnglais($date);
        $req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
        $this->executerRequete($req,'exec');
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument(validé 10/12/2014)

     * @param string $idFrais 
     */
    public function supprimerFraisHorsForfait($idFrais) {
        $req = "delete from lignefraishorsforfait "
                . "where lignefraishorsforfait.id =$idFrais ";
        $this->executerRequete($req,'exec');
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais(verifié 10/12/2014)

     * @param string $idVisiteur 
     * @return array Tableau associatif de clé un mois -aaaamm- et de valeurs l'année 
     * et le mois correspondant 
     */
    public function obtenirLesMoisDisponibles($idVisiteur) {
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
     * pour un mois donné(verifié 10/12/2014)

     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @return array Tableau avec des champs de jointure entre une fiche de frais 
     * et la ligne d'état 
     */
    public function obtenirLesInfosFicheFrais($idVisiteur, $mois) {
        $req = "select ficheFrais.idEtat as idEtat, 
                ficheFrais.dateModif as dateModif, 
                ficheFrais.nbJustificatifs as nbJustificatifs, 
		ficheFrais.montantValide as montantValide, 
                etat.libelle as libEtat 
                from  fichefrais inner join Etat 
                on ficheFrais.idEtat = Etat.id 
		where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        return $this->executerRequete($req, 'fetch()');
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais(verifié 10/12/2014)

     * Modifie le champ idEtat et met la date de modif à aujourd'hui
     * @param string $idVisiteur 
     * @param string $mois sous la forme aaaamm
     * @param string $etat Etat en cours
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat) {
        $req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        $this->executerRequete($req,'exec');
    }

    /**
     * modifie le champs nb justificatif et montant valide d'une fiche de frais(verifié 10/12/2014)
     * @param string $idVisiteur
     * @param string $mois
     * @param string $montant
     * @param string $nbJustificatifs
     */
    public function majMontantFicheFrais($idVisiteur, $mois, $montant, 
                                         $nbJustificatifs) {
        $req = "update fichefrais set montantValide ='$montant',"
                . "nbJustificatifs='$nbJustificatifs' "
                . "where fichefrais.idvisiteur ='$idVisiteur' "
                . "and fichefrais.mois = '$mois'";
        $this->executerRequete($req,'exec');
    }

    /**
     * renvoie un tableau composé des 12 derniers mois (alerte 10/12/2014 voir si on peu changer par une requete dans base de donnée)
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
     * Teste si une fiche de frais cloturee existe concernant (validée 10/12/2014)
     * le visiteur l'etat et le mois passé en paramètre renvoie un tab
     * @param string $id 
     * @param string $date
     * @param string $etat
     * @return Array or NULL
     */
    public function ficheExiste($id, $date, $etat) {
        $req = "select * from ficheFrais "
                . "where ficheFrais.idVisiteur = '$id'"
                . "and ficheFrais.mois = '$date'"
                . "and idEtat='$etat'";
        return $this->executerRequete($req, 'fetch()');
    }
    /**
     * remplace le libelle par celui entré en parametre
     * 
     * @param string $id
     * @param string $libelle
     */
    public function changerLibelle($id,$libelle){
        $req="update ligneFraisHorsForfait set libelle='$libelle'"
                . "where id='$id'"; 
        $this->executerRequete($req,'exec');
    }
    /**
     * verifie la taille du libelle et reduit  si nécéssaire à 95 carractères
     * 
     * @param string $id
     */
    public function verifierTailleLibelle($id){
        $req="select libelle from ligneFraisHorsForfait where id='$id'";
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
        $req = "update ligneFraisHorsForfait "
                . "set libelle = concat('REFUS',libelle) "
                . "where id='$id'";
        $this->executerRequete($req,'exec');
    }
    /**
     * alerte 10/12/2014 
     * @param type $id
     * @return type
     */
    public function valeurMontant($id) {
        $req = "select montant from fraisForfait where id='$id'";
        $lgMontant = $this->executerRequete($req, 'fetch()');
        return (float) $lgMontant[0];
    }

    /**
     * Recupere les fiche frais dont l'état est donné en paramètre(verifié 10/12/2014)
     * 
     * @param string $etat etat de la fiche 
     * @return array Retourne un tableau de ficheFrais 
     */
    public function obtenirFichesFrais($etat) {
        $req = "select * from ficheFrais where idEtat='$etat'";
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
                                     * ( $this->valeurMontant($frais['idfrais']));
        }
        return (float) $montantValide;
    }

    /**
     * Recupere le nom et le prenom d'un visiteur en fonction de l'id(verifié 10/12/2014)
     * @param string $id
     * @return array
     */
    public function obtenirNomVisiteur($id) {
        $req = "select nom,prenom from visiteur where id='$id'";
        $lgNom = $this->executerRequete($req, 'fetch()');
        $nom = $lgNom['nom'] . " " . $lgNom['prenom'];
        return $nom;
    }
    
    /**
     * Calcul le cumul des frais hors forfait d'un visiteur suivant le mois(verifié 10/12/2014)
     * @param string $mois
     * @param string $visiteur
     * @return float cumul des frais hors forfait
     */
    public function getCumulFraisHorsForfait($mois,$visiteur){
        $req = "select sum(montant) as cumul from ligneFraisHorsForfait "
                . "where ligneFraisHorsForfait.idVisiteur = '$visiteur' "
                . "and ligneFraisHorsForfait.mois = '$mois' "
                . "and ligneFraisHorsForfait.libelle not like 'REFUS%' ";
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
        $req = "select sum(ligneFraisForfait.quantite * fraisForfait.montant) as cumul "
                . "from ligneFraisForfait, FraisForfait "
                . "where ligneFraisForfait.idFraisForfait = fraisForfait.id "
                . "and ligneFraisForfait.idVisiteur = '$visiteur' "
                . "and ligneFraisForfait.mois = '$mois' ";
                $lgMontant = $this->executerRequete($req, 'fetch()');
		$cumulMontantForfait = $lgMontant['cumul'];
                return (float)$cumulMontantForfait;
    }
}
?>