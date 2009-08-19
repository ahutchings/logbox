<?php

class Repository_Controller extends Template_Controller
{
	public function index()
	{
	    $content = new View('repository/index');
	    
	    $content->repositories = ORM::factory('repository')->find_all();
	    
	    $this->template->content = $content;		
	}
}
