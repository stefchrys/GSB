<!--debut v_traiterFrais -->
<div class="row clearfix"  >

    <div class="col-md-12 column contenu" >
        <h3>Fiche de frais du mois <?php echo $ficheMois . "-" . $ficheAnnee ?> : 
        </h3>
        <h3 class='contenu'>
            Eléments forfaitisés .
        </h3>
        <form action="index.php?uc=validerFrais&action=actualiserFraisForfait" method="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($lesFraisForfait as $unFraisForfait) {
                            $libelle = $unFraisForfait['libelle'];
                            ?>	
                            <th> <?php echo $libelle ?></th>
                            <?php
                        }
                        ?>
                            
                    </tr>
                </thead>
                <tbody>
                    <tr class="success">
                        <?php
                        foreach ($lesFraisForfait as $unFraisForfait) {
                            $quantite = $unFraisForfait['quantite'];
                            ?>
                        <td ><input type="text" value="<?php echo $quantite ?> "/></td>
                            <?php
                        }
                        ?>
                            
                    </tr>
                </tbody>
            </table>
            <table>
                <tr>
                    <td>
                        <select name="etatFraisForfait">
                            <option selected value="CL">Enregistré</option>
                            <option value="VA">Validé</option>
                            <option value="RB">Remboursé</option>
                        </select>
                    </td>
                    <td>
                        <div class="piedForm">
                            
                                <input id="ok" type="submit" value="Valider votre choix"  />
                                
                            
                        </div>
                    </td>
                </tr>
            </table>
        </form>
         <form action="index.php?uc=validerFrais&action=choixEtat" method="post">
            <table class="table table-hover">
                <h3 class='contenu'>
                    Descriptif des éléments hors forfait
                </h3>
                <thead>
                <th><span class="label label-info">Date</span></th>
                <th><span class="label label-info">Libellé</span></th>
                <th><span class="label label-info">Montant</span></th>
                <th><span class="label label-info">Etat</span></th>
                </thead>
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
                                    <option value="RB">Remboursé</option>
                                    <option value="RF">Refusé</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>               
            </table>
             <div class="piedForm">
                <p>
                    <input  type="submit" value="Valider"  />
                    <input  type="reset" value="Effacer"  />
                </p> 
            </div>
        </form>
    </div>		
</div>
<!--fin v_traiterFrais -->














