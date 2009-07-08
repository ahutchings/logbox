<?php

class SiteHandler
{
    public $template = null;

    public function __construct()
    {
        $this->template = new Template();
    }

    public function display_home()
    {
        $params = array();

        if (isset($_GET['criteria'])) {
            $params['criteria'] = $_GET['criteria'];
            $this->template->criteria      = $_GET['criteria'];
        }

        $this->template->messages = Messages::get($params);

        $this->template->display('home.php');
    }

    public function display_logs()
    {
        $this->template->logs = Logs::get();

        $this->template->display('logs.php');
    }

    public function display_statistics()
    {
    }

    public function display_settings()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::update_settings();
        }

        $this->template->display('settings.php');
    }

    public function display_login()
    {
    }

    public function display_404()
    {
        header('HTTP/1.1 404 Not Found');
    }

    public function do_logout()
    {
    }

    public function update_settings()
    {
        $allowed = array('base_url', 'theme_path', 'timezone', 'log_path');
        $options = array_intersect_key($_POST, array_fill_keys($allowed, true));

        foreach ($options as $name => $value) {
            Options::set($name, $value);
        }
    }
}
