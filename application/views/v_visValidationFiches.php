<?php
$this->load->helper('url');
?>
<div id="contenu">
	<h2>Liste de mes fiches de frais</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >Mois</th>
				<th >Visiteurs</th>  
				<th >Montant</th>  
				<th >Date modif.</th>  
				<th  colspan="4">Actions</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach( $mesFiches as $uneFiche) 
			{
				$ValiderLink = '';
				$RefuserLink = '';

				if ($uneFiche['id'] == 'CR') {
					$ValiderLink = anchor('c_comptable/ValiderFiche/'.$uneFiche['mois'], 'Valider',  'title="Valider la fiche"  onclick="return confirm(\'Voulez-vous vraiment Valider cette fiche ?\');"');
					$RefuserLink = anchor('c_comptable/RefuserFiche/'.$uneFiche['mois'], 'Refuser',  'title="Refuser la fiche"  onclick="return confirm(\'Voulez-vous vraiment Refuser cette fiche ?\');"');
				}
				
				echo 
				'<tr>
					<td class="date">'.anchor('c_visiteur/voirFiche/'.$uneFiche['mois'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$ValiderLink.'</td>
					<td class="action">'.$RefuserLink.'</td>
				</tr>';
			}
		?>	  
		</tbody>
    </table>

</div>
