<?php

Event::add('system.execute', array('Job_Model', 'trigger_jobs'));
