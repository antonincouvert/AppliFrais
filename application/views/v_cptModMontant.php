<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<div class="corpsForm">
	  <?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
		<fieldset>
			<legend>Eléments forfaitisés</legend>
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					//$totalfrais =0;
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
					$montant = $unFrais['montant'];
					//$total =  $quantite * $montant;
					//$totalfrais = $total + $totalfrais;
					
					
					echo
					'<tr>
						<td><form action="'.base_url('c_comptable/modifMontantFrais/'.$mois.'/'.$idVisiteur.'/'.$idFrais).'" method="post" class="flotant"></td>
						<td><label for="'.$idFrais.'">'.$libelle.' : '. $quantite.'</label> <input type="number" step="0.01" value="'.$montant.'" min="0" name = "'.$idFrais.'"></input></td>
						<td><input type="submit" value = "Modifier le montant" /></td>
						</form>
					</tr>';
				}
			?>
		</fieldset>
		<p></p>
	</div>  

	 
	<table class="listeLegere">
		<caption>Descriptif des éléments hors forfait</caption>
		<tr>
			<th >Date</th>
			<th >Libellé</th>  
			<th >Montant</th>             
		</tr>
          
		<?php    
			foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
			{
				$libelle = $unFraisHorsForfait['libelle'];
				$date = $unFraisHorsForfait['date'];
				$montant=$unFraisHorsForfait['montant'];
				$id = $unFraisHorsForfait['id'];
				echo 
				'<tr>
					<td class="date">'.$date.'</td>
					<td class="libelle">'.$libelle.'</td>
					<td class="montant">'.$montant.'</td>
				</tr>';
			}
		?>	  
                                          
    </table>

</div>