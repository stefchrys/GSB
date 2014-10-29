<?php
/**
 * Affichage Erreur
 * @author chrysinus@gmail.com
 */
?>

<div class ="erreur">
    <ul>
        <?php
        foreach ($_REQUEST['erreurs'] as $erreur) {
            echo "<li>$erreur</li>";
        }
        ?>
    </ul></div>
