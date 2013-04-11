<h1>Modifier un campus</h1>

<?php echo form_open();?>
<fieldset>
<legend>Modifier un campus</legend>

	<?php echo $message; ?>

	<?php echo form_label('Campus', 'campus'); ?>
	<?php echo form_input($campus);?>
	<br />
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Modifier');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('campus'); ?>">Annuler</a></p>
