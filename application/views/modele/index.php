<h1>Liste des modèles de vélo</h1>

<h2>Modèles référencés</h2>

<?php if (!empty($info)) echo '<p class="info">'.$info.'</p>'; ?>

<p class="ajout ajout_haut"><a href="<?php echo site_url('/modele/ajouter'); ?>">Créer un modèle</a></p>

<?php if (count($modeles) > 0): ?>
<table>
	<tr>
		<th>Modèle</th>
		<th>Quantité</th>
		<th style="width:80px;">Actions</th>
	</tr>
<?php foreach ($modeles as $data): ?>
	<tr>
		<td><?php echo $data->modele_nom; ?></td>
		<?php
			if (isset($data->nb))
				echo '<td><a href="'.site_url('/velo/index/local/0/modele/'.$data->modele_id).'" title="Accéder à la liste des vélos « '.$data->modele_nom.' »">'.$data->nb.'</a></td>';
			else
				echo '<td>0</td>';
		?>
		<td>
			<a href="<?php echo site_url('modele/modifier/'.$data->modele_id); ?>"><img src="/assets/images/edit.png" alt="Modifier" title="Modifier" /></a>
			&nbsp;
			<?php if ($data->nb == 0) : ?>
			<a href="<?php echo site_url('modele/supprimer/'.$data->modele_id); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le modele « <?php echo $data->modele_nom; ?> »');" title="Confirmation via JS">
				<img src="/assets/images/del.png" alt="Supprimer" title="Supprimer" />
			</a>
			<?php else: ?>
			<img src="/assets/images/nodel.png" alt="-" title="Impossible de supprimer" />
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<p class="italic">Pour supprimer un modèle, il ne doit exister aucun vélo de ce modèle.</p>

<?php else: ?>
<p>Aucun modèle à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="<?php echo site_url('/modele/ajouter'); ?>">Créer un modèle</a></p>

<div style="clear:both"></div>

<h2>Répartition par année d'achat</h2>

<?php if (count($modelesAnnuels) > 0): ?>
<table>
	<tr>
		<th>Année</th>
		<th>Modèle</th>
		<th style="width:100px;">Quantité</th>
	</tr>

<?php
$rowCount = array();
$contenu = '';
$tmpAnnee = '';
foreach($modelesAnnuels as $data)
{
	if ($data->annee == $tmpAnnee)
	{
		$rowCount[$data->annee] += 1;
		$affichageAnnees = '';
	}
	else
	{
		$rowCount[$data->annee] = 1;
		$affichageAnnees = '<td class="gris centre" rowspan="{'.$data->annee.'}">'.$data->annee.'</td>';
	}
	$tmpAnnee = $data->annee;


	if ($data->qtLibre > 0)
	$lien = '<a href="/velo/index/local/0/modele/'.$data->modele_id.'/location/non" title="Liste des vélos « '.$data->modele_nom.' » libres (dispo/qt)">
				'.$data->qtLibre.' / '.$data->qt.'
			</a>';
	else
		$lien = '<span title="Disponibles / Quantité enregistrée">0 / '.$data->qt.'</span>';

	$contenu .= '
	<tr>
		'.$affichageAnnees.'
		<td>'.$data->modele_nom.'</td>
		<td>'.$lien.'</td>
	</tr>';
}

foreach ($rowCount as $modele => $rows)
	$contenu = str_replace('{'.$modele.'}', $rows, $contenu);

echo $contenu;
?>

</table>

<?php else: ?>
<p>Aucun achat à afficher !</p>
<?php endif; ?>

<p class="ajout"><a href="/velo/creer_velo">Ajouter un vélo récemment acheté</a></p>
