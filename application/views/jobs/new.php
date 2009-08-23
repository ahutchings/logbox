    <div id="yui-main">
        <div class="yui-a"><div class="yui-g">

            <div class="block">
                <div class="bd">
                    <h2>Add a job</h2>

                    <?php echo form::open('job/create') ?>
	                    	<p>
	                    		<label for="name">Name</label>
	                    		<input name="name" id="name" size="45" type="text" class="text">
                    		</p>

	                    	<p>
		                    	<label for="description">Description</label>
		                    	<textarea id="description" name="description" rows="5" cols="40" class="text"></textarea>
	                    	</p>
                    		
	                    	<p>
	                    		<label for="class">Class</label>
	                    		<input name="class" id="class" size="45" type="text" class="text">
                    		</p>
                    		
	                    	<p>
	                    		<label for="method">Method</label>
	                    		<input name="method" id="method" size="45" type="text" class="text">
                    		</p>
                    		
	                    	<p>
		                    	<label for="params">Parameters</label>
		                    	<textarea id="params" name="params" rows="5" cols="40" class="text"></textarea>
		                    	<span class="info">Ex: comma, separated, params</span>
	                    	</p>
                    		
	                    	<p>
	                    		<label for="expression">Expression</label>
	                    		<input name="expression" id="expression" size="45" type="text" class="text">
	                    		<span class="info">Ex: 0 0 * * 1 (leave blank for non-recurring)</span>
                    		</p>
	                    	
	                    	<p>
	                    		<label for="next_run">Next Run</label>
	                    		<input name="next_run" id="next_run" size="45" type="text" class="text">
	                    		<span class="info">Ex: 2009-01-01 00:00:00 (leave blank to auto-populate from expression)</span>
                    		</p>

	                    	<p>
		                    	<label for="priority">Priority</label>
		                    	<select id="priority" name="priority">
		                    		<option>1</option>
		                    		<option>2</option>
		                    		<option>3</option>
		                    		<option>4</option>
		                    		<option selected="selected">5</option>
		                    		<option>6</option>
		                    		<option>7</option>
		                    		<option>8</option>
		                    		<option>9</option>
		                    		<option>10</option>
		                    	</select>
	                    	</p>
	                    	
	                    	<p>
		                    	<label for="is_active">Active</label>
		                    	<select id="is_active" name="is_active">
		                    		<option value="0">no</option>
		                    		<option value="1" selected="selected">yes</option>
		                    	</select>
	                    	</p>
                    	
                    	<input value="Submit" type="submit">
                    </form>
                </div>
            </div>

        </div></div>
    </div>
