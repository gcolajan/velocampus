<h1>Créer un département</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter un département</legend>

	<?php echo $message; ?>

	<?php echo form_label('Département', 'departement'); ?>
	<?php echo form_input($departement);?>
	<br />
	<?php echo form_label('Campus', 'campus'); ?>
	<select name="campus" id="campus">
		<?php foreach ($campus as $data): ?>
			<?php if ($this->uri->rsegment(4) == $data->campus_id): ?>
				<option value="<?php echo $data->campus_id ?>" selected="selected"><?php echo $data->campus_nom ?></option>
			<?php else: ?>
				<option value="<?php echo $data->campus_id ?>"><?php echo $data->campus_nom ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
	
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Ajouter');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('departement'); ?>">Annuler</a></p>
