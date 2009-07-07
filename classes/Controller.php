<?php

class Controller
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
}
