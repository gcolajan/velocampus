<h1>Profil d'un locataire</h1>

<p style="text-align:center">
<a href="<?php echo site_url('locataire/modifier/'.$fiche->loc_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
 &nbsp; &nbsp;
<a href="<?php echo site_url('locataire/supprimer/'.$fiche->loc_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce locataire ?');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>
</p>

<?php
	if (!empty($fiche->loc_telephone))
		$telephone = substr(chunk_split('0'.$fiche->loc_telephone, 2, '.'), 0, -1);
	else
		$telephone = '';
?>

<table class="fiche">
<tr>
	<td colspan="2">Identité</td>
</tr>

<tr>
	<td>Nom</td>
	<td><?php echo mb_strtoupper($fiche->loc_nom) ?></td>
</tr>

<tr>
	<td>Prénom</td>
	<td><?php echo $fiche->loc_prenom ?></td>
</tr>

<tr>
	<td colspan="2">Coordonnées</td>
</tr>

<tr>
	<td>Téléphone</td>
	<td><?php echo $telephone ?></td>
</tr>

<tr>
	<td>Mail</td>
	<td><?php echo $fiche->loc_email ?></td>
</tr>

<tr>
	<td>Adresse</td>
	<td><?php echo $fiche->loc_adresse ?><br />
	<?php echo $fiche->ville_cp.' '.$fiche->ville_nom ?></td>
</tr>

<tr>
	<td colspan="2">Informations</td>
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
	<td>Campus</td>
	<td><?php echo $fiche->campus_nom ?></td>
</tr>

<?php if ($fiche->nbLoc > 0 && !isset($fiche->loue_date_rendu_effective)) : ?>

<tr>
	<td colspan="2">Location</td>
</tr>

<tr>
	<td>Vélo</td>
	<td><?php echo '<a href="/velo/ficheVelo/'.$fiche->velo_id.'">#'.$fiche->velo_id.' - '.$fiche->modele_nom.' '.$fiche->annee_achat.'</a>'; ?></td>
</tr>

<tr>
	<td>Date location</td>
	<td><?php echo sql_to_human($fiche->loue_date_location) ?></td>
</tr>

<tr>
	<td>Détails</td>
	<td><a href="/location/ficheLocation/<?php echo $fiche->loc_id.'/'.$fiche->velo_id.'/'.$fiche->loue_date_location ?>">Consulter le détail de la location</a></td>
</tr>

<?php endif; ?>

</table>

<p style="text-align:center">
<a href="<?php echo site_url('locataire/modifier/'.$fiche->loc_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
 &nbsp; &nbsp;
<a href="<?php echo site_url('locataire/supprimer/'.$fiche->loc_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce locataire ?');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>
</p>


<p class="retour"><a href="<?php echo site_url('locataire'); ?>">Retour</a></p>
