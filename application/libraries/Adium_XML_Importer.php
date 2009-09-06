<?php

class Adium_XML_Importer extends Repository_Importer
{
	/**
	 * Imports messages from an Adium XML repository.
	 *
	 * @return bool
	 */
	protected function import()
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
}