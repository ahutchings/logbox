<?php

class Conversation_Model extends ORM
{
    protected $has_one  = array('account', 'buddy');
    protected $has_many = array('messages');
}
