<?php

class Message_Controller extends Template_Controller
{
	public function statistics()
	{
		$content = new View('message/statistics');
		
		$this->template->content = $content;
	}
}
