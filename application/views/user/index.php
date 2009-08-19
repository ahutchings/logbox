<a href="/user/create">Create a user</a>

<table>
<thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
</thead>
<tbody>
<?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user->id ?></td>
        <td><?php echo $user->username ?></td>
        <td><?php echo $user->email ?></td>
    </tr>
</tbody>
<?php endforeach ?>
</table>
