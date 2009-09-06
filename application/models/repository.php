<?php

class Repository_Model extends ORM
{
	public function validate(array &$array, $save = false)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
	    	->add_rules('directory', 'required')
	    	->add_rules('type', 'required')
        	->add_callbacks('directory', array($this, 'unique_directory'))
        	->add_callbacks('directory', array($this, 'readable_directory'));

		return parent::validate($array, $save);
	}

	/**
	 * Checks that the directory is unique.
	 *
	 * @param Validation $array Validation object
	 * @param string     $field Name of field being validated
	 *
	 * @return null
	 */
	public function unique_directory(Validation $array, $field)
	{
		$exists = (bool) ORM::factory('repository')->where('directory', $array[$field])->count_all();

		if ($exists) {
			$array->add_error($field, 'directory_exists');
		}
	}

	/**
	 * Checks that the directory exists and is readable.
	 *
	 * @param Validation $array Validation object
	 * @param string     $field Name of field being validated
	 *
	 * @return null
	 */
	public function readable_directory(Validation $array, $field)
	{
		$readable = @opendir($array[$field]);

		if (!$readable) {
			$array->add_error($field, 'directory_unreadable');
		}
	}

	/**
	 * Imports messages from a repository.
	 *
	 * @todo make child classes for each repository type so the switch isn't necessary
 	 *
	 * @return bool
	 */
	public function import()
	{
	    set_time_limit(10000000);

	    switch ($this->type) {
	        case '0':
	            new Pidgin_Plaintext_Importer($this->directory);
	        case '1':
	            new Adium_XML_Importer($this->directory);
	        default:
	            return false;
	    }
	}

	/**
	 * Imports messages from a repository.
	 *
	 * @param int $id Repository ID
	 *
	 * @return bool
	 */
	public static function import_by_id($id)
	{
		$repository = ORM::factory('repository', $id);

		return $repository->import();
	}
}
