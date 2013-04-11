<h1>Créer une location</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter une location</legend>

	<?php echo $message; ?>
	<?php echo form_label('Vélo', 'identifiant_velo'); ?>
	<?php $traceur=NULL;?>
	<select name="identifiant_velo" id="identifiant_velo">
		<option selected="selected" disabled="disabled">[Vélos]</option>
		<?php foreach ($identifiant_velo as $data): ?>
				<?php if ($traceur!=$data->velo_id AND ($data->nbLoc==0 || ( $data->nbLoc>0 and isset($data->loue_date_rendu_effective)))): ?>		
				<option value="<?php echo $data->velo_id ?>">
					#<?php echo $data->velo_id ?> - <?php echo $data->modele_nom ?> <?php echo mdate('%Y', mysql_to_unix($data->velo_date_achat)) ?> (<?php echo $data->local_nom  ?>)</option>
				<?php endif; ?>
				<?php $traceur=$data->velo_id; ?>
		<?php endforeach; ?>
	</select>
	<br />

	<?php echo form_label('Locataire', 'identifiant_locataire'); ?>
	<select name="identifiant_locataire" id="identifiant_locataire">
		<option selected="selected" disabled="disabled">[Locataires]</option>
		<?php foreach ($identifiant_locataire as $data): ?>
				<option value="<?php echo $data->loc_id ?>"><?php echo strtoupper($data->loc_nom) ?> <?php echo $data->loc_prenom ?></option>
		<?php endforeach; ?>

	</select>

	<br />
	<?php echo form_label('Date de location', 'location_date_debut_jour_location'); ?>
	<?php echo form_input($location_date_debut_jour_location);?>
	<?php echo form_input($location_date_debut_mois_location);?>
	<?php echo form_input($location_date_debut_annee_location);?>
	<br />

	<?php echo form_label(' Cadenas', 'location_cadenas1'); ?>
	<?php echo form_input($location_cadenas1);?>
	<?php echo form_input($location_cadenas2);?>
	<?php echo form_input($location_cadenas3);?>
	<br />

	<?php echo form_label('Durée (en jours)', 'location_duree_theorique'); ?>
	<?php echo form_input($location_duree_theorique);?>
	<br />

	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Ajouter');?>
	<br />


</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('location'); ?>">Annuler</a></p>
