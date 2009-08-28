<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Users</h2>
            </div>
            <div class="bd">
            	<a href="/user/add">Create a user</a>
				
				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Email</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($users as $user): ?>
					    <tr>
					        <td><?php echo $user->id ?></td>
					        <td><?php echo $user->username ?></td>
					        <td><?php echo $user->email ?></td>
					        <td><a href="<?php echo url::site("user/edit/$user->id") ?>">edit</a></td>
					    </tr>
					<?php endforeach ?>
					</tbody>
				</table>
            </div>
		</div>

	</div></div>
</div>
