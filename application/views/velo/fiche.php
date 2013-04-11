<h1>Fiche du vélo </h1>

<?php
if (count($fiche) == 1) :

$ex = explode('-', $fiche->velo_date_achat);
$tableauMois = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
$date = $ex[2].' '.$tableauMois[$ex[1]-1].' '.$ex[0];
?>

<p style="text-align:center">
<a href="<?php echo site_url('velo/modifVelo/'.$fiche->velo_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
 &nbsp; &nbsp;
<a href="<?php echo site_url('velo/supprVelo/'.$fiche->velo_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le velo n°<?php echo $fiche->velo_id; ?> ?');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>
</p>

<table class="fiche">

<tr>
	<td colspan="2">Vélo</td>
</tr>

<tr>
	<td>Numéro</td>
	<td><?php echo $fiche->velo_id ?></td>
</tr>

<tr>
	<td>Loué</td>
	<td>
		<?php
		if ($fiche->nbLoc > 0 && !isset($fiche->loue_date_rendu_effective))
			echo 'par <a href="/locataire/desc/'.$fiche->loc_id.'">'.mb_strtoupper($fiche->loc_nom).' '.$fiche->loc_prenom.'</a> depuis le <a href="/location/ficheLocation/'.$fiche->loc_id.'/'.$fiche->velo_id.'/'.$fiche->loue_date_location.'">'.sql_to_human($fiche->loue_date_location).'</a>';
		else
			echo 'Non';
		?>
	</td>
</tr>

<tr>
	<td colspan="2">Type</td>
</tr>

<tr>
	<td>Modèle</td>
	<td><?php echo $fiche->modele_nom; ?></td>
</tr>

<tr>
	<td>Date d'achat</td>
	<td><?php echo $date; ?></td>
</tr>

<tr>
	<td colspan="2">Description</td>
</tr>

<tr>
	<td>Local</td>
	<td><?php echo $fiche->local_nom; ?></td>
</tr>

<tr>
	<td>Suivi</td>
	<td><p><?php echo nl2br($fiche->velo_suivi); ?></p></td>
</tr>
<tr>
	<td>Observations</td>
	<td><p><?php echo nl2br($fiche->velo_observations); ?></p></td>
</tr>

</table>

<p style="text-align:center">
<a href="<?php echo site_url('velo/modifVelo/'.$fiche->velo_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
 &nbsp; &nbsp;
<a href="<?php echo site_url('velo/supprVelo/'.$fiche->velo_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le velo n°<?php echo $fiche->velo_id; ?> ?');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>
</p>

<p class="retour"><a href="<?php echo site_url('velo'); ?>">Retour</a></p>

<?php 
else :
	echo '<p class="info">Aucun vélo ne porte le numéro '.$this->uri->rsegment(3).' !</p>
	<p class="retour"><a href="/velo">Aller à la liste des vélos</a></p>';
endif;
?>
