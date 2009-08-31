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
	            $this->import_pidgin_plaintext();
	        case '1':
	            $this->import_adium_xml();
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

	/**
	 * Imports messages from an Adium XML repository.
	 *
	 * @return bool
	 */
	public function import_adium_xml()
	{
	    $account_dirs = array_diff(scandir($this->directory), array('.', '..'));

	    foreach ($account_dirs as $account_dir) {
	        $recipients = array_diff(scandir("$this->directory/$account_dir"), array('.', '..'));

	        foreach ($recipient_dirs as $recipient_dir) {
	            $session_dirs = array_diff(scandir("$this->directory/$account_dir/$recipient_dir"), array('.', '..'));

	            foreach ($session_dirs as $session_dir) {
	                $session = array_diff(scandir("$this->directory/$account_dir/$recipient_dir/$session_dir"), array('.', '..'));
	                $xml     = simplexml_load_file("$this->directory/$account_dir/$recipient_dir/$session_dir/$session");
	                $account = $xml['account'];

	                foreach ($xml as $message_dom) {
	                    $data = array(
	                        sent_at => $message_dom['time'],
	                        protocol => $xml['service'],
	                        sender => $message_dom['sender'],
	                        recipient => '', // @todo set this based on sender and session folder name
	                        recipient_friendlyname => $message_dom['alias'],
	                        content => $message_dom
	                    );

                        $message = new Message_Model();
	                    $message->validate($data, true);
	                }
	            }
	        }
	    }
	}

    /**
     * Imports messages from a Pidgin plain text repository.
     *
     * @return bool
     */
    public function import_pidgin_plaintext()
    {
        $message_regex = '/^\((?P<sentat>.*?)\) (?P<sender>.*?): (?P<content>.*)/';
        $status_regex  = '/\\((?P<sentat>.*)\\) (?P<sender>.*)\\ (?P<content>.*)/';
        $file_regex    = '%/(?P<protocol>.*)/(?P<account>.*)/(?P<recipient>.*)/'
            .'(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2}).(?P<hour>\d{2})(?P<minute>\d{2})(?P<second>\d{2})%';

        foreach (dir::list_files($this->directory) as $path) {

            // standardize path for the regex
            $file = substr($path, strlen(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, $path, -4))));
            $file = str_replace('\\', '/', $file);

            preg_match($file_regex, $file, $file_match);

            $lines = file($path);

            for ($i = 1, $n = count($lines); $i < $n; $i++) {

                // @todo match file transfers

                // if we can match a message
                if (preg_match($message_regex, $lines[$i], $message_match) === 1) {

                    // skip failed AIM messages
                    if ($message_match['sender'] == 'Unable to send message') {
                        continue;
                    }

                    // strip auto-reply text from the sender
                    $message_match['sender'] = str_replace(' <AUTO-REPLY>', '', $message_match['sender']);

                    $time = $file_match['year'] .'-'. $file_match['month'] .'-'. $file_match['day']
                        .' '. $message_match['sentat'];

                    // save the message
                    $message = new Message_Model();
                    $message->sent_at   = strtotime($time);
                    $message->protocol  = $file_match['protocol'];
                    $message->sender    = $message_match['sender'];
                    $message->recipient = $file_match['recipient'];
                    $message->content   = $message_match['content'];
                    $message->save();

                } elseif (preg_match($status_regex, $lines[$i], $status_match) === 1) {
                    // @todo save the status change
                } else {
                    // @todo this is probably a multiline message
                }
            }
        }
    }
}
