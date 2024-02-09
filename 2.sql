CREATE TABLE `parks`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `address` VARCHAR(250) NOT NULL,
    `deleted` TINYINT(1) DEFAULT 0
);

CREATE TABLE `cars`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `park_id` INT UNSIGNED DEFAULT NULL,
    `model` VARCHAR(150) NOT NULL,
    `price` TINYINT(150) NOT NULL,
    `deleted` TINYINT(1) DEFAULT 0,
    FOREIGN KEY (`park_id`) REFERENCES `parks`(`id`) ON DELETE SET NULL
);

CREATE TABLE `drivers`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `car_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(150) NOT NULL,
    `deleted` TINYINT(1) DEFAULT 0,
    FOREIGN KEY (`car_id`) REFERENCES `cars`(`id`) ON DELETE CASCADE
);

CREATE TABLE `customers`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(150) DEFAULT NULL,
    `phone` VARCHAR(150) NOT NULL
);

CREATE TABLE `orders`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `customer_id` INT UNSIGNED NOT NULL,
    `driver_id` INT UNSIGNED NOT NULL,
    `start` CHAR DEFAULT NULL,
    `finish` CHAR DEFAULT NULL,
    `total` TINYINT(10) UNSIGNED NOT NULL,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`driver_id`) REFERENCES `drivers`(`id`) ON DELETE CASCADE
)ENGINE=InnoDB;

#1
DROP TABLE `orders`;
//
CREATE TABLE `orders`
(
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `customer_id` INT UNSIGNED NOT NULL,
    `driver_id` INT UNSIGNED NOT NULL,
    `start` CHAR DEFAULT NULL,
    `finish` CHAR DEFAULT NULL,
    `total` TINYINT(10) UNSIGNED NOT NULL,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`driver_id`) REFERENCES `drivers`(`id`) ON DELETE CASCADE
)ENGINE=InnoDB;

#2
ALTER TABLE orders MODIFY `start` VARCHAR(250) DEFAULT NULL;
alter table orders change `start` `started` varchar(250) DEFAULT null;
ALTER TABLE `orders` CHANGE `finish` `finished` VARCHAR(250) DEFAULT NULL;

#3
INSERT INTO `parks` (`address`) VALUES ('Park 1'),
                                       ('Park 2'),
                                       ('Park 3');
INSERT INTO `cars` (park_id, model, price) VALUES (1, 'Lanos', 10),
                                                  (1, 'Skoda', 13),
                                                  (1, 'VW', 15),
                                                  (3, 'Lanos', 10),
                                                  (3, 'Skoda', 13),
                                                  (3, 'VW', 15),
                                                  (3, 'Opel', 10),
                                                  (3, 'Ford', 13),
                                                  (3, 'VW', 15),
                                                  (1, 'Lanos', 10),
                                                  (1, 'Skoda', 13),
                                                  (1, 'VW', 15),
                                                  (3, 'Lanos', 10),
                                                  (3, 'Skoda', 13),
                                                  (3, 'VW', 15),
                                                  (3, 'Opel', 10),
                                                  (3, 'Ford', 13),
                                                  (3, 'VW', 15);
INSERT INTO `drivers` (`car_id`, `name`, `phone`) VALUES (10, 'Alex', '1'),
                                                         (11, 'Egor', '2'),
                                                         (11, 'Sasha', '9'),
                                                         (13, 'Dima', '3'),
                                                         (14, 'Dima', '4'),
                                                         (14, 'Taras', '10'),
                                                         (15, 'Denys', '5'),
                                                         (15, 'Oleksiy', '6'),
                                                         (18, 'Mykyta', '7');
INSERT INTO `customers` (`name`, `phone`) VALUES ('Anna', '0101'),
                                                 ('Alex', '0102'),
                                                 ('Denys', '0104'),
                                                 ('Mykola', '0105');
INSERT INTO `orders` (`driver_id`, `customer_id`, `started`, `finished`, `total`) VALUES (1, 1, 'A', 'B', 14),
                                                                                         (1, 3, 'C', 'A', 33),
                                                                                         (2, 1, 'B', 'G', 67),
                                                                                         (3, 2, 'Z', 'H', 154),
                                                                                         (6, 3, 'A', 'L', 80),
                                                                                         (8, 1, 'M', 'O', 34);

#4
UPDATE `parks` SET `address` = 'Car park 1' WHERE `id` = 1;

#5
DELETE FROM `cars` WHERE `id` < 10;

#6
SELECT * FROM `orders`;
SELECT `model`, SUM(`price`) FROM `cars` GROUP BY `model`;
SELECT * FROM `parks` WHERE `deleted` = 0;
SELECT `car_id`, COUNT(`name`) FROM `drivers` GROUP BY `car_id`;
SELECT `id`, `car_id`, `name`, `phone` as `contact` FROM `drivers` WHERE `name` IN ('Egor', 'Sasha', 'Dima')
AND `deleted` = 0 ORDER BY `car_id` DESC;
#7
SELECT * FROM `drivers` JOIN `cars` ON `drivers`.`car_id` = `cars`.`id`;

SELECT * FROM `cars` RIGHT JOIN `parks` ON `cars`.`park_id` = `parks`.`id`;

SELECT `o`.`id`, `c`.`name`, `c`.`phone`, `d`.`name`, `d`.`contact`, `started`, `finished`, `total` FROM `orders` `o`
JOIN `customers` `c` ON `customer_id` = `c`.`id`
JOIN `drivers` `d` ON `driver_id` = `d`.`id` AND `d`.`deleted` = 0;

SELECT `o`.`id`, `c`.`name`, `d`.`name`, `cars`.`model`, `total`, `p`.`address` FROM `orders` `o`
JOIN `customers` `c` ON `o`.`customer_id` = `c`.`id`
JOIN `drivers` `d` ON `o`.`driver_id` = `d`.`id` AND `d`.`deleted` = 0
JOIN `cars` ON `d`.`car_id` = `cars`.`id` AND `cars`.`deleted` = 0
JOIN `parks` `p` ON `cars`.`park_id` = `p`.`id` AND `p`.`deleted` = 0;

SELECT `name`, `contact`, `cars`.`id`, `model`, `price` FROM `cars`
LEFT JOIN `drivers` ON `cars`.`id` = `drivers`.`car_id`
WHERE `drivers`.`car_id` IS NULL;

#8
ALTER TABLE `drivers` CHANGE `phone` `contact` TINYINT(20) UNSIGNED NOT NULL;
alter table orders ADD `started_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `orders` ADD `finished_at` TIMESTAMP DEFAULT NULL;