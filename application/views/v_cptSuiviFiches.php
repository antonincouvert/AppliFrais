<?php
	$this->load->helper('url');
?>
<div id="contenu">
	<h2>Suivi du paiement des fiches de frais</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >Visiteurs</th> 
				<th >Mois</th> 
				<th >Etat</th>
				<th >Montant</th>  
				<th >Date modif.</th>
				<th  colspan="4">Actions</th>              
			</tr>
		</thead>
	<tbody>
          
		<?php    
			foreach( $suiviFiches as $uneFiche) 
			{
				$modLink= '';
				$MisePaiementLink= '';
				$RembourserLink= '';

				if ($uneFiche['id'] == 'VA') {
					$modLink = anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'voir',  'title="Voir la fiche"');
					$MisePaiementLink= anchor('c_comptable/MisePaiementFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois'], 'Paiement',  'title="Mise en paiement de la fiche"  onclick="return confirm(\'Voulez-vous vraiment mettre en paiement la fiche ?\');"');
				}
				
				else if ($uneFiche['id'] == 'MP') {
					$modLink = anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'voir',  'title="Voir la fiche"');
					$RembourserLink= anchor('c_comptable/RembourserFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois'], 'Remboursement',  'title="Remboursement de la fiche"  onclick="return confirm(\'Voulez-vous vraiment rembourser cette fiche ?\');"');	
				}
				
				else {
					$modLink = anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'voir',  'title="Voir la fiche"');
				}
				
				echo
				'<tr>
					<td class="libelle">'.$uneFiche['nom'].'</td>
					<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], $uneFiche['mois'], 'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$modLink.'</td>
                    <td class="action">'.$MisePaiementLink.'</td>
					<td class="action">'.$RembourserLink.'</td>                    
                </tr>';
			}
		?>	  
		</tbody>
    </table>

</div>
