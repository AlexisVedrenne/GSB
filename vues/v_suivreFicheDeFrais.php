<hr>
<div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Fiche de frais du mois 
                <?php echo $numMois . '-' . $numAnnee . ' du visiteur ' . $leVisiteur ?> : </div>
            <div class="panel-body">
                <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
                depuis le <?php echo $dateModif ?> <br> 
                <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">Eléments forfaitisés</div>
            <table class="table table-bordered table-responsive">
                <tr>
                    <?php
                    foreach ($lesFraisForfait as $unFraisForfait) {
                        $libelle = $unFraisForfait['libelle'];
                        ?>
                        <th> <?php echo htmlspecialchars($libelle) ?></th>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <?php
                    foreach ($lesFraisForfait as $unFraisForfait) {
                        $quantite = $unFraisForfait['quantite'];
                        ?>
                        <td class="qteForfait"><?php echo $quantite ?> </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">Descriptif des éléments hors forfait - 
                <?php echo $nbJustificatifs ?> justificatifs reçus</div>
            <table class="table table-bordered table-responsive">
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>
                    <th class='montant'>Montant</th>                
                </tr>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $date = $unFraisHorsForfait['date'];
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $montant = $unFraisHorsForfait['montant'];
                    ?>
                    <tr>
                        <td><?php echo $date ?></td>
                        <td><?php echo $libelle ?></td>
                        <td><?php echo $montant ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    <form action="index.php?uc=suivreFicheDeFrais&action=miseEnPaiement" 
              method="post" role="form">
        <input id="ok" type="submit" value="Mettre en paiement" class="btn btn-success" 
               role="button">
    </form>
</div>