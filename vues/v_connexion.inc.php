<!--debut connexion -->
<div class="row clearfix"  >
    <div class="col-md-4 column">
    </div>
    <div class="col-md-4 column" id="contenu" >
        <form role="form" method="POST" 
              action="index.php?uc=connexion&action=valideConnexion">
            <h3 class='text-center'>
                Identification utilisateur .
            </h3>
            <div class="form-group" >
                <input class="form-control" id="login" 
                       type="text" name="txt_login" placeholder="Login" required>
            </div>
            <div class="form-group">
                <input class="form-control" id="mdp" 
                       type="password" name="txt_mdp" placeholder="Password"
                       required>
            </div>

            <button type="submit" class="btn btn-success">
                Valider 
                <span class="glyphicon glyphicon-ok-sign"> 
                                </span>
            </button>
        </form>
    </div>
    <div class="col-md-4 column">
    </div>
</div>
<!-- fin connexion -->