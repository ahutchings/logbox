<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Edit a User</h2>
            </div>
            <div class="bd">
				<?php echo form::open('user/update') ?>
					<?php echo form::hidden('id', $user->id) ?>
				    <p>
				        <label for="username">Username</label>
				        <input type="text" name="username" value="<?php echo $user->username ?>" class="text" />
				    </p>
				    
				    <p>
				        <label for="email">Email</label>
				        <input type="text" name="email" value="<?php echo $user->email ?>" class="text" />
				    </p>
				    
				    <p>
				        <label for="password">Password</label>
				        <input type="password" name="password" class="text" />
				    </p>
				
				    <p>
				        <label for="password_confirm">Password (again)</label>
				        <input type="password" name="password_confirm" class="text" />
				    </p>
				    
				    <fieldset>
					<legend>User can:</legend>
					<ul>
					<?php foreach ($roles as $role): ?>
					<li>
					<?=form::checkbox(array('id' => 'role_'.$role->name, 'name' => 'roles[]'), $role->id, in_array($role->id, $user_roles))?>
					<?=form::label('role_'.$role->name, $role->name)?>
					</li>
					<? endforeach; ?>
					</ul>
					</fieldset>
				
					<p><button>Update</button></p>
				<?php echo form::close() ?>
            </div>
		</div>

	</div></div>
</div>
