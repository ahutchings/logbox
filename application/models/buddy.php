<?php

class Buddy_Model extends ORM
{
    protected $has_one  = array('account');
    protected $has_many = array('conversations');
}
