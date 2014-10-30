
<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait
       </caption>
             <tr>
                <th class="date">Date</th>
				<th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th>&nbsp;</th>              
             </tr>
          
    <?php    
	    foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
		{
			$libelle = $unFraisHorsForfait['libelle'];
			$date = $unFraisHorsForfait['date'];
			$montant=$unFraisHorsForfait['montant'];
			$id = $unFraisHorsForfait['id'];
	?>		
            <tr>
                <td> <?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
				onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
             </tr>
	<?php		 
          
          }
	?>	  
                                          
    </table>
      <form action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
      <div class="corpsForm">
         
          <fieldset>
            <legend>Nouvel élément hors forfait
            </legend>
            <p>
              <label >Date (jj/mm/aaaa): </label>
              <input type="text"  name="dateFrais" size="10" maxlength="10"
                     value="" required/>
            </p>
            <p>
              <label >Libellé</label>
              <input type="text"  name="libelle" size="70" maxlength="256" 
                     value="" required/>
            </p>
            <p>
              <label >Montant : </label>
              <input type="text"  name="montant" size="10" maxlength="10" 
                     value="" required/>
            </p>
          </fieldset>
      </div>
      <div >
      <p>
        <input id="ajouter" type="submit" value="Ajouter"  />
        <input id="effacer" type="reset" value="Effacer"  />
      </p> 
      </div>
        
      </form>
  </div>
  

