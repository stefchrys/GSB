<!--debut v_listeFraishorsForfait -->
<div class="row clearfix"  >
    <div class="col-md-2 column">		
    </div>
    <div class="col-md-8 column contenu">
        <h3 >
            <span class="label label-success"> 
                Descriptif des éléments hors forfaits .
            </span>
        </h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>
                        <span class="label label-info">Date</span>
                    </th>
                    <th>
                        <span class="label label-info">Libellé</span>

                    </th>
                    <th>
                        <span class="label label-info">Montant</span>
                    </th>
                    <th>
                        &nbsp
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $libelle = $unFraisHorsForfait['libelle'];
                    //formater les retour chariots eventuels sur le libelle
                    $char = 30;
                    if (strlen($libelle) > $char) {
                        $libelle = retourChariot($libelle, $char);
                    }
                    $date = $unFraisHorsForfait['date'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id'];
                    ?>	
                    <tr class="success">
                        <td>
                            <?php echo $date ?>
                        </td>
                        <td>
                            <?php echo $libelle ?>
                        </td>
                        <td>
                            <?php echo $montant ?>
                        </td>

                        <td>
                            <a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                               onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">
                                Supprimer ce frais
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <form class="form-horizontal contenu" role="form" 
              action="index.php?uc=gererFrais&action=validerCreationFrais" 
              method="post">
            <fieldset>
                <legend>Nouvel élément hors-forfait.
                </legend>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">
                        Date<br />(jj/mm/aaaa):</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="dateFrais" type="text" 
                               value ="" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">
                        Libelle
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" name="libelle" type="text" 
                               value ="" required/>						
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">
                        Montant
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" name="montant" type="text" 
                               value ="" required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="col-md-2 column"></div>
</div>
<!--fin v_listeFraishorsForfait -->