<?php

class Controller
{
    static public function display_home()
    {
        $tpl = new Template();

        $tpl->messages = Message::get();

        $tpl->display('home.php');
    }
}
