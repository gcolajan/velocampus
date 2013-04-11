<h1>Ajouter un local</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter un local</legend>

	<?php echo $message; ?>

	<?php echo form_label('Local', 'local'); ?>
	<?php echo form_input($local);?>
	<br />

	<?php echo form_label('Adresse', 'adresse'); ?>
	<?php echo form_input($adresse);?>
	<br />
	
	<?php echo form_label('Campus', 'campus'); ?>
	<?php echo form_dropdown('campus', $listeCampus, 0); ?>
	<br />
	
	<?php echo form_label('Ville', 'ville'); ?>
	<?php echo form_dropdown('ville', $listeVille, 0); ?>
	<br />
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Ajouter');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('local'); ?>">Annuler</a></p>
