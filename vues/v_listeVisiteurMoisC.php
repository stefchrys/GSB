<!--  debut v_listeVisiteursMoisC -->

<div class="col-md-8 column">
    <div class="contenu">
        <h3>Choix fiche (Visiteur/Mois)</h3>
        <h4>Visiteur à sélectionner : </h4>
        <form action="index.php?uc=validerFrais&action=validerChoixVisiteurMois" method="post">
            <table>
                <div>
                    <th>
                    <p>
                        <label for="nom" accesskey="n">Visiteurs : </label>
                        <select id="visiteur" name="visiteur">
                            <?php
                            foreach ($visiteurs as $unVisiteur) {
                                $nom = $unVisiteur['nom'];
                                $prenom = $unVisiteur['prenom'];
                                $idVisiteur = $unVisiteur['id'];
                                if ($idVisiteur == $visiteurASelectionner) {
                                    ?>
                                    <option selected value="<?php echo $idVisiteur ?>">
                                        <?php echo $nom . " " . $prenom ?> </option>
                                    <?php
                                } else {
                                    ?> 
                                    <option  value="<?php echo $idVisiteur ?>">  
                                        <?php echo $nom . " " . $prenom ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </p>
                    </th>
                    <th>
                    <p>
                        <label for="nom" accesskey="n">Mois : </label>
                        <select id="mois" name="mois">
                            <?php
                            foreach ($tableauDate as $uneDate) {
                                $date = $uneDate['date'];
                                $numAnnee = $uneDate['numAnnee'];
                                $numMois = $uneDate['numMois'];
                                if ($date == $dateASelectionner) {
                                    ?>
                                    <option selected value="<?php echo $date ?>">
                                        <?php echo $numMois . "/" . $numAnnee ?></option> 
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $date ?>">
                                        <?php echo $numMois . "/" . $numAnnee ?></option>
                                    <?php
                                }
                            }
                            ?>    
                        </select>
                    </p>
                    </th>
                </div>
            </table>
            <div class="piedForm">
                <p>
                    <input id="ok" type="submit" value="Valider"  />
                    <input id="annuler" type="reset" value="Effacer"  />
                </p> 
            </div>
        </form>
    </div>
    <!--  fin v_listeVisiteursMoisC -->