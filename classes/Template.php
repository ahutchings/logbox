<?php

class Template extends Savant3
{
    public function __construct($config = null)
    {
        $config = array(
            'template_path' => LOGBOX_PATH . Logbox::theme_path()
        );

        parent::__construct($config);
    }
}
