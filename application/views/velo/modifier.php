<h1>Modifier un vélo</h1>

<?php echo form_open();?>
<fieldset>
<legend>Modifier un vélo</legend>

	<?php echo $message; ?>
	
	<?php echo form_label('Date d\'achat', 'achat_jour'); ?>
	<?php echo form_input($achat_jour);?>
	<?php echo form_input($achat_mois);?>
	<?php echo form_input($achat_annee);?>
	<br />
	<br />
	
	<?php echo form_label('Suivi', 'suivi_entier'); ?>
	<?php echo form_textarea($suivi_entier); ?>
	<?php echo form_label('Commentaire ', 'suivi_commentaire'); ?>
	<?php echo form_input($suivi_date); ?>
	<?php echo form_input($suivi_commentaire); ?>
	<br />
	<br />
	
	<?php echo form_label('Observations', 'obs_entier'); ?>
	<?php echo form_textarea($obs_entier); ?>
	<?php echo form_label('Commentaire', 'obs_commentaire'); ?>
	<?php echo form_input($obs_date); ?>
	<?php echo form_input($obs_commentaire); ?>
	<br />
	<br />
	
	<?php echo form_label('Modèle ', 'modele'); ?>
	<?php echo form_dropdown('modele', $modeles, $modele); ?>
	
	<br />	
	
	<?php echo form_label('Local ', 'local'); ?>
	<?php echo form_dropdown('local', $locaux, $local); ?>
	<br />
	<br />
	
	<?php echo form_label('', ''); ?>
	<?php echo form_submit('submit', 'Modifier');?>
	<br />

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('velo'); ?>">Annuler</a></p>
