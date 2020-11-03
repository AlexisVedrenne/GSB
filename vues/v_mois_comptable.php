
<h2>Fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois et un visiteur : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=validerFicheDeFrais&action=selectionnerVisiteur" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionne) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                            <?php echo $numAnnee . '/' . $numMois ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                            <?php echo $numAnnee . '/' . $numMois ?> </option>
                            <?php
                        }
                    }
                    ?>    
                </select>
            </div>                    
            <input id="okDate" type="submit" value="Valider" class="btn btn-success" 
                   role="button">           
        </form>
    </div>                      
</div>