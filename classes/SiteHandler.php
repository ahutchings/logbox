<?php

class SiteHandler
{
    public function display_home()
    {
        $params = array();

        if (isset($_GET['criteria'])) {
            $params['criteria']       = $_GET['criteria'];
            $this->template->criteria = $_GET['criteria'];
        }

        if (isset($_GET['page'])) {
            $params['page']       = $_GET['page'];
            $this->template->page = $_GET['page'];
        }

        if (isset($_GET['dates'])) {
            // @todo convert this into a usable format for Messages::get()
            $params['dates']      = $_GET['dates'];
            $this->template->date = $_GET['dates'];
        }

        if (isset($_GET['sender'])) {
            $params['sender']       = $_GET['sender'];
            $this->template->sender = $_GET['sender'];
        }

        $this->template->messages = Messages::get($params);
        $this->template->pager    = Logbox::paginate('Messages', $params, 'http://logbox.localhost/');

        // retrieve senders for the select filter
        $senders = DB::connect()
            ->query('SELECT DISTINCT sender FROM message ORDER BY sender ASC')
            ->fetchAll(PDO::FETCH_COLUMN);

        $this->template->senders = $senders;

        // retrieve dates for the select filter
        $dates = DB::connect()
            ->query('SELECT UNIX_TIMESTAMP(sent_at) FROM message ORDER BY sent_at DESC')
            ->fetchAll(PDO::FETCH_COLUMN);

        $dates = array_map(create_function('$date', 'return date("F Y", $date);'), $dates);
        $dates = array_unique($dates);

        $this->template->dates = $dates;

        $this->template->display('home.php');
    }

    public function display_statistics()
    {

        $q = 'SELECT sender, COUNT(1) count FROM message GROUP BY sender ORDER BY count DESC LIMIT 10';
        $messages_by_sender = DB::connect()->query($q)->fetchAll();
        shuffle($messages_by_sender);

        $this->template->messages_by_sender = $messages_by_sender;

        $q = 'SELECT UNIX_TIMESTAMP(sent_at) timestamp, YEAR(sent_at) year, MONTH(sent_at) month, COUNT(1) count FROM message GROUP BY YEAR(sent_at), MONTH(sent_at)';

        $messages_by_month = DB::connect()->query($q)->fetchAll();

        $this->template->messages_by_month = $messages_by_month;

        $this->template->display('statistics.php');
    }
}
