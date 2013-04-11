<h1>Créer un vélo</h1>

<?php echo form_open();?>
<fieldset>
<legend>Ajouter un velo</legend>

	<?php echo $message; ?>
	
	<?php echo form_label('Date d\'achat', 'achat_jour'); ?>
	<?php echo form_input($achat_jour);?>
	<?php echo form_input($achat_mois);?>
	<?php echo form_input($achat_annee);?>
	
	<br />
	
	<?php echo form_label('Observations du vélo', 'observations'); ?>
	<?php echo form_input($observations);?>
	
	<br />
	
	<?php echo form_label('Modèle ', 'modele'); ?>
	<?php echo form_dropdown('modele', $modeles); ?>
	
	<br />	
	
	<?php echo form_label('Local ', 'local'); ?>
	<?php echo form_dropdown('local', $locaux); ?>
	
	<br />
	
	<?php echo form_label('', ''); ?>
	<?php echo form_submit('submit', 'Ajouter');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('velo'); ?>">Annuler</a></p>
