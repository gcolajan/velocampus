<h1>Liste des locaux</h1>

<p class="ajout ajout_haut"><a href="<?php echo site_url('/local/ajouter'); ?>">Créer un local</a></p>

<fieldset>
<legend>Filtrage</legend>
	<select name="campus" id="campus">
		<option value="">Tous les campus</option>
		<?php foreach ($campus as $data): ?>
			<?php if ($this->uri->rsegment(4) == $data->campus_id): ?>
				<option value="<?php echo $data->campus_id ?>" selected="selected"><?php echo $data->campus_nom ?></option>
			<?php else: ?>
				<option value="<?php echo $data->campus_id ?>"><?php echo $data->campus_nom ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
	
	<input type="button" value="Filtrer" onclick="document.location = '/local/index/campus/' + document.getElementById('campus').value" />
	
	<input type="button" value="Supprimer le filtre" onclick="document.location = '/local/'" />
</fieldset>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<?php if (count($local) > 0): ?>
<table>
	<tr>
		<th>Local</th>
		<th title="Quantité de vélos">Vélos</th>
		<th>Campus</th>
		<th style="width:80px;">Actions</th>
	</tr>
<?php
foreach	($local as $data):
?>
	<tr>
		<td><?php echo $data->local_nom; ?></td>
		<td><?php if($data->nbVelo !=0): ?>
			<a href="/velo/index/local/<?php echo $data->local_id; ?>" title="Liste des velos du local « <?php echo $data->local_nom; ?> »"><?php echo $data->nbVelo;?></a> 
		<?php else : ?>
			<?php echo '0' ;?>
		<?php endif;?>
		</td>
		<td title="Situé à : <?php echo $data->local_adresse; ?> (<?php echo $data->ville_nom; ?>)"><?php echo $data->campus_nom; ?></td>
		<td>
			<a href="<?php echo site_url('local/modifier/'.$data->local_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
			&nbsp;
			<?php if ($data->nbVelo == 0) : ?>
			<a href="<?php echo site_url('local/supprimer/'.$data->local_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le local « <?php echo $data->local_nom; ?> »');">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
			<?php else: ?>
			<img src="/assets/images/nodel.png" alt="-" title="Impossible de supprimer" />
			<?php endif; ?>
		</td>
	</tr>	
<?php endforeach; ?>
</table>

<p class="italic">Vous ne pouvez supprimer un local que s'il ne contient plus de vélos.</p>

<?php else: ?>
<p>Aucun local à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('/local/ajouter'); ?>">Créer un local</a></p>
