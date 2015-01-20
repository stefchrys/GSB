<!--debut sommaireComptable -->
<div class="row clearfix"  >
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">        			
        <ul class="nav nav-pills" id="menuList">
            <li >
                <h4>
                    <span class="glyphicon glyphicon-user">
                        Comptable</br>
                    <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
                    </span>
                </h4>
            </li>
            <li >
                <a href="index.php?uc=validerFrais&action=choixVisiteurMois" 
                   title="Valider fiche de frais">
                    <span class="glyphicon glyphicon-check">
                        Validation
                    </span>
                </a>
            </li>
            <li >
                <a href="index.php?uc=suivrePaiement&action=choixFicheValide" 
                   title="Suivre le paiement fiche de frais">
                    <span class="glyphicon glyphicon-list">
                        Reglement
                    </span>
                </a>
            </li>
            <li >
                <a href="index.php?uc=connexion&action=deconnexion" 
                   title="Se déconnecter">
                    <span class="glyphicon glyphicon-log-out">
                        Déconnexion
                    </span>
                </a>
            </li>
        </ul>       
    </div>
    <div class="col-md-2 column"></div>
</div>
<!-- fin sommaireComptable -->