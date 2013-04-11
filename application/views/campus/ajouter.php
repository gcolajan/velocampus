<h1>Créer un campus</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter un campus</legend>

	<?php echo $message; ?>

	<?php echo form_label('Campus', 'campus'); ?>
	<?php echo form_input($statut);?>
	<br />
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Ajouter');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('campus'); ?>">Annuler</a></p>
