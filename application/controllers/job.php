<?php

class Job_Controller extends Template_Controller
{
	public function index()
	{
		$content = new View('jobs/index');
		$content->jobs = ORM::factory('job')->find_all();
				
		$this->template->content = $content;
	}
	
	public function add()
	{
		$this->template->content = new View('jobs/new');
	}
	
	// @todo put this in a controller that doesn't use templates (no output)
	public function initialize()
	{
		// Call bootstrap method synchronously
		Job_Model::bootstrap(false);
	}
	
	public function show($id)
	{
		$content = new View('jobs/view');
		$content->job = ORM::factory('job')->find($id);
		
		$this->template->content = $content;
	}
	
	public function create()
	{
		$post = $_POST;
		$job  = ORM::factory('job');
		
		if ($job->validate($post, true)) {
			Session::instance()->set_flash('message', array('type' => 'success', 'text' => 'Job created successfully.'));
			url::redirect('job/index');
		} else {
			// @todo add error message
			url::redirect('job/new');
		}
	}
	
	public function delete($id)
	{
		ORM::factory('job')->delete($id);
		
		Session::instance()->set_flash('message', array('type' => 'success', 'text' => 'Job deleted successfully.'));
		
		url::redirect('job/index');
	}
}
