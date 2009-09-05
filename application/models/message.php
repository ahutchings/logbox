<?php

class Message_Model extends ORM
{
    protected $has_one = array('conversation');
    protected $sorting = array('sent_at' => 'desc');
}
