<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Repositories</h2>
            </div>
            <div class="bd">
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
            </div>
		</div>

	</div></div>
</div>