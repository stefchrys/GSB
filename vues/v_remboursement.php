                               
<!--  debut v_remboursement -->

<div class="col-md-10 column">
    <div class="contenu">
        <h3>Confirmation de remboursement </h3>              
            <table class="table table-hover">
                <thead>               
                    <th><span class="label label-info">Confirmation fiches remboursées</span></th>
                    
                </thead>
                <thbody>
               <?php 
               foreach($choix as $num){                  
                ?>               
                <tr >
                    <td>
                         <?php echo "la fiche numéro: ".$num." a été remboursée"?>;
                    </td>                   
                </tr>
               <?php } ?>
                </thbody>
            </table>
           
    </div>
</div>
</div>
<!--  fin v_remboursement -->


