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
    public static function import_pidgin_plaintext()
    {
        $protocols = array_diff(scandir($this->directory), array('.', '..'));

        foreach ($protocols as $protocol) {
            $protocol_dir = Options::get('log_path') . '/' . $protocol;
            $accounts     = array_diff(scandir($protocol_dir), array('.', '..'));

            foreach ($accounts as $account) {
                $account_dir = $protocol_dir . '/' . $account;
                $recipients = array_diff(scandir($account_dir), array('.', '..'));

                foreach ($recipients as $recipient) {
                    $recipient_dir = $account_dir . '/' . $recipient;
                    $sessions      = array_diff(scandir($recipient_dir), array('.', '..'));

                    foreach ($sessions as $session) {
                        $session_path = $recipient_dir . '/' . $session;

                        $message_regex = '/^\((?P<sentat>.*?)\) (?P<sender>.*?): (?P<content>.*)/';
                        $status_regex  = '/\\((?P<sentat>.*)\\) (?P<sender>.*)\\ (?P<content>.*)/';
                        $session_regex = '/(?P<year>\\d{4})-(?P<month>\\d{2})-(?P<day>\\d{2}).(?P<hour>\\d{2})(?P<minute>\\d{2})(?P<second>\\d{2})/';

                        preg_match($session_regex, $session, $session_match);

                        $session_handle = file($session_path);

                        for ($i = 1, $n = count($session_handle); $i < $n; $i++) {

                            // @todo match file transfers

                            // if we can match a message
                            if (preg_match($message_regex, $session_handle[$i], $message_match) === 1) {

                                // skip failed AIM messages
                                if ($message_match['sender'] == 'Unable to send message') {
                                    continue;
                                }

                                // strip auto-reply text from the sender
                                $message_match['sender'] = str_replace(' <AUTO-REPLY>', '', $message_match['sender']);

                                $time = $session_match['year'] . '-' . $session_match['month'] . '-' . $session_match['day']
                                    . '' . $message_match['sentat'];

                                $data = array(
                                    'sent_at'    => strtotime($time),
                                    'protocol'  => $protocol,
                                    'sender'    => $message_match['sender'],
                                    'recipient' => $recipient,
                                    'content'   => $message_match['content']
                                );

                                $message = new Message_Model();
    	                        $message->validate($data, true);                                	
                                
                            } elseif (preg_match($status_regex, $session_handle[$i], $status_match) === 1) {
                                trigger_error('Event matched.', E_USER_NOTICE);
                                // @todo save the status change
                            } else {
                                // @todo this is probably a multiline message
                                $log = 'Unknown line type in file %s. Content: %s';
                                trigger_error(sprintf($log, $session_path, $session_handle[$i]), E_USER_WARNING);
                            }
                        }
                    }
                }
            }
        }
    }
}
