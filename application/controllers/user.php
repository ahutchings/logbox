<?php

class User_Controller extends Template_Controller
{
	public function create()
	{
	    $this->template->content = View::factory('user/new')
	        ->bind('post', $post)
	        ->bind('errors', $errors)
	        ->bind('cancel', $return)
	        ->bind('delete', $delete);

	    // Set return URL
	    $return = url::site('user');
	
	    // Do not overwrite POST
	    $post = $this->input->post();
	
	    // Load a new repository
	    $user = ORM::factory('user');
	
	    // Validate the repository
	    $user->validate($post, $return);
	
	    // Load errors
	    $errors = $post->errors('user');
	}
	
	public function add()
	{
		$this->template->title   = 'Create a User';
		$this->template->content = View::factory('user/new');
	}
	
	public function edit($id)
	{
		$this->template->title   = 'Edit a User';
		
		$this->template->content = View::factory('user/edit')
			->set('roles', ORM::factory('role')->find_all())
			->bind('user', $user)
			->bind('user_roles', $user_roles);
		
		$user = ORM::factory('user')->find($id);

		$user_roles = array();
		 
		foreach ($user->roles as $user_role) {
			$user_roles[] = $user_role->id;
		}
	}
	
	public function index()
	{
	    $this->template->title = 'Users';
	    
	    $this->template->content = View::factory('user/index')
	    	->set('users', ORM::factory('user')->find_all());
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
	
	public function update()
	{
		$post = $this->input->post();
		
		$user = ORM::factory('user', $this->input->post('id'));

		// remove existing roles
		foreach ($user->roles as $role) {
			$user->remove(ORM::factory('role', $role->id));
		}				
		
		$user->username = $post['username'];
		$user->email    = $post['email'];
		$user->roles    = $post['roles'];
		
		// @todo handle password changes
		
		$user->save();
		
		url::redirect('user');
	}
}
