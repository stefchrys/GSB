 
<?php
/**
 * Affichage du Sommaire
 * @author chrysinus@gmail.com
 */
?>
<!-- Division pour le sommaire -->
<div id="menuGauche">
    <div>

        <h2>

        </h2>

    </div>  
    <ul id="menuList">
        <li >
            Comptable<br>
            <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
        </li>
        <li >
            <a href="index.php?uc=validerFrais&action=validerFrais" 
               title="Valider fiche de frais ">Valider fiche de frais</a>
        </li>
        <li >
            <a href="index.php?uc=suivrePaiement&action=suivrePaiement" 
               title="Suivre paiement fiches de frais">Paiemant fiche de frais</a>
        </li>
        <li >
            <a href="index.php?uc=connexion&action=deconnexion" 
               title="Se déconnecter">Déconnexion</a>
        </li>
    </ul>

</div>
