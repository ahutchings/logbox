<div id="yui-main">
	<div class="yui-a"><div class="yui-g">

		<div class="block">
            <div class="hd">
            	<h2>Create a Repository</h2>
            </div>
            <div class="bd">
				<form method="post" action="<?php echo url::site('repository/create') ?>">
				    
				    <p>
				        <label for="directory">Directory</label>
				        <input type="text" name="directory" class="text" />
				    </p>
				    
				    <p>
				        <label for="type">Type</label>
				        <select name="type" class="text">
				        	<option value="pidgin">Pidgin</option>
				        	<option value="adium">Adium</option>
				        </select>
				    </p>
				    
				    <p><button>Create</button></p>
				
				</form>
            </div>
		</div>

	</div></div>
</div>
