<h1>Ajouter un modèle de vélo</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter un modèle de vélo</legend>

	<?php echo $message; ?>

	<?php echo form_label('Modèle', 'modele'); ?>
	<?php echo form_input($modele);?>
	<br />
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Ajouter');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('modele'); ?>">Annuler</a></p>
