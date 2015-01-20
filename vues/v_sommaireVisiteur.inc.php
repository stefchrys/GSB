<!--debut sommaireVisiteurs -->
<div class="row clearfix"  >
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">         			
        <ul class="nav nav-pills" id="menuList">
            <li >
                <h4><span class="glyphicon glyphicon-user"> 
                        Visiteur</br>
                    <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
                    </span>
                </h4>
            </li>
            <li role="presentation">
                <a href="index.php?uc=gererFrais&action=saisirFrais" 
                   title="Saisie fiche de frais ">
                    <span class="glyphicon glyphicon-pencil">
                        Saisie
                    </span>
                </a>
            </li>
            <li >
                <a href="index.php?uc=etatFrais&action=selectionnerMois" 
                   title="Consultation de mes fiches de frais">
                    <span class="glyphicon glyphicon-eye-open">
                        Consultation
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
<!-- fin sommaireVisiteurs -->
