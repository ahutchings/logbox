<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Edit a Repository</h2>
            </div>
            <div class="bd">
				<form method="post" action="<?php echo url::site('repository/edit/'.$repository->id) ?>">
					<input type="hidden" name="id" value="<?php echo $repository->id ?>" />
				    <p>
				        <label for="directory">Directory</label>
				        <input type="text" name="directory" class="text" value="<?php echo $repository->directory ?>" />
				    </p>

				    <p>
				        <label for="type">Type</label>
				        <?php echo form::dropdown('type', $type_options, $repository->type) ?>
				    </p>
				    
				    <p><button>Save</button></p>
				</form>
            </div>
		</div>

	</div></div>
</div>
