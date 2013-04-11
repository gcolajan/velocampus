<h1>Liste des locations</h1>

<p class="ajout ajout_haut"><a href="<?php echo site_url('location/ajouterLocation'); ?>">Créer une location</a></p>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<?php if (count($location) > 0): ?>
<table>
	<thead>
	<tr>
		<th style="width:30px;">&nbsp;</th>
		<th>Durée</th>
		<th>Début de location</th>
		<th>Locataire</th>
		<th>Vélo</th>
		<th style="width:110px;">Actions</th>
	</tr>
	</thead>
	<tbody>
<?php
foreach ($location as $data):
	$ex = explode('-', $data->loue_date_location);
	$fin_theorique = mktime(0, 0, 0, $ex[1], $ex[2]+$data->loue_duree_theorique, $ex[0]);
	$aujourdhui = time();
	if ($fin_theorique < $aujourdhui && !isset($data->loue_date_rendu_effective))
		$alarme = 'style="color:red;" title="Le vélo devrait être rendu"';
	else
		$alarme = 'title="À rendre pour le '.sql_to_human(date('Y-m-d', $fin_theorique)).'"';
	
	if ($data->loue_date_rendu_effective != NULL)
		$alarme = 'title="Rendu !" style="color:green;"';
?>
	<tr>
		<td><a href="<?php echo site_url('location/ficheLocation/'.$data->loue_loc_id.'/'.$data->loue_velo_id.'/'.$data->loue_date_location); ?>">
			<img src="/assets/images/more.png" alt="Consulter" title="Consulter" />
		</a></td>
		<td <?php echo $alarme; ?>><?php echo $data->loue_duree_theorique; ?> jours</td>
		<td><?php echo sql_to_human($data->loue_date_location);?></td>
		<td><a href="/locataire/desc/<?php echo $data->loue_loc_id; ?>"><?php echo strtoupper($data->loc_nom); ?></a></td>
		<td><a title="Consulter le vélo n°<?php echo $data->loue_velo_id; ?>" href="/velo/ficheVelo/<?php echo $data->loue_velo_id; ?>"><?php echo $data->modele_nom; ?> <?php echo $data->annee_achat; ?></a></td>
		<td>
			<?php if (!($data->loue_date_rendu_effective!=NULL)) : ?>
				<a href="<?php echo site_url('location/modifierLocation/'.$data->loue_loc_id.'/'.$data->loue_velo_id.'/'.$data->loue_date_location); ?>">
			 		<img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
				&nbsp;
			<?php endif; ?>
			
			<a href="<?php echo site_url('location/supprimerLocation/'.$data->loue_loc_id.'/'.$data->loue_velo_id.'/'.$data->loue_date_location); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la location?');">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
			&nbsp;
			<?php if ($data->loue_date_rendu_effective!=NULL) : ?>
				<a href="<?php echo site_url('location/recommencerLocation/'.$data->loue_loc_id.'/'.$data->loue_velo_id.'/'.$data->loue_date_location.'/'.$data->loue_date_rendu_effective); ?>" onclick="return confirm('Êtes-vous sûr de vouloir recommencer la location ? Attention le vélo de cette location n\'est peut-être plus disponible.');">
					<img src="/assets/images/start.png" alt="Recommencer" title="Recommencer" />
				</a>
			<?php else: ?>
				<a href="<?php echo site_url('location/arreterLocation/'.$data->loue_loc_id.'/'.$data->loue_velo_id.'/'.$data->loue_date_location); ?>" onclick="return confirm('Êtes-vous sûr de vouloir arrêter la location?');">
					<img src="/assets/images/stop.png" alt="Arrêter" title="Arrêter" />
				</a>
			<?php endif; ?>
		</td>
	</tr>
	</tbody>
<?php endforeach; ?>
</table>

<?php else: ?>
<p>Aucune location à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('location/ajouterLocation'); ?>">Créer une location</a></p>
