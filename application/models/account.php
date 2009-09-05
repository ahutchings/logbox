<?php

class Account_Model extends ORM
{
    protected $has_one  = array('protocol');
    protected $has_many = array('buddies', 'conversations');
}
