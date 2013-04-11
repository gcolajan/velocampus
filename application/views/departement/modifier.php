<h1>Modifier un département</h1>

<?php echo form_open();?>
<fieldset>
<legend>Modifier un département</legend>

	<?php echo $message; ?>

	<?php echo form_label('Departement', 'departement'); ?>
	<?php echo form_input($departement);?>

	<br />
	
	<?php echo form_label('Campus ', 'campus'); ?>
	<?php echo form_dropdown('campus', $listeCampus, $campus); ?>

	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Modifier');?>
	
</fieldset>
<?php echo form_close();?>


<p class="retour"><a href="<?php echo site_url('departement'); ?>">Annuler</a></p>
