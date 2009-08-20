<?php

class User_Controller extends Template_Controller
{
	public function create()
	{
		$content = new View('user/create');
		
		$this->template->title   = 'Create a User';
		$this->template->content = $content;
	}
	
	public function edit($user_id)
	{
		$content = new View('user/edit');
		
		$content->user = ORM::factory('user')->find($user_id);
		
		$this->template->title   = 'Edit a User';
		$this->template->content = $content;
	}
	
	public function index()
	{
	    $content = new View('user/index');
	    
	    $content->users = ORM::factory('user')->find_all();
	    
	    $this->template->title   = 'Users';
	    $this->template->content = $content;
	}
	
    /*
	main login function, return to page if logged in with proper credentials
	*/
	public function login($role = "")
	{
		if (Auth::instance()->logged_in($role)) {
			url::redirect($this->session->get("requested_url")); //return to page where login was called
		} else {
			if (Auth::instance()->logged_in()) {
			    $this->template->title   = "No Access";
			    $this->template->content = new View('user/noaccess');
			} else {
			    $this->template->title   = "Please Login";
			    $this->template->content = new View('user/login');
			}
		}
		
		$form = $_POST;
		if ($form) {
			// Load the user
			$user = ORM::factory('user', $form['username']);

            Auth::instance()->login($user->username, $form['password']);
			url::redirect('/user/login');
		}
	}
}
