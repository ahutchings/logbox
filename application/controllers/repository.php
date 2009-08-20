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
		$post       = $this->input->post();
		$repository = ORM::factory('repository');
		
		if ($repository->validate($post, true)) {
			Session::instance()->set_flash('message', array('type' => 'success', 'text' => 'Repository created successfully.'));
			url::redirect('repository');
		} else {
			// @todo add error message
			url::redirect('repository/create');
		}
	}
	
	public function edit($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->do_edit();
			return;
		}
		
		$content = new View('repository/edit');

		$content->repository = ORM::factory('repository')->find($id);

		$content->type_options = array(
			'0' => 'Pidgin (plain text)',
			'1' => 'Adium (XML)'
		);
		
		$this->template->title   = 'Edit a Repository';
		$this->template->content = $content;
	}
	
	private function do_edit()
	{
		$post       = $this->input->post();
		$repository = ORM::factory('repository', $post['id']);
		
		if ($repository->validate($post, true)) {
			Session::instance()->set_flash('message', array('type' => 'success', 'text' => 'Repository updated successfully.'));
			url::redirect('repository');
		} else {
			// @todo add error message
			url::redirect('repository/edit/'.$post['id']);
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
