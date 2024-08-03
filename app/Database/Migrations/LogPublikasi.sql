CREATE TABLE `LogPublikasi`(
    `user_id` INT UNSIGNED NOT NULL,
    `publikasi_id` INT UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT NOW(),
    `action` ENUM('C', 'R', 'U', 'D'),
    `value_before` TEXT,
    `value_after` TEXT
);