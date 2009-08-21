CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `params` text,
  `expression` varchar(255) DEFAULT NULL,
  `priority` tinyint(2) NOT NULL,
  `last_run` datetime DEFAULT NULL,
  `next_run` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_running` tinyint(1) NOT NULL DEFAULT '0',
  `result` tinyint(1) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `jobs` (`id`, `name`, `class`, `method`, `params`, `expression`, `priority`, `last_run`, `next_run`, `is_active`, `is_running`, `result`, `description`) VALUES
(1, 'master', 'Job_Model', 'run_master', NULL, '* * * * *', 10, '2009-07-31 00:41:01', '2009-07-31 00:42:00', 1, 0, 1, 'Master Job. Used to determine if cron is active.');