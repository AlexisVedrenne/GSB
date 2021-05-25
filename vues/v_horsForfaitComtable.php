<br><br>
<form action="index.php?uc=validerFicheDeFrais&action=corrigerLesfraisHorsForfait" method="post" role="form">
    <div class="panel-info">      
        <div class="panel-heading">Eléments hors forfais</div>       
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Libelle</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Refus éventuelle</th>
            </tr>
            <?php
            $libelleHors = "";
            $dateHors = "";
            $montantHors = "";
            $id = "";
            foreach ($infoFraisHorsForfait as $frais) {
                $libelleHors = $frais['libelle'];
                $dateHors = $frais['date'];
                $montantHors = $frais['montant'];
                $id = $frais['id'];
                ?>      
                <tr>     
                    <td><div class="form-group">                     
                            <input type="text" id="idLibelle" 
                                   size="6" maxlength="10"
                                   name="id[<?php echo $id ?>]"
                                   value="<?php echo $libelleHors ?>" 
                                   class="form-control">
                        </div></td>
                    <td><div class="form-group">                     
                            <input type="text" id="idDate" 
                                   name="date"
                                   size="6" maxlength="10" 
                                   value="<?php echo $dateHors ?>" 
                                   class="form-control">
                        </div></td>
                    <td><div class="form-group">                     
                            <input type="text" id="idMontant"
                                   name="montant"
                                   size="6" maxlength="10" 
                                   value="<?php echo $montantHors ?>" 
                                   class="form-control">
                        </div></td>
                    <td><?php if (!empty($infoFraisHorsForfait)) { ?>

                            <div class="col-md-3">                               
                                <a href="index.php?uc=ValiderFicheDeFrais&action=supprimerFrais&idFrais=<?php echo $id ?>&mois=<?php echo $frais['date'] ?>&idVisiteur=<?php echo $_SESSION['idVisiteur'] ?> " 
                                   type="reset" class="btn btn-danger" role="button"
                                   onclick="return confirm('Voulez-vous vraiment supprimer ou reporter ce frais hors forfait?');">Supprimer</a>                                                
                            </div>                                              
                        <?php }
                        ?></td>       
                </tr>
            <?php } ?>
        </table>
    </div>
</form>
