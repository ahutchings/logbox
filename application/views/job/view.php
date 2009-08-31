    <div id="yui-main">
        <div class="yui-a"><div class="yui-g">

            <div class="block">
                <div class="bd">
                    <h2><?php echo $job->name ?></h2>

					<p><?php echo $job->description ?></p>

					<p><?php echo $job->class ?>::<?php echo $job->method ?>()</p>
                    		
	                <p>
	                	<strong>Expression:</strong>
						<?php echo $job->expression ?>
					</p>							

					<?php if ($job->last_run !== null): ?>
					<p>
	                	<strong>Last Run:</strong>
	                	<?php echo $job->last_run ?>
	                	(<?php echo ($job->result == 1) ? 'success' : 'failure'; ?>)
					</p>
					<?php endif ?>
	                    	
	                <p>
	                	<strong>Next Run:</strong>
						<?php echo $job->next_run ?>
					</p>
						
                    <p>
                    	<strong>Priority:</strong>
						<?php echo $job->priority ?>
					</p>
                    
                    <p>
                    	<strong>Active:</strong>
						<?php echo ($job->is_active) ? 'yes' : 'no'; ?>
					</p>
                </div>
            </div>

        </div></div>
    </div>
