-- Dumping database structure for movie_theater
CREATE DATABASE IF NOT EXISTS `movie_theater` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `movie_theater`;


-- Dumping structure for table movie_theater.dtb_cinemas
CREATE TABLE IF NOT EXISTS `dtb_cinemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `total_seat` smallint(6) NOT NULL,
  `seat_in_row` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_customer
CREATE TABLE IF NOT EXISTS `dtb_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_movies
CREATE TABLE IF NOT EXISTS `dtb_movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `description` text,
  `actor` varchar(100) DEFAULT NULL,
  `year` varchar(5) DEFAULT NULL,
  `durations` int(5) DEFAULT NULL,
  `trailer` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_movie_cinemas
CREATE TABLE IF NOT EXISTS `dtb_movie_cinemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `cinema_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `cinema_id` (`cinema_id`),
  CONSTRAINT `dtb_movie_cinemas_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `dtb_movies` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `dtb_movie_cinemas_ibfk_2` FOREIGN KEY (`cinema_id`) REFERENCES `dtb_cinemas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_performances
CREATE TABLE IF NOT EXISTS `dtb_performances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `performance_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_rate
CREATE TABLE IF NOT EXISTS `dtb_rate` (
  `customer_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `cinema_id` int(11) NOT NULL,
  `date_rate` date NOT NULL,
  `rate_times` smallint(6) DEFAULT NULL,
  `rate` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`,`movie_id`,`cinema_id`),
  KEY `customer_id` (`customer_id`),
  KEY `movie_id` (`movie_id`),
  KEY `cinema_id` (`cinema_id`),
  CONSTRAINT `dtb_rate_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `dtb_customer` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `dtb_rate_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `dtb_movies` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `dtb_rate_ibfk_3` FOREIGN KEY (`cinema_id`) REFERENCES `dtb_cinemas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_seats
CREATE TABLE IF NOT EXISTS `dtb_seats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `row` smallint(6) NOT NULL,
  `column` smallint(6) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'NORMAL',
  `cinema_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cinema_id` (`cinema_id`),
  CONSTRAINT `dtb_seats_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `dtb_cinemas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_showtimes
CREATE TABLE IF NOT EXISTS `dtb_showtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_cinema_id` int(11) NOT NULL,
  `performance_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `movie_cinema_id` (`movie_cinema_id`),
  KEY `performance_id` (`performance_id`),
  CONSTRAINT `dtb_showtimes_ibfk_1` FOREIGN KEY (`movie_cinema_id`) REFERENCES `dtb_movie_cinemas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `dtb_showtimes_ibfk_2` FOREIGN KEY (`performance_id`) REFERENCES `dtb_performances` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table movie_theater.dtb_tickets
CREATE TABLE IF NOT EXISTS `dtb_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seat_id` int(11) NOT NULL,
  `showtime_id` int(11) NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seat_id_showtime_id` (`seat_id`,`showtime_id`),
  KEY `seat_id` (`seat_id`),
  KEY `showtime_id` (`showtime_id`),
  CONSTRAINT `dtb_tickets_ibfk_1` FOREIGN KEY (`seat_id`) REFERENCES `dtb_seats` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `dtb_tickets_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `dtb_showtimes` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
