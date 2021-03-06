<?php include 'header.php' ?>
        <div id="bd">
            <div id="yui-main">
                <div class="yui-a"><div class="yui-g">

                    <div class="block">
                        <div class="bd">
                            <h2>Settings</h2>
                            <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                                <p><label for="base_url">Base URL</label>
                                    <input type="text" class="text" name="base_url" id="base_url" value="<?php echo Options::get('base_url') ?>">
                                    <span class="info">Ex: http://logbox.localhost/</span>
                                </p>
                                <p><label for="theme_path">Theme Path</label>
                                    <input type="text" class="text" name="theme_path" id="theme_path" value="<?php echo Options::get('theme_path') ?>">
                                    <span class="info">Ex: /themes/default/</span>
                                </p>
                                <p><label for="log_path">Log Path</label>
                                    <input type="text" class="text" name="log_path" id="log_path" value="<?php echo Options::get('log_path') ?>">
                                    <span class="info">Ex: /Users/Andrew/AppData/Roaming/.purple/logs/</span>
                                </p>
                                <p><label for="pagination">Items per Page</label>
                                    <input type="text" class="text" name="pagination" id="pagination" value="<?php echo Options::get('pagination') ?>">
                                    <span class="info">Ex: 20</span>
                                </p>
                                <p><label for="timezone">Timezone</label>
                                    <select id="timezone" name="timezone">
                                    <?php foreach (Logbox::getTimezones() as $timezone): ?>
                                        <option <?php if (Options::get('timezone') == $timezone): ?> selected="selected"<?php endif ?>><?php echo $timezone ?></option>
                                    <?php endforeach ?>
                                    </select>
                                </p>
                                <p><input type="submit" value="Apply"></p>
                            </form>
                        </div>
                    </div>

                </div></div>
            </div>
        </div>
<?php include 'footer.php' ?>
