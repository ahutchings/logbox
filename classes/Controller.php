<?php

class Controller
{
    static public function display_index()
    {
        $tpl = new Template();

        $tpl->messages = Message::get();

        $tpl->display('index.php');
    }
}
