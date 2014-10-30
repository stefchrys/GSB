
<h3>Ajouter un nouveau frais hors forfait</h3>
<form method='POST' action='index.php?uc=gererFrais&action=validerCreationFrais'>
    <table >
        <tr>
            <td>Date du frais (jj/mois/aaaa)</td>
            <td>
                <input  type='text' name='txt_dateFrais' size='30' 
                        maxlength='45' required>
            </td>
        </tr>
        <tr>
            <td>Description du frais</td>
            <td>
                <input  type='text' name='txt_description' size='50' 
                        maxlength='100'  required>
            </td>
        </tr>
        <tr>
            <td>Montant engage</td>
            <td>
                <input  type='text' name='txt_montant'  size='30' 
                        maxlength='45' required >
            </td>
        </tr>
        <tr>
            <td>Justificatif</td>
            <td><input type='radio' name='opt_justificatif' value='oui'> oui
            </td>
            <td>
                <input type='radio' name='opt_justificatif' value='non'> non
            </td>

        </tr>

    </table>
    <input type='submit' value='Valider' name='cmd_valider'>
    <input type='reset' value='Annuler' name='br_annuler'>

</form>
