<?php

class Repository_Controller extends Template_Controller
{
	public function create()
	{
	    $this->template->content = View::factory('repository/new')
	        ->bind('post', $post)
	        ->bind('errors', $errors)
	        ->bind('cancel', $return)
	        ->bind('delete', $delete);

	    // Set return URL
	    $return = url::site('repository');
	
	    // Do not overwrite POST
	    $post = $this->input->post();
	
	    // Load a new repository
	    $repository = ORM::factory('repository');
	
	    // Validate the repository
	    $repository->validate($post, $return);
	
	    // Load errors
	    $errors = $post->errors('repository');
	}

	public function add()
	{
		$content = new View('repository/new');
		
		$this->template->title   = 'Create a Repository';
		$this->template->content = $content;
	}

	public function edit($id)
	{
		$content = new View('repository/edit');

		$content->repository = ORM::factory('repository')->find($id);

		$content->type_options = array(
			'0' => 'Pidgin (plain text)',
			'1' => 'Adium (XML)'
		);
		
		$this->template->title   = 'Edit a Repository';
		$this->template->content = $content;
	}
	
	public function show($id)
	{
		$this->template->content = View::factory('repository/view')
			->set('repository', ORM::factory('repository')->find($id));
	}
	
	public function update()
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
	
	public function import($id)
	{
		$repository = ORM::factory('repository', $id);
		
		// create import job
		$job = new Job_Model();
		$job->name = "Import repository: $repository->directory"; 
		$job->class = 'Repository_Model';
		$job->method = 'import_by_id';
		$job->params = serialize(array($repository->id));
		$job->priority = '1';
		$job->next_run = '0000-00-00 00:00:00';

		$job->save();
		
		url::redirect("repository");
	}
}
