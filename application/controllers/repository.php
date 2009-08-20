<?php

class Repository_Controller extends Template_Controller
{
	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->create_repository();
			return;
		}
		
		$content = new View('repository/create');
		
		$this->template->title   = 'Create a Repository';
		$this->template->content = $content;
	}

	private function create_repository()
	{
		$post       = $_POST;
		$repository = ORM::factory('repository');
		
		if ($repository->validate($post, true)) {
			Session::instance()->set_flash('message', array('type' => 'success', 'text' => 'Repository created successfully.'));
			url::redirect('repository');
		} else {
			// @todo add error message
			url::redirect('repository/create');
		}
	}
	
	public function index()
	{
	    $content = new View('repository/index');
	    
	    $content->repositories = ORM::factory('repository')->find_all();
	    
	    $this->template->title   = 'Repositories';
	    $this->template->content = $content;		
	}
}
