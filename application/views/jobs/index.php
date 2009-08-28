           	<div id="yui-main">
            	<div class="yui-a"><div class="yui-g">

                	<div class="block" id="jobs-recurring">
                		<div class="hd">
                            <h2>Recurring Jobs</h2>
                		</div>
                		<div class="bd">
                            <table>
                            	<thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-right">Last Run</th>
                                        <th class="text-right">Next Run</th>
                                        <th></th>
                                    </tr>
                            	</thead>
                            	<tbody>
                                <?php foreach ($jobs as $job): ?>
                                	<?php if (!empty($job->expression)): ?>
                                    <tr class="<?php echo $job->get_class() ?>">
                                    	<td width="124">
                                        	<a href="<?php echo url::site('job/show/'.$job->id) ?>" title="View job details">
	                                    		<?php echo $job->name ?>
	                                        </a>
                                        </td>
										<td class="text-right"><?php echo $job->last_run ?></td>
                                        <td class="text-right"><?php echo $job->next_run ?></td>
                                        <td class="text-right">
                                        	<?php if ($job->name !== 'master'): ?>
                                        	<a href="<?php echo url::site('job/delete/'.$job->id) ?>" title="Delete job">delete</a>
                                        	<?php endif ?>
                                    	</td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        		</tbody>
                            </table>
                            <p><a class="button" href="/job/add/">Add a new job</a></p>
                        </div>
                	</div>
                	
                	<div class="block" id="jobs-at">
                		<div class="hd">
                            <h2>Non-recurring Jobs</h2>
                		</div>
                		<div class="bd">
                            <table>
                            	<thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-right">Last Run</th>
                                        <th class="text-right">Next Run</th>
                                        <th></th>
                                    </tr>
                            	</thead>
                            	<tbody>
                                <?php foreach ($jobs as $job): ?>
                                	<?php if (empty($job->expression)): ?>
                                    <tr class="<?php echo $job->get_class() ?>">
                                    	<td width="124">
                                        	<a href="<?php echo url::site('job/show/'.$job->id) ?>" title="View job details">
	                                    		<?php echo $job->name ?>
	                                        </a>
                                        </td>
										<td class="text-right"><?php echo $job->last_run ?></td>
                                        <td class="text-right"><?php echo $job->next_run ?></td>
                                        <td class="text-right">
                                        	<?php if ($job->name !== 'master'): ?>
                                        	<a href="<?php echo url::site('job/delete/'.$job->id) ?>" title="Delete job">delete</a>
                                        	<?php endif ?>
                                    	</td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        		</tbody>
                            </table>
                            <p><a class="button" href="/job/new/">Add a new job</a></p>
                        </div>
                	</div>

                </div></div>
            </div>
