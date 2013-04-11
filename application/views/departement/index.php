<h1>Liste des départements</h1>

<p class="ajout ajout_haut"><a href="<?php echo site_url('/departement/ajouter'); ?>">Créer un département</a></p>

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
	
	<input type="button" value="Filtrer" onclick="document.location = '/departement/index/campus/' + document.getElementById('campus').value" />
	
	<input type="button" value="Supprimer le filtre" onclick="document.location = '/departement/'" />
</fieldset>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<?php if (count($departements) > 0): ?>
<table>
	<tr>
		<th>Campus</th>
		<th>Département</th>
		<th style="width:100px;">Locataires</th>
		<th style="width:80px;">Actions</th>
	</tr>

<?php
$rowCount = array();
$contenu = '';
$tmpCampus = '';
foreach($departements as $data)
{
	if ($data->campus_id == $tmpCampus)
	{
		$rowCount[$data->campus_id] += 1;
		$affichageCampus = '';
	}
	else
	{
		$rowCount[$data->campus_id] = 1;
		$affichageCampus = '<td rowspan="{'.$data->campus_id.'}">'.$data->campus_nom.'</td>';
	}
	$tmpCampus = $data->campus_id;

$contenu .= '
	<tr>
		'.$affichageCampus.'
		<td>'.$data->dept_nom.'</td>
		<td>';

			if (!isset($data->dept_loc))
				$contenu .= '0';
			else
				$contenu .=  '<a href="/locataire/index/campus/'.$data->campus_id.'/dept/'.$data->dept_id.'" 
						title="Liste des locataires du département « '.$data->dept_nom.' »'."\n".'(locataires avec vélo / total)">
						'.((isset($data->dept_loc_actif)) ? $data->dept_loc_actif : 0).' / '.$data->dept_loc.'</a>';

		$contenu .= '</td>
		<td>';
			$contenu .= '<a href="/departement/modifier/'.$data->dept_id.'"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>';
			
			if ($data->dept_loc == 0)
			$contenu .= '
			&nbsp;
			<a href="/departement/supprimer/'.$data->dept_id.'" 
			onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer le département ? « '.$data->dept_nom.' »\');"><img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" /></a>';
			else 
			$contenu .= '
			&nbsp;
			<img src="/assets/images/nodel.png" alt="-" title="Impossible de supprimer" />';
			
			$contenu .='
		</td>
	</tr>';
}

foreach ($rowCount as $departement => $rows)
	$contenu = str_replace('{'.$departement.'}', $rows, $contenu);

echo $contenu;
?>
</table>

<p class="italic">Pour supprimer un département, il ne doit contenir aucun locataire.</p>

<?php else: ?>
<p>Aucun département à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('/departement/ajouter'); ?>">Créer un département</a></p>
