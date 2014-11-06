<!--debut v_traiterFrais -->
<div class="row clearfix"  >
    <div class="col-md-2 column contenu" >
    </div >
    <div class="col-md-10 column contenu" >        
        <h3>Fiche de frais du mois <?php echo $ficheMois . "-" . $ficheAnnee ?> : 
        </h3>
        <h3 class='contenu'>
            Eléments forfaitisés .
        </h3>
        <form action="index.php?uc=validerFrais&action=validerTraitement" method="post">
            <?php
            $moisChoisi = $_REQUEST['mois'];
            $idVisiteur = $_REQUEST['visiteur'];
            ?>
            <input type='hidden' name='mois' value='<?php echo $moisChoisi ?>' />
            <input type='hidden' name='visiteur' value='<?php echo $idVisiteur ?>' />
            <table class="table">
                <thead>
                    <tr>
                        <?php
                        foreach ($lesFraisForfait as $unFraisForfait) {
                            $libelle = $unFraisForfait['libelle'];
                            ?>	
                            <td> <?php echo $libelle ?></td>
                            <?php
                        }
                        ?> 
                            <td>Etat:</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="success">
                        <?php
                        $numero = 0;
                        foreach ($lesFraisForfait as $unFraisForfait) {
                            $quantite = $unFraisForfait['quantite'];
                            ?>                          
                            <td ><input type="text" class="form-control" 
                                        value="<?php echo $quantite ?>" 
                                        name="fraisForfait<?php echo $numero ?>"/>
                            </td>
                            <?php
                            $numero++;
                        }
                        ?>
                        <td>  <select name="etatFraisForfait">
                                <option selected value="CL">Enregistré</option>
                                <option value="VA">Validé</option>
                            </select></td>  
                    </tr>
                </tbody>
            </table>
            <h3 class='contenu'>
                Descriptif des éléments hors forfait
            </h3>
            <table class="table table-hover">
                <tr>
                    <td><span class="label label-info">Date</span></td>
                    <td><span class="label label-info">Libellé</span></td>
                    <td><span class="label label-info">Montant</span></td>
                    <td><span class="label label-info">Etat</span></td>
                </tr>
                <tbody>
                    <?php
                    foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                        $date = $unFraisHorsForfait['date'];
                        $libelle = $unFraisHorsForfait['libelle'];
                        $montant = $unFraisHorsForfait['montant'];
                        ?>
                        <tr>
                            <td><?php echo $date ?></td>
                            <td><?php echo $libelle ?></td>
                            <td><?php echo $montant ?></td>
                            <td>
                                <select name="etatFraisHorsForfait">
                                    <option selected value="CL">Enregistré</option>
                                    <option value="VA">Validé</option>
                                    <option value="VA">Reporté</option>
                                    <option value="RF">Refusé</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?> 
                </tbody>
            </table>           
                <label> Nb de justificatifs requis:</label><?php echo count($lesFraisForfait)/2; ?>                       
                <label> Nb justificatifs reçus:</label><input type="text"/>                      
            <div class="piedForm">
               
                 <p>
                    <input  type="submit" value="Valider le traitement"  />                   
                </p> 
            </div>
        </form>
    </div>		
</div>
<!--fin v_traiterFrais -->














