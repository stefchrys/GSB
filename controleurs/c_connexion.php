<?php
/**
 * Verification et redirection d'un utilisateur
 * test de branche
 * Redirige l'utilisateur qui essaye de se connecter vers le sommaire si 
 * la connexion est validée sinon vers la page connexion .
 */


if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
//on check la valeur de $action et on procede au bon traitement
switch($action){
        //affichage de la page connexion
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
        //on controle l'identité 
	case 'valideConnexion':{
		$login = $_REQUEST['txt_login'];
		$mdp = $_REQUEST['txt_mdp'];
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);                
                //si conexion est pas valide retour depart
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
                // connexion ok on verifie le type de personne connectée
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
                       	
                        // si c'est un comptable on affiche son sommaire comptable
                        if($pdo->verifierComptable($id)!=null){
                            include ("vues/v_sommaireC.php");
                        //sinon le sommaire visiteur
                        }else{
                            include("vues/v_sommaire.php");
                        }
		}
		break;
	}       
        //retour sur la page de connexion dans tout les autres cas
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>