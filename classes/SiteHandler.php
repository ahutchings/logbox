<?php

class SiteHandler
{
    public static function display_home()
    {
        $tpl = new Template();

        $params = array();

        if (isset($_GET['criteria'])) {
            $params['criteria'] = $_GET['criteria'];
            $tpl->criteria      = $_GET['criteria'];
        }

        $tpl->messages = Messages::get($params);

        $tpl->display('home.php');
    }

    public static function display_statistics()
    {
    }

    public static function display_settings()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::update_settings();
        }

        $tpl = new Template();

        $tpl->display('settings.php');
    }

    public static function display_login()
    {
    }

    public static function display_404()
    {
        header('HTTP/1.1 404 Not Found');
    }

    public static function do_logout()
    {
    }

    public static function update_settings()
    {
        $allowed = array('base_url', 'theme_path', 'timezone', 'log_path');
        $options = array_intersect_key($_POST, array_fill_keys($allowed, true));

        foreach ($options as $name => $value) {
            Options::set($name, $value);
        }
    }
}
