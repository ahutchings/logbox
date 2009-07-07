<?php include 'header.php' ?>
        <div id="bd">
            <div id="yui-main">
                <div class="yui-a"><div class="yui-g">

                    <div class="block">
                        <div class="hd">
                            <h2>Settings</h2>
                        </div>
                        <div class="bd">
                            <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                                <p><label for="base_url">Base URL</label>
                                    <input type="text" class="text" name="base_url" id="base_url" value="<?php echo Options::get('base_url') ?>">
                                    <span class="info">Ex: http://logbox.localhost/</span>
                                </p>
                                <p><label for="theme_path">Theme Path</label>
                                    <input type="text" class="text" name="theme_path" id="theme_path" value="<?php echo Options::get('theme_path') ?>">
                                    <span class="info">Ex: /themes/default/</span>
                                </p>
                                <p><input type="submit" value="Apply"></p>
                            </form>
                        </div>
                    </div>

                </div></div>
            </div>
        </div>
<?php include 'footer.php' ?>
