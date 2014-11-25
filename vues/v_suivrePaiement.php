<!--  debut v_SuivrePaiements -->

<div class="col-md-10 column">
    <div class="contenu">
        <h3>Choix fiche Frais </h3>
        <h4>Selectionner une fiche de frais : </h4>
        <!-- <form action="index.php?uc=suivrePaiement&action=payerFicheFrais" method="post-->
            <table >
               <?php 
               foreach($fichesFraisVA as $fiche){
                   $numFiche=($fiche['idVisiteur']).($fiche['mois']);
                   $montant=$fiche['montantValide'];                              
                ?>
                <tr>
                    <td>
                        Numéro fiche: <?php echo $numFiche;?>
                    </td>
                    <td>
                        Montant: <?php echo $montant;?>
                    </td>
                    <td>
                        <form method="post" action="index.php?uc=suivrePaiement&action=choisirFichePayer">
                            <input type="submit" value="Rembourser" name="<?php echo $numFiche ?>" />
                        </form>
                    </td>
                </tr>
               <?php } ?>
            </table>
            <div class="piedForm">
                <p>
                    <input id="ok" type="submit" value="Valider"  />
                    
                </p> 
            </div>
        <!--</form>-->
    </div>
</div>
</div>
    <!--  fin v_suivrePaiements -->
