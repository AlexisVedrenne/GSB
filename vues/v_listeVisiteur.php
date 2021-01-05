    <div class="col-md-4">
        <h3>Sélectionner un visiteur : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=suivreFicheDeFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n">Visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteur as $unVisiteur) {
                        $idvisi = $unVisiteur['visiteur'];
                        if ($VisiteurASelectionner == $idvisi) {
                            ?>
                            <option selected value="<?php echo $unVisiteur['visiteur'] ?>">
                                <?php echo $unVisiteur['visiteur'] ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $idvisi ?>">
                                <?php echo $idvisi ?> </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
        </form>
    </div>