<h1>Liste des campus</h1>

<p class="ajout ajout_haut"><a href="<?php echo site_url('/campus/ajouter'); ?>">Créer un campus</a></p>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<?php if (count($campus) > 0) : ?>
<table>
	<tr>
		<th>Campus</th>
		<th>Effectif</th>
		<th>Locaux</th>
		<th>Départements</th>
		<th style="width:80px;">Actions</th>
	</tr>
<?php
foreach ($campus as $data):
?>
	<tr>
		<td><?php echo $data->campus_nom; ?></td>
		<?php
		if(!isset($data->effectif))
			echo' <td>0</td>';
		else
			echo '<td><a href="/locataire/index/campus/'.$data->campus_id.'" title="Liste des locataires du campus « '.$data->campus_nom.' »">'.$data->effectif.'</a></td>';
		
		
		if(!isset($data->locaux))
			echo' <td>0</td>';
		else
			echo '<td><a href="/local/index/campus/'.$data->campus_id.'" title="Liste des locaux du campus « '.$data->campus_nom.' »">'.$data->locaux.'</a></td>';

		
		if($data->nbDept == 0)
			echo' <td>0</td>';
		else
			echo '<td><a href="/departement/index/campus/'.$data->campus_id.'" title="Liste des départements du campus « '.$data->campus_nom.' »">'.$data->nbDept.'</a></td>';
		?>
		<td>
			<a href="<?php echo site_url('campus/modifier/'.$data->campus_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
			&nbsp;
			<?php if ($data->effectif == 0 && $data->locaux == 0 && $data->nbDept == 0): ?>
			<a href="<?php echo site_url('campus/supprimer/'.$data->campus_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le campus « <?php echo $data->campus_nom; ?> »');">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
			<?php else: ?>
			<img src="/assets/images/nodel.png" alt="-" title="Impossible de supprimer" />
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<p class="italic">Vous ne pouvez supprimer un campus que si son effectif est nul, qu'aucun local n'y fait référence et qu'il ne contienne aucun département universitaire.</p>

<?php else: ?>
<p>Aucun campus à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('/campus/ajouter'); ?>">Créer un campus</a></p>
