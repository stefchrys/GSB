 <!--  debut v_listeMois -->

		<div class="col-md-8 column">
    <div class="contenu">
      <h3>Mes fiches de frais</h3>
      <h4>Mois à sélectionner : </h4>
      <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
          <div class="corpsForm">
              <p>
                  <label for="lstMois" accesskey="n">Mois : </label>
                  <select id="lstMois" name="lstMois">
                      <?php
                      foreach ($lesMois as $unMois) {
                          $mois = $unMois['mois'];
                          $numAnnee = $unMois['numAnnee'];
                          $numMois = $unMois['numMois'];

                          if ($mois == $moisASelectionner) {
                              ?>
                              <option selected value="<?php echo $mois ?>">
                                  <?php echo $numMois . "/" . $numAnnee ?> </option>
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
              </p>
          </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider"  />
        <input id="annuler" type="reset" value="Effacer"  />
      </p> 
      </div>
        
      </form>
      
		
	</div>
	<!-- fin v_listeMois -->