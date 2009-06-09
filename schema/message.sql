CREATE TABLE IF NOT EXISTS message (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sent_at DATETIME NOT NULL,
    protocol VARCHAR(255) NOT NULL,
    sender VARCHAR(255) NOT NULL,
    recipient VARCHAR(255) NOT NULL,
    recipient_friendlyname VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
) ENGINE = InnoDB;
