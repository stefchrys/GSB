<div class="row">
    <div class="col-md-2 column contenu" >
    </div >
    <div class="col-md-2 column contenu" >

        <div class ="erreur">
            <ul>
                <?php 
                $tab = $_REQUEST['erreurs']; 
                foreach($tab as $el){
                    echo"<script>alert('".$el."');</script>";
                }             
                ?>            
            </ul>
        </div>
    </div>
    <div class="col-md-2 column contenu" >
    </div >
</div>
