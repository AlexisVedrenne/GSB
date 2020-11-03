
<br>
<h4> Visiteur selectionné : <?php echo $idVisiteur ?></h4>
<div class="panel panel-info">
    <div class="panel-heading">Fiche</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>Date de modification</th>
            <th>Nombre de justificatifs</th>
            <th>Montant</th>
            <th>IdEtat</th>
            <th>Libelle Etat</th>
        </tr>
        <?php
        $date = $infoFicheDeFrais['dateModif'];
        $nbJustificatifs = $infoFicheDeFrais['nbJustificatifs'];
        $montant = $infoFicheDeFrais['montantValide'];
        $libelle = $infoFicheDeFrais['libEtat'];
        $idEtat = $infoFicheDeFrais['idEtat'];
        ?>
        <tr>
            <td><div class="form-group">                     
                    <input type="text" id="iddate" 
                           size="10" maxlength="5" 
                           value="<?php echo $date ?>" 
                           class="form-control">
                </div></td>
            <td><div class="form-group">                     
                    <input type="text" id="idnbJustificatif" 
                           size="10" maxlength="5" 
                           value="<?php echo $nbJustificatifs ?>" 
                           class="form-control">
                </div></td>
            <td><div class="form-group">                     
                    <input type="text" id="idMontant" 
                           size="10" maxlength="5" 
                           value="<?php echo $montant ?>" 
                           class="form-control">
                </div></td>
            <td><?php echo $idEtat ?></td>
            <td><?php echo $libelle ?></td>
        </tr>

    </table>
    <div class="panel-heading">Eléments forfaistisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>Libelle</th>
            <th>IDLibelle</th>
            <th>Quantités</th>
            <th>Prix</th>
            <th>Total</th>              
        </tr>
        <?php
        $total = 0;
        foreach ($infoFraisForfait as $frais) {
            $idLibelle = $frais['idfrais'];
            $libelleFrais = $frais['libelle'];
            $quantite = $frais['quantite'];
            $prix = $frais['prix'];
            $total += $prix * $quantite;
            ?>
            <tr>
                <td><?php echo $libelleFrais ?></td>
                <td><?php echo $idLibelle ?></td>
                <td><div class="form-group">                     
                    <input type="text" id="idQuantite" 
                           size="10" maxlength="5" 
                           value="<?php echo $quantite ?>" 
                           class="form-control">
                </div></td>
                <td><?php echo $prix ?></td>
                <td><?php echo $prix * $quantite ?></td>                   
            </tr>                            
        <?php } ?>
    </table>
    <div class="panel-heading">Coût des frais forfaits : <?php echo $total . '€' ?></div>
</div>   

