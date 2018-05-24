<?php
	$this->load->helper('url');
?>
<div id="contenu">
	<h2>Validation des fiches de frais</h2>
	 	
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
			foreach( $listeFiches as $uneFiche) 
			{
				$modLink= '';
				$ValiderLink= '';
				$RefuserLink= '';

				if ($uneFiche['id'] == 'CL') {
					$modLink = anchor('c_comptable/modMontantFrais/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'voir',  'title="Voir la fiche"');
					$ValiderLink= anchor('c_comptable/ValiderFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois'], 'Valider',  'title="Valider la fiche"  onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');
					$RefuserLink= anchor('c_comptable/RefuserFiche/'.$uneFiche['idVisiteur'].'/'.$uneFiche['mois'], 'Refuser',  'title="Refuser la fiche"  onclick="return confirm(\'Voulez-vous vraiment refuser cette fiche ?\');"');
				}
				else {
					$modLink = anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'voir',  'title="Voir la fiche"');
				}
				
				
				echo
				'<tr>
					<td class="libelle">'.$uneFiche['nom'].'</td>
					<td class="date">'.anchor('c_comptable/modMontantFrais/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], $uneFiche['mois'], 'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$modLink.'</td>
                    <td class="action">'.$ValiderLink.'</td>
					<td class="action">'.$RefuserLink.'</td>                    
                </tr>';
			}
		?>	  
		</tbody>
    </table>

</div>
