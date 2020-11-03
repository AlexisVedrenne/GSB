<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2>Mes fiches à suivre</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner une fiche : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suiviFicheFrais&action=voirSuiviFicheFrais"
              method="post" role="form">
            <div class="form-group">
                <label for="1stFiche" accesskey="n">Fiches : </label>
                <select id="1stFiche" name ="1stFiche" class="form-control">
                    <?php
                    foreach ($lesFiches as $uneFiche) {
                        $etat = $uneFiche['etat'];

                        if ($etat == $fichesASelectionner) {
                            ?>
                            <option selected value="<?php echo $etat ?>">
                                <?php echo $etat ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $etat ?>">
                                <?php echo $etat ?> </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success"
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger"
                   role="button">
        </form>
    </div>
</div>
