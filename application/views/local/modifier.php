<h1>Modifier un local</h1>

<?php echo form_open();?>
<fieldset>
<legend>Modifier un local</legend>

	<?php echo $message; ?>

	<?php echo form_label('Local', 'local'); ?>
	<?php echo form_input($local);?>
	<br />

	<?php echo form_label('Adresse', 'adresse'); ?>
	<?php echo form_input($adresse);?>
	<br />
	
	<?php echo form_label('Campus', 'campus'); ?>
	<?php echo form_dropdown('campus', $listeCampus, $campus); ?>
	<br />
	
	<?php echo form_label('Ville', 'ville'); ?>
	<?php echo form_dropdown('ville', $listeVille, $ville); ?>


	<br />
	<?php echo form_label(''); ?>
	<?php echo form_submit('submit', 'Modifier');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('local'); ?>">Annuler</a></p>
