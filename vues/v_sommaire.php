 
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
            Visiteur<br>
            <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
        </li>
        <li >
            <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
        </li>
        <li >
            <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
        </li>
        <li >
            <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
        </li>
    </ul>

</div>
