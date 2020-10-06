<?php $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING); ?>
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
            <input id="okDate" type="submit" value="Valider" class="btn btn-success" 
                   role="button">           
        </form>
        <form action="index.php?uc=validerFicheDeFrais&action=AffichageFicheFraisAndVisiteur" method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur" class="form-control">
                    <?php
                    if (!isset($_SESSION['date'])) {
                        $date = str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
                        trim($date);
                        $_SESSION['date'] = $date;
                        $lesVisiteur = $pdo->getVisiteurFromMois($date);
                        $selectedValue = $lesVisiteur[0];
                        foreach ($lesVisiteur as $unVisiteur) {
                            $idvisi = $unVisiteur['visiteur'];
                            if ($selectedValue == $idvisi) {
                                ?><option selected value="<?php echo $unVisiteur['visiteur'] ?>"><?php echo $unVisiteur['visiteur'] ?></option>               
                            <?php } else { ?> <option value="<?php echo $idvisi ?>"><?php echo $idvisi ?></option> <?php
                            }
                        }
                    } else {
                        $lesVisiteur = $pdo->getVisiteurFromMois($date);
                        $selectedValue = $lesVisiteur[0];
                        foreach ($lesVisiteur as $unVisiteur) {
                            $idvisi = $unVisiteur['visiteur'];
                            if ($selectedValue == $idvisi) {
                                ?><option selected value="<?php echo $unVisiteur['visiteur'] ?>"><?php echo $unVisiteur['visiteur'] ?></option>               
                            <?php } else { ?> <option value="<?php echo $idvisi ?>"><?php echo $idvisi ?></option> <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <?php if ($action == 'selectionnerVisiteur' || $action == 'AffichageFicheFraisAndVisiteur') { ?>
                <input id="okVisiteur" type="submit" value="Valider" class="btn btn-success" 
                       role="button">
                   <?php } ?>

        </form>
    </div>
    <?php if ($action == 'AffichageFicheFraisAndVisiteur') { ?>
        <div class="panel panel-info">
            <div class="panel-heading">Eléments forfaitisés</div>
            <table class="table table-bordered table-responsive">
                <tr>

                </tr>
                <tr>                
                </tr>
            </table>
        </div>
    <?php } ?>
</div>