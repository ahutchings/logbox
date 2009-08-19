<?php

class User_Controller extends Template_Controller
{
	public function login()
	{
		$content = new View('user/login');
		
		$this->template->content = $content;
	}
	
	public function create()
	{
		$content = new View('user/create');
		
		$this->template->content = $content;
	}
	
	public function edit($user_id)
	{
		$content = new View('user/edit');
		
		$content->user = ORM::factory('user')->find($user_id);
		
		$this->template->content = $content;
	}
	
	public function index()
	{
	    $content = new View('user/index');
	    
	    $content->users = ORM::factory('user')->find_all();
	    
	    $this->template->content = $content;
	}
}
