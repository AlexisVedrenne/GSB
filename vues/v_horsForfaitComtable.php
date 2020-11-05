<div class="panel-info">
    <div class="panel-heading">Eléments hors forfais</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>Libelle</th>
            <th>Date</th>
            <th>Montant</th>
        </tr>
        <?php 
            $libelleHors="";
            $dateHors="";
            $montantHors="";
        foreach ($infoFraisHorsForfait as $frais) {
            $libelleHors=$frais['libelle'];
            $dateHors=$frais['date'];
            $montantHors=$frais['montant'];       
        ?>
        <tr>
            <td><?php echo $libelleHors?></td>
            <td><?php echo $dateHors?></td>
            <td><?php echo $montantHors?></td>
        </tr>
        <?php }?>
    </table>
</div>