<?php

class Home_Controller extends Template_Controller
{
	public function index()
	{
		$this->template->content = View::factory('home')
		    ->set('messages', ORM::factory('message')->find_all(30));
	}
}
