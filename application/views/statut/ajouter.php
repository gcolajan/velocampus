<h1>Créer un statut</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter un statut</legend>

	<?php echo $message; ?>

	<?php echo form_label('Statut', 'statut'); ?>
	<?php echo form_input($statut);?>
	<br />
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Ajouter');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('statut'); ?>">Annuler</a></p>
