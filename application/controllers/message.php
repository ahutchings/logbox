<?php

class Message_Controller extends Template_Controller
{
	public function statistics()
	{
		$this->template->title   = 'Message Statistics';
		$this->template->content = View::factory('message/statistics')
		    ->bind('messages_by_sender', $messages_by_sender)
		    ->bind('messages_by_month', $messages_by_month);

        $messages_by_sender = Database::instance()
            ->select('sender', 'COUNT(1) as count')
            ->groupby('sender')
            ->orderby('count', 'DESC')
            ->get('messages', 10);

        $q = 'SELECT UNIX_TIMESTAMP(sent_at) timestamp, YEAR(sent_at) year, MONTH(sent_at) month, COUNT(1) count'
        	. ' FROM messages GROUP BY YEAR(sent_at), MONTH(sent_at)';

        $messages_by_month = Database::instance()->query($q);
	}
}
