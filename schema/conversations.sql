CREATE TABLE IF NOT EXISTS conversations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    started_at DATETIME NOT NULL,
    account_id int NOT NULL REFERENCES accounts(`id`),
    buddy_id int NOT NULL REFERENCES buddies(`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
