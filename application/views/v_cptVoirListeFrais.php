<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Modifier une fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<div class="corpsForm">
	  
		
		<fieldset>
			<table>
				<thead>
					<th></th><th>Quantité</th><th>Montant*</th><th>Total</th>
				</thead>
				<tbody>
					<?php
					$totalfrais =0;
					foreach ( $lesFraisForfait as $unFrais ) {
						$idFrais = $unFrais ['idfrais'];
						$libelle = $unFrais ['libelle'];
						$quantite = $unFrais ['quantite'];
						$montant = $unFrais ['montant'];
						$total =  $quantite * $montant;
						$totalfrais = $total + $totalfrais;
						
						
						echo '<tr>
									
									<td><label for="' . $idFrais . '">' . $libelle . '</label></td>
									<td><type="text" id="' . $idFrais . '" name="lesFrais[' . $idFrais . ']" class="input" size="10" maxlength="5" value="' . $quantite . '" />' . $quantite .'</td>
									<td><input type="text" id="'.$idFrais.'" name="lesFrais['.$montant.']" size="10" maxlength="5" value="'.$montant.'" />
									<td id="total'.$idFrais.'">'.$total.'</td>

							</tr>
							';
					}
					
					echo '<tr> 
								<td></td><td></td><td>Total frais forfaitisés</td><td id="totalfrais'.$idFrais.'">'.$totalfrais.'</td>
						 </tr>'
					
				?>
				</tbody>
			</table>
		</fieldset>
		
		
		<p></p>
	</div>

	
	<table class="listeLegere">
		<caption>Descriptif des éléments hors forfait</caption>
		<tr>
			<th >Date</th>
			<th >Libellé</th>  
			<th >Montant</th>  
			<th >&nbsp;</th>              
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
					<td class="action">'.
					anchor(	"c_visiteur/supprFrais/$id", 
							"Supprimer ce frais", 
							'title="Suppression d\'une ligne de frais" onclick="return confirm(\'Voulez-vous vraiment supprimer ce frais ?\');"'
						).
					'</td>
				</tr>';
			}
		?>	  
                                          
    </table>

</div>
