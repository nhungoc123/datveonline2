ALTER TABLE `dtb_tickets`
    ADD COLUMN `price` FLOAT NULL AFTER `customer_id`;
ALTER TABLE `dtb_customer`
    ADD COLUMN `payment` FLOAT NULL AFTER `email`;
ALTER TABLE `dtb_rate`
    ADD COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT FIRST,
    DROP COLUMN `customer_id`,
    DROP COLUMN `movie_id`,
    DROP COLUMN `cinema_id`,
    DROP PRIMARY KEY,
    DROP INDEX `customer_id`,
    DROP INDEX `movie_id`,
    DROP INDEX `cinema_id`,
    ADD PRIMARY KEY (`id`),
    DROP FOREIGN KEY `dtb_rate_ibfk_3`,
    DROP FOREIGN KEY `dtb_rate_ibfk_2`,
    DROP FOREIGN KEY `dtb_rate_ibfk_1`;
    ADD COLUMN `movie_id` INT(11) NOT NULL AFTER `id`,