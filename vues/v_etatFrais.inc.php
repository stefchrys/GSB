<!--debut v_etatFrais -->
<div class="row clearfix"  >  
     <div class="col-md-2 column"></div>
    <div class="col-md-8 column contenu" >
        <h3>
            <span class="label label-default">
                Fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?> : 
            </span>
        </h3>
            Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif ?> 
        <br/>
        
             Montant validé : <?php echo $montantValide ?>
       
        <h3 class='contenu'>
            <span class="label label-default">
                Eléments forfaitisés .
            </span>
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
            <h3>
            <span class="label label-default">
                Descriptif des éléments hors forfait -
                <?php echo $nbJustificatifs ?> justificatifs reçus -
            </span>
            </h3>
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
                    //formater les retour chariots eventuels sur le libelle
                    $char=30;
                    if(strlen($libelle)>$char){
                       $libelle = retourChariot($libelle, $char);
                    }
                    $montant = $unFraisHorsForfait['montant'];
                    $couleur = 'success';
                    if (substr($libelle, 0, 5) == 'refus' 
                        || substr($libelle, 0, 5) == 'REFUS') {
                        $couleur = "danger";
                    }
                    ?>                   
                    <tr  class="<?php echo $couleur ?>">
                        <td><?php echo $date ?></td>
                        <td><?php echo $libelle ?></td>
                        <td><?php echo $montant ?></td>
                    </tr>
                    <?php
                }
                ?>                
        </table>
    </div>	
      <div class="col-md-2 column"></div>
</div>
<!--fin v_etatFrais -->