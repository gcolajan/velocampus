<?php echo form_open();?>
<h1> Modification d'un locataire</h1>
<fieldset>
<legend>Modifier un locataire</legend>

	<?php echo $message; ?>

	<?php echo form_label('Nom', 'nom'); ?>
	<?php echo form_input($nom);?>*
	
	<br />
	
	<?php echo form_label('Prénom', 'prenom'); ?>
	<?php echo form_input($prenom);?>*
	
	<br />
	<br />

	<?php echo form_label('Téléphone', 'tel'); ?>
	<?php echo form_input($tel);?>
	
	<br />

	<?php echo form_label('Mail', 'mail'); ?>
	<?php echo form_input($mail);?>
	
	<br />

	<?php echo form_label('Adresse', 'adresse'); ?>
	<?php echo form_input($adresse);?>
	
	<br />
	
	<?php echo form_label('Ville', 'ville'); ?>
	<?php echo form_dropdown('ville', $villes, $ville); ?>
	
	<br />
	<br />
			
	<?php echo form_label('Statut', 'statut'); ?>
	<?php echo form_dropdown('statut', $statuts, $statut); ?>*
	<br />
	
	<?php echo form_label('Département', 'departement'); ?>
	<?php echo form_dropdown('departement', $departements, $departement); ?>
	
	<br/>
	<br />
	
	<input type="hidden" name="send" value="true" />
	<?php echo form_label('&nbsp;'); ?>
	<?php echo form_submit('submit', 'Modifier');?>

</fieldset>
<?php echo form_close();?>

<p class="retour"><a href="<?php echo site_url('locataire'); ?>">Annuler</a></p>
