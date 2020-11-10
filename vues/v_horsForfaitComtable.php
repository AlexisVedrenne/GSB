<br><br>
<div class="panel-info">
    <div class="panel-heading">Eléments hors forfais</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>Libelle</th>
            <th>Date</th>
            <th>Montant</th>
            <th>Correction éventuelle</th>
        </tr>
        <?php
        $libelleHors = "";
        $dateHors = "";
        $montantHors = "";            
        foreach ($infoFraisHorsForfait as $frais) {          
            $libelleHors = $frais['libelle'];
            $dateHors = $frais['date'];
            $montantHors = $frais['montant'];
            ?>      
        <tr>     
                    <td><div class="form-group">                     
                            <input type="text" id="idQuantite" 
                                   size="10" maxlength="5" 
                                   value="<?php echo $libelleHors ?>" 
                                   class="form-control">
                        </div></td>
                    <td><div class="form-group">                     
                            <input type="text" id="idQuantite" 
                                   size="10" maxlength="5" 
                                   value="<?php echo $dateHors ?>" 
                                   class="form-control">
                        </div></td>
                    <td><div class="form-group">                     
                            <input type="text" id="idQuantite" 
                                   size="10" maxlength="5" 
                                   value="<?php echo $montantHors ?>" 
                                   class="form-control">
                        </div></td>
                    <td><?php if (!empty($infoFraisHorsForfait)) { ?>

                            <div class="col-md-3">
                                <a href="index.php?uc=validerFicheDeFrais&action=corrigerLefrais&libelle=<?php echo $libelleHors?>
                                   &date=<?php echo $dateHors?>&montant=<?php echo $montantHors?>" id="btnCorrection" class="btn btn-success">Correction</a>                                                 
                            </div>                  
                            <div class="col-md-3">
                                <a id="btnRen" class="btn btn-danger">Renitialiser</a>
                            </div>
                        <?php }
                        ?></td>       
                </tr>
        <?php } ?>
    </table>
</div>
