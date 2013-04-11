<h1>Liste des statuts</h1>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<p class="ajout ajout_haut"><a href="<?php echo site_url('/statut/ajouter'); ?>">Créer un statut</a></p>

<?php if (count($statuts) > 0): ?>
<table>
	<tr>
		<th>Statut</th>
		<th>Effectif</th>
		<th style="width:80px;">Actions</th>
	</tr>
<?php
foreach ($statuts as $data):
?>
	<tr>
		<td><?php echo $data->statut_nom; ?></td>
		<td>
		<?php
			if (!isset($data->nbTotal))
				echo '0';		
			else
				echo '<a href="/locataire/index/campus/0/departement/0/statut/'.$data->statut_id.'" title="Liste des locataires de statut « '.$data->statut_nom.' »
Nombre d\'adhérents possédant un vélo sur le nombre d\'adhérents total">'.(isset($data->nbPartiel) ? $data->nbPartiel : '0').' / '.$data->nbTotal.'</a>';
		?>
		</td>
		<td>
			<a href="<?php echo site_url('statut/modifier/'.$data->statut_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
			&nbsp;
			<?php if ($data->nbTotal == 0) : ?>
			<a href="<?php echo site_url('statut/supprimer/'.$data->statut_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le statut « <?php echo $data->statut_nom; ?> »');" title="Confirmation via JS">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
			<?php else: ?>
			<img src="/assets/images/nodel.png" alt="-" title="Impossible de supprimer" />
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<p class="italic">Pour être supprimé, un statut ne doit pas être utilisé.</p>

<?php else: ?>
<p>Aucun statut à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('/statut/ajouter'); ?>">Créer un statut</a></p>
