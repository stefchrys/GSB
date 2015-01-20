<!--  debut v_listeVisiteursMoisComptable -->
<div class="row">
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">
        <div class="contenu">
            <h3>
                <span class="label label-success">
                    Choix fiche (Visiteur/Mois)
                </span></h3>
            <h4>Selectionner une fiche de frais : </h4>
            <form action="index.php?uc=validerFrais&action=validerChoixVisiteurMois" 
                  method="post">
                <table >                
                    <tr>
                        <td> 
                            <select class="selectpicker" data-style="btn-info" id="visiteur" name="visiteur">
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
                            <select class="selectpicker" data-style="btn-info" id="mois" name="mois">
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
                        <td>
                            <button class="btn btn-success" id="ok" type="submit" value="Valider"  > Valider</button> 
                        </td>
                    </tr>               
                </table>
            </form>
        </div>
    </div>
    <div class="col-md-2 column"></div>
</div>
<!--  fin v_listeVisiteursMoisComptable -->   