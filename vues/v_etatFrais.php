<!--debut v_etatFrais -->
<div class="row clearfix"  >
    
    <div class="col-md-12 column contenu" >
        <h3>Fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?> : 
        </h3>
        <p>
            Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif ?> <br> Montant validé : <?php echo $montantValide ?>


        </p>

        <h3 class='contenu'>
            Eléments forfaitisés .
        </h3>
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
                        <td ><?php echo $quantite ?> </td>
                        <?php
                    }
                    ?>
                </tr>


            </tbody>
        </table>
        <table class="table table-hover">
            <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
            </caption>
            <thead>
            <th><span class="label label-info">Date</span></th>
            <th><span class="label label-info">Libellé</span></th>

            <th><span class="label label-info">Montant</span></th>

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
                    </tr>
                    <?php
                }
                ?>
                
        </table>


    </div>		
</div>
<!--fin v_etatFrais -->














