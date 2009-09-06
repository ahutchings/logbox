<?php

abstract class Repository_Importer
{
    public $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->import();
    }

    abstract protected function import();
}
