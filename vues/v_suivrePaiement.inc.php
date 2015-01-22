<!--  debut v_SuivrePaiements -->
<div class="row">
    <div class="col-md-2 column contenu" >
    </div >
    <div class="col-md-8 column">
        <div class="contenu">
            <h3>
                <span class="label label-success">
                    Fiches frais à rembourser 
                </span>
            </h3>
            <h4>Selectionner une fiche de frais : </h4> 
            <form action="index.php?uc=suivrePaiement&action=payerFicheFrais" method="post">
                <table class="table table-hover">
                    <thead>               
                    <th><span class="label label-info">Numéro</span></th>
                    <th><span class="label label-info">Nom</span></th>
                    <th><span class="label label-info">Mois</span></th>
                    <th><span class="label label-info">Total</span></th>
                    <th><span class="label label-info">Forfait</span></th>
                    <th><span class="label label-info">Hors-Forfait</span></th> 
                    <th><span class="label label-info"> effectuer virement</span></th>
                    </thead>
                    <thbody>
                        <?php
                        foreach ($tabInfoUtiles as $fiche) {
                            $id = $fiche['id'];
                            $mois = $fiche['mois'];
                            $numFiche = $id . $mois;
                            $montant = $fiche['montantTotal'];
                            $nom = $fiche['nom'];
                            $montantF = $fiche['fraisForfait'];
                            $montantHF = $fiche['fraisHorsForfait'];
                            $couleur = $fiche['alerte'];
                            ?>  
                            <tr class="<?php echo $couleur ?>">
                                <td>
                                    <?php echo $numFiche; ?>
                                </td>
                                <td>
                                    <?php echo $nom; ?>
                                </td>
                                <td>
                                    <?php echo $mois ?>
                                </td>                    
                                <td>
                                    <?php echo $montant; ?>
                                </td>
                                <td>
                                    <?php echo $montantF; ?>
                                </td>
                                <td>
                                    <?php echo $montantHF; ?>
                                </td>
                                <td>
                                    <input type="checkbox" name="choix[]"  
                                           value="<?php echo $id . '-' . $mois . '-' . $nom ?>" 
                                           > 
                                    Valider
                                </td>
                            </tr>
                        <?php } ?>
                    </thbody>
                </table>
                <div class="piedForm">
                    <p>
                        <button class="btn btn-success" id="ok" type="submit">  
                            Valider 
                            <span class="glyphicon glyphicon-ok-sign"> 
                                </span>
                        </button>                  
                    </p> 
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-2 column contenu" >
</div >
</div>
<!--  fin v_suivrePaiements -->