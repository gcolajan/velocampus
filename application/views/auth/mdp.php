<h1>Modifier les mots de passe</h1>

<p>Sélectionnez l'utilisateur concerné et insérer deux fois le nouveau mot de passe.</p>

<?php echo form_open();?>
<fieldset>
<legend>Authentification</legend>

	<?php echo $message; ?>

	<?php echo form_label('Utilisateur', 'id'); ?>
	<select name="id" id="id">
		<option value="admin">Administrateur</option>
		<option value="sadmin">Super Administrateur</option>
	</select>
	<br />
	
	<?php echo form_label('Mot de passe', 'mdp'); ?>
	<?php echo form_input($mdp);?>
	<br />

	<?php echo form_label('Confirmation', 'cmdp'); ?>
	<?php echo form_input($cmdp);?>
	<br />
		
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Modifier');?>

</fieldset>
<?php echo form_close();?>
