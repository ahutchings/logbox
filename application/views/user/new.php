<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Create a User</h2>
            </div>
            <div class="bd">
            	<?php echo form::open('user/create') ?>
				    <p>
				        <label for="username">Username</label>
				        <input type="text" name="username" class="text" />
				    </p>
				    
				    <p>
				        <label for="email">Email</label>
				        <input type="text" name="email" class="text" />
				    </p>
				    
				    <p>
				        <label for="password">Password</label>
				        <input type="password" name="password" class="text" />
				    </p>
				
				    <p>
				        <label for="password_confirm">Password (again)</label>
				        <input type="password" name="password_confirm" class="text" />
				    </p>
				    
				    <p><button>Create</button></p>
				<?php echo form::close() ?>
            </div>
		</div>

	</div></div>
</div>
