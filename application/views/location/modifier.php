<h1>Modifier une location</h1>

<?php echo form_open();?>
<fieldset>
	<legend>Propriétés de la location</legend>
	<?php echo $message; ?>

	<?php echo form_label('Vélo', 'identifiant_velo'); ?>
	<select name="identifiant_velo" id="identifiant_velo">
	<?php
		foreach ($identifiant_velo_actuel as $dataActuel)
			echo '<option value="'.$dataActuel->velo_id.'" selected="selected">
				#'.$dataActuel->velo_id.' - '.$dataActuel->modele_nom.' '.mdate('%Y', mysql_to_unix($dataActuel->velo_date_achat)).' ('.$dataActuel->local_nom.')</option>';

		$traceur=NULL;
		foreach ($identifiant_velo as $data)
		{
			if ($traceur != $data->velo_id && ($data->nbLoc==0 || ( $data->nbLoc>0 and isset($data->loue_date_rendu_effective))))
			{
				echo '<option value="'.$data->velo_id.'">
					#'.$data->velo_id.' - '.$data->modele_nom.' '.mdate('%Y', mysql_to_unix($data->velo_date_achat)).' ('.$data->local_nom.')</option>';
			}
			$traceur=$data->velo_id;

		}
	?>
	</select>
	<br />

	<?php echo form_label('Locataire', 'identifiant_locataire'); ?>
	<select name="identifiant_locataire" id="identifiant_locataire">
		<?php foreach ($identifiant_locataire as $data): ?>
			<?php if ($this->uri->rsegment(3) == $data->loc_id): ?>
				<option value="<?php echo $data->loc_id ?>" selected="selected"><?php echo strtoupper($data->loc_nom) ?> <?php echo $data->loc_prenom ?></option>
			<?php else: ?>
				<option value="<?php echo $data->loc_id ?>"><?php echo strtoupper($data->loc_nom) ?> <?php echo $data->loc_prenom ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>

	<br />
	<?php echo form_label('Date de location', 'location_date_debut_jour_location'); ?>
	<?php echo form_input($location_date_debut_jour_location);?>
	<?php echo form_input($location_date_debut_mois_location);?>
	<?php echo form_input($location_date_debut_annee_location);?>
	<br />

</fieldset>
<br />
<fieldset>
<legend>Modifier la location</legend>


	<?php echo form_label('Cadenas', 'location_cadenas1'); ?>
	<?php echo form_input($location_cadenas1);?>
	<?php echo form_input($location_cadenas2);?>
	<?php echo form_input($location_cadenas3);?>
	<br />

	<?php echo form_label('Durée (en jours)', 'location_duree_theorique'); ?>
	<?php echo form_input($location_duree_theorique);?>
	<br />

	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Modifier');?>
	<br />

</fieldset>

<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('location'); ?>">Annuler</a></p>
