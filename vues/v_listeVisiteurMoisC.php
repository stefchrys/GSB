<!--  debut v_listeMois -->

<div class="col-md-8 column">
    <div class="contenu">
        <h3>Choix fiche (Visiteur/Mois)</h3>
        <h4>Visiteur à sélectionner : </h4>
        <form action="index.php?uc=validerFrais&action=validerChoixVisiteurMois" method="post">
            <table>
                <div>
                    <th>
                    <p>
                        <label for="nom" accesskey="n">Mois : </label>
                        <select id="nom" name="nom">
                            <?php
                            foreach ($visiteurs as $unVisiteur) {
                                $nom = $unVisiteur['nom'];
                                $prenom = $unVisiteur['prenom'];
                                ?>
                                <option  value="<?php echo $nom ?>">
                                    <?php echo $nom . " " . $prenom ?> </option>
                                <?php
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
                                $mois = $uneDate['mois'];
                                $annee = $uneDate['annee'];
                                ?>
                                <option  value="<?php echo $mois ?>">
                                    <?php echo $mois . "/" . $annee ?> </option>
                                <?php
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
