ALTER TABLE `dtb_tickets` ADD COLUMN `date` DATE NOT NULL AFTER `showtime_id`;
ALTER TABLE `dtb_tickets`
    DROP INDEX `seat_id_showtime_id`,
    ADD UNIQUE INDEX `seat_id_showtime_id` (`seat_id`, `showtime_id`, `date`);