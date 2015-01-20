<!--debut v_listeFraisForfait -->
<div class="row">
     <div class="col-md-2 column"></div>
<div class="col-md-8 column ">
    <h3 >
        Renseigner ma fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?>
    </h3>
    <form class="form-horizontal " role="form" method="POST"  
          action="index.php?uc=gererFrais&action=validerMajFraisForfait">
        <fieldset>
            <legend> Eléments forfaitisés</legend>
            <?php
            foreach ($lesFraisForfait as $unFrais) {
                $idFrais = $unFrais['idFrais'];
                $libelle = $unFrais['libelle'];
                $quantite = $unFrais['quantite'];
                ?>
                <div class="form-group">
                    <label for="idFrais" class="col-sm-2 control-label">
                        <?php echo $libelle ?></label>
                    <div class="col-sm-10">
                        <input class="form-control" id="idFrais" type="text"
                               name="txt_lesFrais[<?php echo $idFrais ?>]" 
                               value="<?php echo $quantite ?>"/>
                    </div>
                </div><?php } ?>					
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" 
                            name="cmd_valider">Valider</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
      <div class="col-md-2 column"></div>
</div>
<!--fin v_listeFraisForfait -->