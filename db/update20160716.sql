CREATE TABLE `dtb_order` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`customer_id` INT(11) NOT NULL DEFAULT '0',
	`order_name` VARCHAR(50) NOT NULL,
	`order_email` VARCHAR(50) NOT NULL,
	`order_tel` TEXT NOT NULL,
	`payment` FLOAT NOT NULL,
	`method` VARCHAR(20) NOT NULL,
	`date` DATE NOT NULL,
	`item` TEXT NOT NULL COMMENT 'ticket id -> seat',
	`content` TEXT NOT NULL,
	`exchange` FLOAT NOT NULL COMMENT '1USD = ? VND',
	`payment_dolar` FLOAT NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `FK_dtb_order_dtb_customer` (`customer_id`),
	CONSTRAINT `FK_dtb_order_dtb_customer` FOREIGN KEY (`customer_id`) REFERENCES `dtb_customer` (`id`) ON UPDATE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
