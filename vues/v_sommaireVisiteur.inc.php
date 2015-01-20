<!--debut sommaireVisiteurs -->
<div class="row clearfix"  >
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">         			
        <ul class="nav nav-pills" id="menuList">
            <li >
                <h4> Visiteur:
                    <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?></h4>
            </li>
            <li role="presentation">
                <a href="index.php?uc=gererFrais&action=saisirFrais" 
                   title="Saisie fiche de frais ">
                    Saisie fiche de frais
                </a>
            </li>
            <li >
                <a href="index.php?uc=etatFrais&action=selectionnerMois" 
                   title="Consultation de mes fiches de frais">
                    Mes fiches de frais
                </a>
            </li>
            <li >
                <a href="index.php?uc=connexion&action=deconnexion" 
                   title="Se déconnecter">
                    Déconnexion
                </a>
            </li>
        </ul>   
    </div>
    <div class="col-md-2 column"></div>
</div>
<!-- fin sommaireVisiteurs -->
