<h1>Liste des vélos</h1>

<p class="ajout ajout_haut"><a href="<?php echo site_url('velo/creer_velo'); ?>">Créer un vélo</a></p>

<fieldset>
	<legend>Filtrage</legend>

	<?php echo form_label('Local', 'triLocaux'); ?>
	<?php echo form_dropdown('triLocaux', $listeLocaux, $this->uri->rsegment(4), 'id="triLocaux"'); ?>
	<br />

	<?php echo form_label('Loué', 'triLoue'); ?>
	<?php echo form_dropdown('triLoue', $listeLoue, $this->uri->rsegment(8), 'id="triLoue"'); ?>
	<br />
	
	<?php echo form_label('Modèle', 'triModele'); ?>
	<?php echo form_dropdown('triModele', $listeModele, $this->uri->rsegment(6), 'id="triModele"'); ?>
	<br />
	<br />
	
	<?php echo form_label('', ''); ?>
    
    <input type="button" value="Filtrer" onclick="document.location = '/velo/index/local/' + document.getElementById('triLocaux').value + '/modele/' + document.getElementById('triModele').value + '/location/' + document.getElementById('triLoue').value" />
	<input type="button" value="Supprimer tous les filtres" onclick="document.location = '/velo/'" />
	
 </fieldset>
 
<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<?php if (count($velos) > 0): ?> 
<table>
	<tr>
	    <th>Numéro</th> 
		<th>Modèle</th>
		<th>Local</th>
		<th>Date d'achat</th>
		<th style="width:80px;">Actions</th>
	</tr>
	
<?php
foreach ($velos as $data):
$ex = explode('-', $data->velo_date_achat);
$tableauMois = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
$date = $tableauMois[$ex[1]-1].' '.$ex[0];
?>
	<tr>
	    <td><a href="<?php echo site_url('velo/ficheVelo/'.$data->velo_id); ?>"><?php echo $data->velo_id; ?></a></td>
		<td><?php echo $data->modele_nom; ?></a></td>
		<td><?php echo $data->local_nom; ?></td>
		<td><?php echo $date;  ?></td>
		<td>
			<a href="<?php echo site_url('velo/modifVelo/'.$data->velo_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
			&nbsp;
			<a href="<?php echo site_url('velo/supprVelo/'.$data->velo_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le velo « <?php echo $data->velo_id; ?> »');">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php else: ?>
<p>Aucun vélo à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('velo/creer_velo'); ?>">Créer un vélo</a></p>
