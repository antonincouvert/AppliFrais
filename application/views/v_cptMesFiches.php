<?php
	$this->load->helper('url');
?>
<div id="contenu">
	<h2>Liste de mes fiches de frais</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >Visiteurs</th> 
				<th >Mois</th> 
				<th >Montant</th>  
				<th >Date modif.</th>
				<th  colspan="4">Actions</th>              
			</tr>
		</thead>
	<tbody>
          
		<?php    
			foreach( $listeFiches as $uneFiche) 
			{
				$ValiderFiche= '';
				$RefuserFiche= '';

				if ($uneFiche['id'] == 'CL') {
					$ValiderFiche= anchor('c_comptable/ValiderFiche/'.$uneFiche['mois'], 'Valider',  'title="Valider la fiche"');
					$RefuserFiche= anchor('c_comptable/RefuserFiche/'.$uneFiche['mois'], 'Refuser',  'title="Refuser la fiche"  onclick="return confirm(\'Voulez-vous vraiment signer cette fiche ?\');"');
				}
				
				echo 
				'<tr>
					<td class="libelle">'.$uneFiche['nom'].'</td>
					<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], $uneFiche['mois'], 'title="Consulter la fiche"').'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$ValiderFiche.'</td>
					<td class="action">'.$RefuserFiche.'</td>
				</tr>';
			}
		?>	  
		</tbody>
    </table>

</div>
