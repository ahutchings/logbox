<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Login</h2>
            </div>
            <div class="bd">
				<?php echo form::open('user/login') ?>
				    <p>
				        <label for="username">Username</label>
				        <input name="username" type="text" class="text" />
				    </p>
				    
				    <p>
				        <label for="password">Password</label>
				        <input name="password" type="password" class="text" />
				    </p>
				    
				    <button>Login</button>
				<?php echo form::close() ?>
            </div>
		</div>

	</div></div>
</div>
