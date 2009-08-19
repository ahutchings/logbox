<?php

class Home_Controller extends Template_Controller
{
	public function index()
	{
		$content        = new View('home');
//		$content->sites = ORM::factory('site')->find_all();
		
		$this->template->content = $content;
	}
}
