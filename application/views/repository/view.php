<div id="yui-main">
    <div class="yui-a"><div class="yui-g">

        <div class="block">
            <div class="bd">
                <h2><?php echo $repository->directory ?></h2>

				<p><?php echo $repository->type ?></p>

				<p>
					<ul>
						<li><a href="<?php echo url::site("repository/edit/$repository->id") ?>">edit</a></li>
						<li><a href="<?php echo url::site("repository/import/$repository->id") ?>">import</a></li>
					</ul>
				</p>
            </div>
        </div>

    </div></div>
</div>
