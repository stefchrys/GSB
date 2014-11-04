 
	<!--debut sommaireC -->
	<div class="row clearfix"  >
		<div class="col-md-4 column">
			<div id="menuGauche">   			
    			<ul id="menuList">
        			<li >
            			Comptable<br>
            			<?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
        			</li>
			        <li >
			            <a href="index.php?uc=validerFrais&action=choixVisiteurMois" title="Valider fiche de frais">Valider fiche de frais</a>
			        </li>
			        <li >
			            <a href="index.php?uc=suivrePaiement&action=choixFicheValide" title="Suivre le paiement fiche de frais">Suivre le paiement fiche de frais</a>
			        </li>
			        <li >
			            <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
			        </li>
			    </ul>
			</div>
		</div>
	<!-- fin sommaireC -->