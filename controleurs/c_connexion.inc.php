<?php
/**
 * Verification et redirection d'un utilisateur
 * test de branche
 * Redirige l'utilisateur qui essaye de se connecter vers le sommaire si 
 * la connexion est validée sinon vers la page connexion .
 */
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
//on check la valeur de $action et on procede au bon traitement
switch ($action) {
    //affichage de la page connexion
    case 'demandeConnexion': {
            require("vues/v_connexion.inc.php");
            break;
        }
    //on controle l'identité 
    case 'valideConnexion': {
            $login = $_REQUEST['txt_login'];
            $mdp = sha1($_REQUEST['txt_mdp']);
            $visiteur = $pdo->obtenirInfoVisiteur($login, $mdp);
            //si conexion est pas valide retour depart
            if (!is_array($visiteur)) {
                ajouterErreur("Login ou mot de passe incorrect");
                require("vues/v_erreurs.inc.php");
                require("vues/v_connexion.inc.php");
            }
            // connexion ok on verifie le type de personne connectée
            else {
                $id = $visiteur['id'];
                $nom = $visiteur['nom'];
                $prenom = $visiteur['prenom'];
                Connect::connecter($id, $nom, $prenom);
                //controle type personnel
                $type = $pdo->verifierComptable($id);
                switch ($type['libelle']):
                    case 'comptable':{
                        require ("vues/v_sommaireComptable.inc.php");
                        break;
                    }
                    case 'visiteur':{
                         require("vues/v_sommaireVisiteur.inc.php");
                         break;
                    }
                endswitch;
            }
            break;
        }
    //retour sur la page de connexion dans tout les autres cas
    default : {
            require("vues/v_connexion.inc.php");
            break;
        }
}
?>