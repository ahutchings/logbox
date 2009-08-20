<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Edit a User</h2>
            </div>
            <div class="bd">
				<form>
					<input type="hidden" name="id" value="<?php echo $user->id ?>" />
				    
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
				
					<p><button>Update</button></p>
				</form>
            </div>
		</div>

	</div></div>
</div>
