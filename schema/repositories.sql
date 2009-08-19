CREATE TABLE `repositories` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`directory` varchar(255) NOT NULL,
`type` INT UNSIGNED NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;