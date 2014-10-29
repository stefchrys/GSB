<?php
/**
 * Affichage du Visiteur en cours
 * @author chrysinus@gmail.com
 */
?>
<ul>
<?php
	  $id = $_SESSION['idVisiteur'];
      echo "bonjour $id <a href='Deconnexion.php' >Deconnexion</a>";

?>
</ul>
