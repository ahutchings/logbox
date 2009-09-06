<?php

class Home_Controller extends Template_Controller
{
	public function index()
	{
        $this->template->content = View::factory('home')
		    ->bind('messages', $messages)
		    ->bind('senders', $senders)
		    ->bind('dates', $dates)
		    ->bind('pagination', $pagination);

        if (isset($_GET['criteria'])) {
           // @todo modify messages select
            $this->template->content->set('criteria', $_GET['criteria']);
        }

        if (isset($_GET['sender'])) {
            // @todo modify messages select
            $this->template->content->set('selected_sender', $_GET['sender']);
        }

        if (isset($_GET['dates'])) {
            // @todo modify messages select
            $this->template->content->set('selected_date', $_GET['dates']);
        }

	    $messages = ORM::factory('message')->find_all(30);

	    $sender_objs = Database::instance()
	        ->select('DISTINCT sender')
	        ->orderby('sender', 'ASC')
	        ->get('messages');

        // @todo figure out Database's analog to PDO::FETCH_COLUMN
        foreach ($sender_objs as $sender_obj) {
            $senders[] = $sender_obj->sender;
        }

        $date_objs = Database::instance()
            ->select('UNIX_TIMESTAMP(sent_at) as date')
            ->orderby('sent_at', 'DESC')
            ->get('messages');

        // @todo figure out Database's analog to PDO::FETCH_COLUMN
        foreach ($date_objs as $date_obj) {
            $dates[] = $date_obj->date;
        }

        $dates = array_map(create_function('$date', 'return date("F Y", $date);'), $dates);
        $dates = array_unique($dates);

        $pagination = new Pagination(array(
            'items_per_page' => 30,
            'total_items' => Database::instance()->count_records('messages')
        ));
	}
}
