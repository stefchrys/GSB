﻿<div id="contenu">
    <h2>Identification utilisateur</h2>


    <form method="POST" action="index.php?uc=connexion&action=valideConnexion">


        <p>
            <label for="nom">Login*</label>
            <input id="login" type="text" name="txt_login"  size="30" maxlength="45">
        </p>
        <p>
            <label for="mdp">Mot de passe*</label>
            <input id="mdp"  type="password"  name="txt_mdp" size="30" maxlength="45">
        </p>
        <input type="submit" value="Valider" name="cmd_valider">
        <input type="reset" value="Annuler" name="br_annuler"> 
        </p>
    </form>

</div>