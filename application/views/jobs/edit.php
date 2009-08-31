    <div id="yui-main">
        <div class="yui-a"><div class="yui-g">

            <div class="block">
                <div class="bd">
                    <h2>Edit a job</h2>

                    <?php echo form::open('job/update') ?>
                    		<?php echo form::hidden('id', $job->id) ?>
	                    	<p>
	                    		<label for="name">Name</label>
	                    		<input name="name" id="name" size="45" type="text" class="text" value="<?php echo $job->name ?>">
                    		</p>

	                    	<p>
		                    	<label for="description">Description</label>
		                    	<textarea id="description" name="description" rows="5" cols="40" class="text"><?php echo $job->description ?></textarea>
	                    	</p>
                    		
	                    	<p>
	                    		<label for="class">Class</label>
	                    		<input name="class" id="class" size="45" type="text" class="text" value="<?php echo $job->class ?>">
                    		</p>
                    		
	                    	<p>
	                    		<label for="method">Method</label>
	                    		<input name="method" id="method" size="45" type="text" class="text" value="<?php echo $job->method ?>">
                    		</p>
                    		
	                    	<p>
		                    	<label for="params">Parameters</label>
		                    	<textarea id="params" name="params" rows="5" cols="40" class="text"><?php echo $params ?></textarea>
		                    	<span class="info">Ex: comma, separated, params</span>
	                    	</p>
                    		
	                    	<p>
	                    		<label for="expression">Expression</label>
	                    		<input name="expression" id="expression" size="45" type="text" class="text" value="<?php echo $job->expression ?>">
	                    		<span class="info">Ex: 0 0 * * 1 (leave blank for non-recurring)</span>
                    		</p>

	                    	<p>
	                    		<label for="last_run">Last Run</label>
	                    		<input name="last_run" id="last_run" size="45" type="text" class="text" value="<?php echo $job->last_run ?>">
	                    		<span class="info">Ex: YYYY-MM-DD HH:MM:SS</span>
                    		</p>

	                    	<p>
	                    		<label for="next_run">Next Run</label>
	                    		<input name="next_run" id="next_run" size="45" type="text" class="text" value="<?php echo $job->next_run ?>">
	                    		<span class="info">Ex: YYYY-MM-DD HH:MM:SS (leave blank to auto-populate from expression)</span>
                    		</p>

	                    	<p>
		                    	<label for="priority">Priority</label>
		                    	<?php echo form::dropdown('priority', $priority_opts, $job->priority) ?>
	                    	</p>
	                    	
	                    	<p>
		                    	<label for="is_active">Active</label>
		                    	<?php echo form::dropdown('is_active', array('no', 'yes'), $job->is_active) ?>
	                    	</p>

	                    	<p>
		                    	<label for="is_running">Running</label>
		                    	<?php echo form::dropdown('is_running', array('no', 'yes'), $job->is_running) ?>
	                    	</p>
                    	
                    	<input value="Submit" type="submit">
                    <?php echo form::close() ?>
                </div>
            </div>

        </div></div>
    </div>
