CREATE TABLE IF NOT EXISTS `notes`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `folder_id` INT UNSIGNED NOT NULL,
    `content` TEXT,
    `pinned` BOOL DEFAULT FALSE,
    `completed` BOOL DEFAULT FALSE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`folder_id`) REFERENCES `folders`(`id`) ON DELETE CASCADE
)