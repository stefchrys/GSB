<?php
/**
 * Verification et redirection d'un utilisateur
 * 
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
                //si $visiteur n'est pas un tableau on renvoie vers connexion
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
                /*si $visiteur est un tableau associatif alors on se connecte
                au sommaire en récuperant les valeurs du tableau
                et en les assignant aux variables de SESSION*/
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
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