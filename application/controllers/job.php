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
		// @todo remove this workaround for the template controller
		$this->template->content = '';
		
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
	
	public function edit($id)
	{
		$job = ORM::factory('job', $id);
		
		$priority_opts = array_combine(range(1, 10), range(1, 10));
		
		$this->template->content = View::factory('jobs/edit')
			->set('job', $job)
			->set('params', implode(unserialize($job->params), ','))
			->set('priority_opts', $priority_opts);
	}
	
	public function update()
	{
		$post = $this->input->post();
		$job  = ORM::factory('job', $post['id']);
		
		if ($job->validate($post, true)) {
			Session::instance()->set_flash('message', array('type' => 'success', 'text' => 'Job updated successfully.'));
			url::redirect('job');
		} else {
			// @todo add error message
			url::redirect('job/edit/'.$post['id']);
		}
	}
}
