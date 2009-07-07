<?php

class SiteHandler
{
    static public function display_home()
    {
        $tpl = new Template();

        $params = array();

        if (isset($_GET['criteria'])) {
            $params['criteria'] = $_GET['criteria'];
            $tpl->criteria      = $_GET['criteria'];
        }

        $tpl->messages = Message::get($params);

        $tpl->display('home.php');
    }

    static public function display_statistics()
    {
    }

    static public function display_settings()
    {
    }

    static public function display_login()
    {
    }

    static public function do_logout()
    {
    }

    static public function display_404()
    {
        header('HTTP/1.1 404 Not Found');
    }
}
