<h1>Liste des ville</h1>

<table>
	<tr>
		<th>ville</th>
		<th style="width:100px;">Effectif</th>
		<th style="width:100px;">Locaux</th>
		<th>Opérations</th>
	</tr>
<?php
foreach ($ville as $data):
?>
	<tr>
		<td><?php echo $data->ville_nom; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $info; ?>