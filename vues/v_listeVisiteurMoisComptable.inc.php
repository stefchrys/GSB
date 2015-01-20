<!--  debut v_listeVisiteursMoisComptable -->
<div class="row">
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">
        <div class="contenu">
            <h3>Choix fiche (Visiteur/Mois)</h3>
            <h4>Selectionner une fiche de frais : </h4>
            <form action="index.php?uc=validerFrais&action=validerChoixVisiteurMois" 
                  method="post">
                <table >                
                    <tr>
                        <td>
                            Visiteurs : 
                            <select id="visiteur" name="visiteur">
                                <?php
                                foreach ($visiteurs as $unVisiteur) {
                                    $nom = $unVisiteur['nom'];
                                    $prenom = $unVisiteur['prenom'];
                                    $idVisiteur = $unVisiteur['id'];
                                    if ($idVisiteur == $visiteurASelectionner) {
                                        ?>
                                        <option selected value="<?php echo $idVisiteur ?>">
                                            <?php echo $nom . " " . $prenom ?> </option>
                                        <?php
                                    } else {
                                        ?> 
                                        <option  value="<?php echo $idVisiteur ?>">  
                                            <?php echo $nom . " " . $prenom ?> </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>                   
                        <td>
                            Mois :
                            <select id="mois" name="mois">
                                <?php
                                foreach ($tableauDate as $uneDate) {
                                    $date = $uneDate['date'];
                                    $numAnnee = $uneDate['numAnnee'];
                                    $numMois = $uneDate['numMois'];
                                    if ($date == $dateASelectionner) {
                                        ?>
                                        <option selected value="<?php echo $date ?>">
                                            <?php echo $numMois . "/" . $numAnnee ?>
                                        </option> 
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $date ?>">
                                            <?php echo $numMois . "/" . $numAnnee ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>    
                            </select>
                        </td>
                    </tr>               
                </table>
                <div class="piedForm">
                    <p>
                        <input id="ok" type="submit" value="Valider"  />                    
                    </p> 
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-2 column"></div>
</div>
<!--  fin v_listeVisiteursMoisComptable -->   