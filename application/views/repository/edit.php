<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Edit a Repository</h2>
            </div>
            <div class="bd">
            	<?php echo form::open('repository/update') ?>
					<?php echo form::hidden('id', $repository->id) ?>
				    <p>
				        <label for="directory">Directory</label>
				        <input type="text" name="directory" class="text" value="<?php echo $repository->directory ?>" />
				    </p>

				    <p>
				        <label for="type">Type</label>
				        <?php echo form::dropdown('type', $type_options, $repository->type) ?>
				    </p>
				    
				    <p><button>Save</button></p>
				<?php echo form::close() ?>
            </div>
		</div>

	</div></div>
</div>
