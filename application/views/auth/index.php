<h1>Authentification</h1>

<p>Vous devez obligatoirement vous authentifier pour accèder à ce site.</p>

<?php echo form_open();?>
<fieldset>
<legend>Authentification</legend>

	<?php echo $message; ?>

	<?php echo form_label('Identité', 'id'); ?>
	<select name="id" id="id">
		<option value="admin">Administrateur</option>
		<option value="sadmin">Super Administrateur</option>
	</select>
	<br />
	
	<?php echo form_label('Mot de passe', 'mdp'); ?>
	<?php echo form_input($mdp);?>
	<br />
	
	<?php echo form_input($redirection);?>
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'S\'authentifier');?>

</fieldset>
<?php echo form_close();?>
