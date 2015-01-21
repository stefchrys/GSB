<!--  debut v_listeMois -->
<div class="row">
    <div class="col-md-2 column"></div>
    <div class="col-md-8 column">
        <div class="contenu">
            
            
            <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
                <div class="corpsForm">
                    <p>
                        <!--<label for="lstMois" accesskey="n"><h4>Mois :</h4> </label>-->
                        <select class="selectpicker" data-style="btn-info" id="lstMois" name="lstMois">
                            <?php
                            foreach ($lesMois as $unMois) {
                                $mois = $unMois['mois'];
                                $numAnnee = $unMois['numAnnee'];
                                $numMois = $unMois['numMois'];
                                if ($mois == $moisASelectionner) {
                                    ?>
                                    <option selected value="<?php echo $mois ?>">
                                        <?php echo $numMois . "/" . $numAnnee ?></option> 
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $mois ?>">
                                        <?php echo $numMois . "/" . $numAnnee ?></option>
                                    <?php
                                }
                            }
                            ?>    
                        </select>
                        <button class="btn btn-success" id="ok" type="submit" value="Valider"  >
                            Valider
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        </button>
                    </p>
                </div>       
            </form>     		
        </div>
    </div>
    <div class="col-md-2 column"></div>
</div>
<!-- fin v_listeMois -->