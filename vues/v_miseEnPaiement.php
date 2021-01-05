<hr>
<div class="row">
    <div class="panel panel-primary">
            <div class="panel-heading">Fiche de frais du visiteur <?php echo $_SESSION["visiteurSuvie"] . ' du ' . $numMois . '-' . $numAnnee . " mise en paiement avec succès."?>
            </div>
            <div class="panel-body">
                <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
                depuis le <?php echo $dateModif ?> <br> 
                <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
            </div>
</div>