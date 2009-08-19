<a href="/repository/create">Create a repository</a>

<table>
<thead>
	<tr>
		<th>ID</th>
		<th>Directory</th>
		<th>Type</th>
	</tr>
</thead>
<tbody>
<?php foreach ($repositories as $repository): ?>
	<tr>
		<td><?php echo $repository->id ?></td>
		<td><?php echo $repository->directory ?></td>
		<td><?php echo $repository->type ?></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
