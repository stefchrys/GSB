<!--debut sommaireComptable -->
<div class="row clearfix"  >
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">        			
        <ul class="nav nav-pills" id="menuList">
            <li >
                <h4>Comptable
                    <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?></h4>
            </li>
            <li >
                <a href="index.php?uc=validerFrais&action=choixVisiteurMois" 
                   title="Valider fiche de frais">Valider fiche de frais
                </a>
            </li>
            <li >
                <a href="index.php?uc=suivrePaiement&action=choixFicheValide" 
                   title="Suivre le paiement fiche de frais">
                    Suivre le paiement fiche de frais
                </a>
            </li>
            <li >
                <a href="index.php?uc=connexion&action=deconnexion" 
                   title="Se déconnecter">Déconnexion
                </a>
            </li>
        </ul>       
    </div>
    <div class="col-md-2 column"></div>
</div>
<!-- fin sommaireComptable -->