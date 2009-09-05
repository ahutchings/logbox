CREATE TABLE IF NOT EXISTS messages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    conversation_id int NOT NULL REFERENCES conversations(`id`),
    sent_at DATETIME NOT NULL,
    sender VARCHAR(255) NOT NULL,
    recipient VARCHAR(255) NOT NULL,
    recipient_friendlyname VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
