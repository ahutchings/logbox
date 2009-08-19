<?php

class Home_Controller extends Template_Controller
{
	public function index()
	{
		$content = new View('home');
		
		$this->template->content = $content;
	}
}
