<!--debut v_etatFrais -->
<div class="row clearfix"  >  
     <div class="col-md-2 column"></div>
    <div class="col-md-8 column contenu" >
        <h3>
            <span class="label label-info">
                Fiche de frais  
                    <?php 
                    $periode = moisChaine((int)$numMois) . "-" . $numAnnee;
                    echo $periode;
                    ?> : 
            </span>
        </h3>
            Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif ?> 
        <br/>
        
             Montant  : <?php echo $montantValide ?><br/>
                <?php echo $nbJustificatifs ?> justificatifs reçus -
        <form class="form-horizontal" action="pdf.php?" method="POST" role="form" target="_blank">
            <input type="submit" class="btn pull-right arrondi" value=""/>
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php
                    $intitule = array('Frais forfaitaires','Quantité','Montant unitaire','Total');
                    foreach ($intitule as $el) {
                        ?>	
                        <th> <?php echo $el ?></th>
                        <?php
                    }
                    ?>						
                </tr>
            </thead>
            <tbody>
                
                    <?php
                    $sousTotalF = 0;
                    $txtFilePdfFraisForfait='';
                    foreach ($lesFraisForfait as $unFraisForfait) {
                        $libelle = $unFraisForfait['libelle'];
                        $txtFilePdfFraisForfait = $txtFilePdfFraisForfait . $libelle . '!';
                        $quantite = $unFraisForfait['quantite'];
                        $txtFilePdfFraisForfait = $txtFilePdfFraisForfait . $quantite . '!';
                        $MU = $unFraisForfait['montant'];
                        $txtFilePdfFraisForfait = $txtFilePdfFraisForfait . $MU . '!';
                        $total = $MU * $quantite;
                        $txtFilePdfFraisForfait = $txtFilePdfFraisForfait . $total . '!';
                        ?>
                <tr>
                        <td ><?php echo $libelle ?>                            
                        </td>                       
                        <td ><?php echo $quantite ?>                            
                        </td>
                        <td ><?php echo $MU ?>                            
                        </td>
                        <td ><?php echo $total ?>                           
                        </td>                       
                        <?php $sousTotalF += $total; ?>
                </tr>
                        <?php
                    }
                    ?>
                <tr class="warning">
                    <td>Sous Total</td>
                    <td></td>
                    <td></td>
                    <td><?php echo $sousTotalF ?></td>
                    <?php 
                        $txtFilePdfFraisForfait = $txtFilePdfFraisForfait
                            .'Sous Total! ! !'.$sousTotalF;
                        $txtFilePdfFraisForfait = addslashes($txtFilePdfFraisForfait);
                    ?>
                </tr>
                
            </tbody>
        </table>
        <table class="table table-hover">
            <thead>
            <th>Frais Hors-Forfait</th>
            <th>Date</th>
            <th>Montant</th>
            </thead>
            <tbody>
                <?php
                $sousTotalFhF = 0;
                $txtFilePdfFraisHorsForfait = '';
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $date = $unFraisHorsForfait['date'];
                    $txtFilePdfFraisHorsForfait = $txtFilePdfFraisHorsForfait . $date . '!';
                    $libelle = $unFraisHorsForfait['libelle']; 
                    $txtFilePdfFraisHorsForfait = $txtFilePdfFraisHorsForfait . $libelle . '!';
                    //formater les retour chariots eventuels sur le libelle
                    //(attention bug de carractères) Grrrr!
                    /*$char=30;
                    if(strlen($libelle)>$char){
                       $libelle = retourChariot($libelle, $char);
                    }*/
                    $montant = $unFraisHorsForfait['montant'];
                    $txtFilePdfFraisHorsForfait = $txtFilePdfFraisHorsForfait . $montant . '!';
                    //gestion couleur du refus de frais
                    $couleur = 'default';
                    if (substr($libelle, 0, 5) == 'refus' 
                        || substr($libelle, 0, 5) == 'REFUS') {
                        $couleur = "danger";
                    }
                    ?>                   
                    <tr class="<?php echo $couleur ?>">
                        <td><?php echo $libelle ?></td>
                        <td><?php echo $date ?></td>
                        <td><?php echo $montant ?></td>
                        <?php
                        //si frais refusé on ne le comptabilise pas
                        if (($couleur == 'default')){
                            $sousTotalFhF += $montant;
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                <tr class="warning">
                    <td>Sous Total</td>
                    <td></td>
                    <td><?php echo $sousTotalFhF ?></td>
                    <?php 
                        $txtFilePdfFraisHorsForfait = $txtFilePdfFraisHorsForfait
                                .'Sous Total! !'. $sousTotalFhF;
                        $txtFilePdfFraisHorsForfait = addslashes( $txtFilePdfFraisHorsForfait);
                    ?>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="success">
                    <td>Total Frais </td>
                    <td></td>
                    <td><?php echo $sousTotalF + $sousTotalFhF ?></td>
                </tr>
        </table>
        <?php 
            $nom = $_SESSION['prenom'] . "  " . $_SESSION['nom'];
            $periode = $periode.' '.$nom;
            $periode = addslashes($periode);
            $txtFilePdfResume =   $dateModif.'!'.$libEtat.'!'.$nbJustificatifs.'!'.$montantValide;
            $txtFilePdfResume = addslashes($txtFilePdfResume);   
        ?>
        <input type='hidden' name='txtFilePdfMois' value='<?php echo $periode?>'/>  
        <input type='hidden' name='txtFilePdfResume' value='<?php echo $txtFilePdfResume ?>'/>
        <input type='hidden' name='txtFilePdfFraisForfait' value='<?php echo $txtFilePdfFraisForfait ?>'/>
        <input type='hidden' name='txtFilePdfFraisHorsForfait' value='<?php echo $txtFilePdfFraisHorsForfait ?>'/>
        
         
        
        
        </form>
    </div>	
      <div class="col-md-2 column"></div>
</div>
<!--fin v_etatFrais -->