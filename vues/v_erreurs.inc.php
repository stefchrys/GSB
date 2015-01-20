<div class="row">
    <div class="col-md-2 column contenu" >
    </div >
    <div class="col-md-2 column contenu" >

        <div class ="erreur">
            <ul>
                <?php
                foreach ($_REQUEST['erreurs'] as $erreur) {
                    echo "<li>$erreur</li>";
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-md-2 column contenu" >
    </div >
</div>
