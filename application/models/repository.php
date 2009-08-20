<?php

class Repository_Model extends ORM
{
	public function validate(array &$array, $save = false)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
	    	->add_rules('directory', 'required')
	    	->add_rules('type', 'required');

		return parent::validate($array, $save);
	}
}
