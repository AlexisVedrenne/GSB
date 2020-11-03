
<h2>Fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois et un visiteur : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=voirEtatFrais" 
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
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    
                </select>
            </div>
            <div class="form-group">
                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur" class="form-control">
                    <?php                   
                    $lesVisiteur = $pdo->getVisiteurFromMois('202010');                   
                    foreach ($lesVisiteur as $unVisiteur) {
                        $idVisiteur = $unVisiteur;
                        ?>                       
                        <option value="<?php echo $idVisiteur ?>"> <?php echo $idVisiteur ?></option>
                        <?php
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