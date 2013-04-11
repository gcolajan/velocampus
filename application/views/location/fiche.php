<h1>Fiche location</h1>

<p style="text-align:center">
<a href="<?php echo site_url('location/supprimerLocation/'.$fiche->loue_loc_id.'/'.$fiche->loue_velo_id.'/'.$fiche->loue_date_location); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la location ?');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>
</p>

<table class="fiche">

<tr>
	<td colspan="2">Locataire</td>
</tr>
<tr>
	<td>Nom</td>
	<td><?php echo strtoupper($fiche->loc_nom) ?></td>
</tr>
<tr>
	<td>Prénom</td>
	<td><?php echo $fiche->loc_prenom ?></td>
</tr>
<tr>
	<td>Statut</td>
	<td><?php echo $fiche->statut_nom ?></td>
</tr>
<tr>
	<td>Département</td>
	<td><?php echo $fiche->dept_nom ?></td>
</tr>
<tr>
	<td>Détails</td>
	<td><a href="/locataire/desc/<?php echo $fiche->loue_loc_id; ?>">Consulter le profil du locataire</a></td>
</tr>

<tr>
	<td colspan="2">Vélo</td>
</tr>
<tr>
	<td>Identifiant</td>
	<td>#<?php echo $fiche->loue_velo_id  ?></td>
</tr>
<tr>
	<td>Modèle</td>
	<td><?php echo $fiche->modele_nom  ?></td>
</tr>
<tr>
	<td>Date d'achat</td>
	<td><?php echo sql_to_human($fiche->velo_date_achat) ?></td>
</tr>
<tr>
	<td>Détails</td>
	<td><a href="/velo/ficheVelo/<?php echo $fiche->loue_velo_id; ?>">Consulter la fiche du vélo</a></td>
</tr>

<tr>
	<td colspan="2">Location</td>
</tr>
<tr>
	<td>Début location</td>
	<td><?php echo sql_to_human($fiche->loue_date_location) ?></td>
</tr>
<tr>
	<td>Cadenas</td>
	<td><?php echo $fiche->loue_cadenas1 ?> - <?php echo $fiche->loue_cadenas2 ?> - <?php echo $fiche->loue_cadenas3 ?></td>
</tr>
<tr>
	<td>Durée</td>
	<td><?php echo $fiche->loue_duree_theorique ?> jours</td>
</tr>
<tr>
	<td>Fin théorique</td>
	<td>
		<?php
		$ex = explode('-', $fiche->loue_date_location);
		echo sql_to_human(date('Y-m-d', mktime(0, 0, 0, $ex[1], $ex[2]+$fiche->loue_duree_theorique, $ex[0])));
		?>
	</td>
</tr>
<tr>
	<td>État</td>
	<td><?php echo ((!isset($fiche->loue_date_rendu_effective)) ?  "Vélo loué" : "vélo disponible") ?></td>
</tr>
<tr>
	<td>Local</td>
	<td><?php echo $fiche->local_nom  ?> à <?php echo $fiche->ville_nom  ?> (<?php echo $fiche->campus_nom ?>)</td>
</tr>
</table>

<p style="text-align:center">
<a href="<?php echo site_url('location/supprimerLocation/'.$fiche->loue_loc_id.'/'.$fiche->loue_velo_id.'/'.$fiche->loue_date_location); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la location ?');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>
</p>

<p class="retour"><a href="<?php echo site_url('location'); ?>">Retour</a></p>
