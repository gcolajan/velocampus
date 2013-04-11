<h1>Liste des locataires</h1>

<p class="ajout ajout_haut"><a href="<?php echo site_url('/locataire/ajouter'); ?>">Créer un locataire</a></p>

<fieldset>
	<legend>Filtrage</legend>
	
	<?php echo form_label('Campus', 'triCampus'); ?>
	<?php echo form_dropdown('triCampus', $listeCampus, $this->uri->rsegment(4), 'id="triCampus"'); ?>
	<br />

	<?php echo form_label('Département', 'triDept'); ?>
	<?php echo form_dropdown('triDept', $listeDept, $this->uri->rsegment(6), 'id="triDept"'); ?>
	<br />
	
	<?php echo form_label('Statut', 'triStatut'); ?>
	<?php echo form_dropdown('triStatut', $listeStatut, $this->uri->rsegment(8), 'id="triStatut"'); ?>
	<br />
	
	<?php echo form_label('Possession', 'triPossession'); ?>
	<?php echo form_dropdown('triPossession', $listePossession, $this->uri->rsegment(10), 'id="triPossession"'); ?>
	<br />
	<br />
	
	<?php echo form_label('', ''); ?>
			
	<input type="button" value="Filtrer" onclick="document.location = '/locataire/index/campus/' + document.getElementById('triCampus').value + '/departement/' + document.getElementById('triDept').value + '/statut/' + document.getElementById('triStatut').value + '/possession/' + document.getElementById('triPossession').value" />
	<input type="button" value="Supprimer tous les filtres" onclick="document.location = '/locataire/'" />
</fieldset>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<?php if (count($locataires) > 0): ?>
<table>
	<tr>
		<th>Locataire</th>
		<th>Ville</th>
		<th>Département</th>
		<th>Statut</th>
		<th>Vélo</th>
		<th style="width:80px;">Actions</th>
	</tr>
<?php
$traceur = NULL;
foreach ($locataires as $data):
if ($traceur != $data->loc_id):

?>
	<tr>
		<td><a href="/locataire/desc/<?php echo $data->loc_id; ?>" title="locataire « <?php echo $data->loc_nom; ?> »"><h style="text-transform: uppercase"><?php echo  $data->loc_nom ; ?></h> <?php echo $data->loc_prenom; ?></td>
		
		<td title="Campus : <?php echo $data->campus_nom; ?>"><?php echo $data->ville_nom; ?></td>
		
		<td title="Campus : <?php echo $data->campus_nom; ?>"><?php echo $data->dept_nom; ?></td>
		
		<td><?php echo $data->statut_nom; ?></td>

		<td>
			<?php
					if (!isset($data->loue_date_rendu_effective) AND $data->nbLoc > 0)
						echo '<a href="/velo/ficheVelo/'.$data->velo_id.'" title="Consulter la fiche du vélo n°'.$data->velo_id.'">'.$data->modele_nom.' '.$data->annee_achat.'</a>'; 
					else 
						echo '-'; 
				
			?></td>
		<td>
			<a href="<?php echo site_url('locataire/modifier/'.$data->loc_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
			&nbsp;
			<a href="<?php echo site_url('locataire/supprimer/'.$data->loc_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le locataire « <?php echo $data->loc_nom; ?> » ?');" title="Confirmation via JS">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
		</td>
	</tr>
<?php 
endif;
$traceur = $data->loc_id;
endforeach; ?>
</table>

<?php else: ?>
<p>Aucun locataire à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('/locataire/ajouter'); ?>">Créer un locataire</a></p>
