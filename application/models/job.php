<?php

class Job_Model extends ORM
{
	public function validate(array &$array, $save = false)
	{
		// @todo check for valid class::method
		$array = Validation::factory($array)
			->pre_filter('trim')
			->pre_filter('serialize', 'params')
	    	->add_rules('name', 'required', 'alpha_dash')
	    	->add_rules('class', 'required')
        	->add_rules('method', 'required')
	    	->add_rules('priority', 'required', 'digit')
	    	->add_rules('is_active', 'required', 'digit')
	    	->add_callbacks('next_run', array($this, 'next_run_valid'));

		return parent::validate($array, $save);
	}

	/**
	 * Sets the value of the next_run field if this is a recurring Job.
	 *
	 * @param Validation $array
	 * @param $field
	 *
	 * @return null
	 */
	public function next_run_valid(Validation $array, $field)
	{
		// if next_run is empty, try to set from the expression
		if (empty($array[$field]) && !empty($array['expression'])) {
			$next_run      = $this->next_scheduled_run($array['expression']);
	    	$array[$field] = date('Y-m-d H:i:s', $next_run);
		}
	}

	/**
	 * Returns a CSS class based on the Job status.
	 *
	 * @return string
	 */
	public function get_class()
	{
		if ($this->is_running === 1) {
			$class = 'running';
		} elseif ($this->result === 1) {
			$class = 'success';
		} elseif ($this->result === 0) {
			$class = 'failure';
		} else {
			$class = 'scheduled';
		}

		return $class;
	}

    /**
     * Bootstraps jobs.
     *
     * @return null
     */
    public static function bootstrap()
    {
    	$master = ORM::factory('job')->find(1);

    	// exit if cron is already running or it's not due
    	if ($master->is_running == 1 || strtotime($master->next_run) > time()) {
    		return;
    	}

        $master->execute();
    }

    /**
     * Called by a hook, triggers bootstrap asynchronously.
     *
     * @return null
     */
    public static function trigger_jobs()
    {
		$master = ORM::factory('job', 1);

        // exit if cron is already running or it's not due
    	if ($master->is_running == 1 || strtotime($master->next_run) > time()) {
    		return;
    	}

        $url = url::site('job/initialize', 'http');
        $ch  = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Master Job
     *
     * @return bool
     */
    public static function process_queue()
    {
        set_time_limit(0);

        $queued = ORM::factory('job')
			->where('next_run <= NOW()')
			->where('id != 1')
			->where(array(
				'is_active' => 1,
				'is_running' => 0
				))
			->orderby('priority', 'desc')
			->find_all();

        if (count($queued)) {
            foreach ($queued as $job) {
	            $job->execute();
        	}
        }

        return true;
    }

    /**
     * Executes the Job.
     *
     * @return null
     */
    public function execute()
    {
		$this->is_running = true;
		$this->save();

		$callback = array(
			$this->class, $this->method
		);

		if (method_exists($this->class, $this->method)) {
			if (empty($this->params)) {
        		$result = call_user_func($callback);
			} else {
				$result = call_user_func_array($callback, unserialize($this->params));
			}

    		$this->result = intval($result);
		} else {
			Kohana::log('error', "The specified class and/or method doesn't exist: $this->class::$this->method().");
			$this->result = false;
		}

		// find the next run time
		$next_run = null;

		if ($this->is_parent()) {
			$next_job = $this->db->select('next_run')
				->from('jobs')
				->where('id != 1')
				->where('is_active', true)
				->orderby('next_run', 'asc')
				->limit(1)
				->get();

			if (count($next_job)) {
				$next_run = $next_job[0]->next_run;
			}
		} elseif ($this->is_recurring()) {
			$next_run = $this->compute_next_run();
		}

		$this->next_run = $next_run;

		// deactivate successful non-recurring jobs
		if (!$this->is_recurring() && $this->result == true) {
			$this->is_active = false;
		}

    	$this->last_run   = date('Y-m-d H:i:s');
    	$this->is_running = false;
    	$this->save();
    }

    /**
     * Returns true if the Job is the parent (master/controller) Job.
     *
     * @return bool
     */
    public function is_parent()
    {
    	$parent = $this->id == 1;

    	return $parent;
    }

    /**
     * Returns true if the Job is recurring.
     *
     * @return bool
     */
    public function is_recurring()
    {
		$recurring = !empty($this->expression);

		return $recurring;
    }

	/**
	 * Decrement date part
	 *
	 * @access	public
	 * @param	array		Cron formatted array
	 * @param	int		Index of date part to decrement
	 * @return	void
	 */
	function decrement(&$time_array, $segment)
	{
		$time_array[$segment] -= 1;

		if ($time_array[1] < 0) {$time_array[1] = 23; $time_array[2] -= 1;}
		if ($time_array[2] < 0) {$time_array[3] -= 1;}
		if ($time_array[3] < 0) {$time_array[3] = 12; $time_array[5] -= 1;}

		$last_dom = date('t', mktime(0,0,0,$time_array[3],$time_array[2],$time_array[5]));
		if ($time_array[2] < 0) {$time_array[2] = $last_dom;}
	}

	/**
	 * Increment date part
	 *
	 * @access	public
	 * @param	array		Cron formatted array
	 * @param	int		Index of date part to increment
	 * @return	void
	 */
	public function increment(&$time_array, $segment)
	{
		$time_array[$segment] += 1;

		$last_dom = date('t', mktime(0,0,0,$time_array[3],$time_array[2],$time_array[5]));

		if ($time_array[1] > 23) {$time_array[1] = 0; $time_array[2] += 1;}
		if ($time_array[2] > $last_dom) {$time_array[2] = 1; $time_array[3] += 1;}
		if ($time_array[3] > 12) {$time_array[3] = 1; $time_array[5] += 1;}
	}

	/**
	 * Find the next scheduled run time.
	 *
	 * @return string
	 */
	public function compute_next_run()
	{
		$cron = $this->expand($this->expression); // Expanded expression, all allowed numbers, no ranges or wildcards
		$next = explode(',', strftime('%M,%H,%d,%m,%w,%Y')); // Start from current time

		// Minutes -----
			$found = false;
			foreach($cron[0] as $minute) {if ($next[0] < $minute) {$next[0] = $minute; $found = true; break;}}
			if (! $found) {$next[0] = $cron[0][0]; $this->increment($next, 1);}

		// Hours -----
			$found = false;
			foreach($cron[1] as $hour) {if ($next[1] <= $hour) {$next[1] = $hour; $found = true; break;}}
			if (! $found) {$next[1] = $cron[1][0]; $this->increment($next, 2);}

		$attempts = 0;

		while (true)
		{
			$attempts += 1;
			$last_day = date('t', mktime(0,0,0,$next[3],$next[2],$next[5])); // Last day of the month

			// Days -----
				$found = false;
				foreach($cron[2] as $day) {if ($next[2] <= $day && $day <= $last_day) {$next[2] = $day; $found = true; break;}}
				if (! $found) {$next[2] = $cron[2][0]; $this->increment($next, 3);}
				$next[4] = date('w', mktime(0,0,0,$next[3],$next[2],$next[5])); // Update weekday

			// Months -----
				$found = false;
				foreach($cron[3] as $month) {if ($next[3] <= $month) {$next[3] = $month; $found = true; break;}}
				if (! $found) {$next[3] = $cron[3][0]; $this->increment($next, 5);}
				$next[4] = date('w', mktime(0,0,0,$next[3],$next[2],$next[5])); // Update weekday

			if (! in_array($next[4], $cron[4])) // Check weekday
			{
				$this->increment($next, 2, $last_day);
				$next[4] = date('w', mktime(0,0,0,$next[3],$next[2],$next[5])); // Update weekday
				continue;
			}

			if ($attempts > 100) // Probably invalid expression or too far into the future to care
			{
				Kohana::log('error', 'Cron: Could not parse cron expression.');
				return false;
			}

			// If the date is not valid increment the day and try again
			if (checkdate($next[3], $next[2], $next[5])) {break;} else {$this->increment($next, 2);}
		}

		$timestamp = mktime($next[1], $next[0], 0, $next[3], $next[2], $next[5]); // Make time

		return date('Y-m-d H:i:s', $timestamp);
	}


	/**
	 * Expand a cron-expression into full array of allowed minutes, hours, days, months and weekdays
	 * No ranges or wildcards after this process
	 *
	 * @access	public
	 * @param	string	The cron expression to be expanded
	 * @return	array
	 */
	public function expand($expression)
	{
		// Month and weekday english names
		static $keywords = array(
			'3' => array( // Months
				'/(january|jan)/i'=>'1',
				'/(february|feb)/i'=>'2',
				'/(march|mar)/i'=>'3',
				'/(april|apr)/i'=>'4',
				'/(may)/i'=>'5',
				'/(june|jun)/i'=>'6',
				'/(july|jul)/i'=>'7',
				'/(august|aug)/i'=>'8',
				'/(september|sep)/i'=>'9',
				'/(october|oct)/i'=>'10',
				'/(november|nov)/i'=>'11',
				'/(decemeber|dec)/i'=>'12'
			),
			'4' => array( // Weekdays
				'/(sunday|sun|su)/i'=>'0',
				'/(monday|mon|mo)/i'=>'1',
				'/(tuesday|tue|tu)/i'=>'2',
				'/(wednesday|wed|we)/i'=>'3',
				'/(thursday|thu|th)/i'=>'4',
				'/(friday|fri|fr)/i'=>'5',
				'/(saturday|sat|sa)/i'=>'6'
			)
		);

		// High and low ranges for each segment type
		static $ranges = array(
			'0'=>array(0,59),	// Minute
			'1'=>array(0,23),	// Hour
			'2'=>array(1,31),	// Day
			'3'=>array(1,12),	// Month
			'4'=>array(0,6)	// Weekday
		);

		$cron = preg_split('/\s/', $expression);

		if (count($cron) != count($ranges))
		{
			Kohana::log('error', 'Cron: Invalid number of segments in expression');
		}

		foreach($cron as $index=>&$segment)
		{
			$expanded = array();

			$parts = preg_split('/,/', $segment);
			foreach($parts as $part)
			{
				// Convert keywords to nubmers
				if (isset($keywords[$index])) {$part = preg_replace(array_keys($keywords[$index]), array_values($keywords[$index]), $part);}

				// Convert wildcards to ranges
				$part = preg_replace('/^\*(\/\d+)?$/i', $ranges[$index][0].'-'.$ranges[$index][1].'$1', $part);

				// Expand ranges
				if (preg_match('/^(\d+)-(\d+)(\/(\d+))?/i', $part, $matches))
				{
					$low = $matches[1];
					$high = $matches[2];
					$step = isset($matches[4]) ? $matches[4] : 1;

					for($i = $low; $i <= $high; $i += $step)
					{
						$expanded[] = $i;
					}
				}
				else
				{
					$expanded[] = $part;
				}
			}

			$expanded = array_unique($expanded);
			sort($expanded);

			$segment = $expanded;
		}

		return $cron;
	}

	public function save()
	{
		// if next_run is empty, try to set from the expression
		if (empty($this->next_run)) {
	    	$this->next_run = $this->compute_next_run();
		}

		parent::save();
	}

	/**
	 * Deletes completed at-jobs older than one week.
	 *
	 * @return bool
	 */
	public static function prune_completed()
	{
		ORM::factory('job')
			->where('expression IS NULL')
			->where('last_run <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
			->delete_all();

		return true;
	}
}
