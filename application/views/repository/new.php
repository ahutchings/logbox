<div id="yui-main">
	<div class="yui-a"><div class="yui-g">
	
	<?php
		if (isset($errors)) {
			foreach ($errors as $error) {
				echo $error;
			}
		}
	?>

		<div class="block">
            <div class="hd">
            	<h2>Create a Repository</h2>
            </div>
            <div class="bd">
            	<?php echo form::open('repository/create') ?>
				    <p>
				        <label for="directory">Directory</label>
				        <input type="text" name="directory" class="text" />
				    </p>

				    <p>
				        <label for="type">Type</label>
				        <select name="type" class="text">
				        	<option value="0">Pidgin (plain text)</option>
				        	<option value="1">Adium (XML)</option>
				        </select>
				    </p>
				    
				    <p><button>Create</button></p>
				<?php echo form::close() ?>
            </div>
		</div>

	</div></div>
</div>
