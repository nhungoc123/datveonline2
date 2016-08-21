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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_cinemas: ~2 rows (approximately)
DELETE FROM `dtb_cinemas`;
/*!40000 ALTER TABLE `dtb_cinemas` DISABLE KEYS */;
INSERT INTO `dtb_cinemas` (`id`, `name`, `description`, `total_seat`, `seat_in_row`, `created_at`, `updated_at`) VALUES
	(1, 'Red', 'Vip', 50, 10, '2016-06-03 08:11:47', '2016-06-09 15:18:23'),
	(2, 'Blue', 'Vip', 50, 10, '2016-06-03 08:11:47', '2016-06-09 15:18:23'),
	(3, 'Yellow', 'Vip', 50, 10, '2016-06-03 08:11:47', '2016-06-09 15:18:23');
/*!40000 ALTER TABLE `dtb_cinemas` ENABLE KEYS */;


-- Dumping structure for table movie_theater.dtb_customer
CREATE TABLE IF NOT EXISTS `dtb_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_customer: ~0 rows (approximately)
DELETE FROM `dtb_customer`;
/*!40000 ALTER TABLE `dtb_customer` DISABLE KEYS */;
INSERT INTO `dtb_customer` (`id`, `name`, `tel`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'Dung Le', '123456789', 'a@a.com', '2016-06-10 16:45:23', '2016-06-10 16:45:33'),
	(2, 'Nhu Ngoc', '123456789', 'aa@a.com', '2016-06-10 16:45:23', '2016-06-10 16:45:33');
/*!40000 ALTER TABLE `dtb_customer` ENABLE KEYS */;


-- Dumping structure for table movie_theater.dtb_movies
CREATE TABLE IF NOT EXISTS `dtb_movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `description` text,
  `actor` varchar(100) DEFAULT NULL,
  `year` varchar(5) DEFAULT NULL,
  `durations` int(5) DEFAULT NULL,
  `trailer` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_movies: ~5 rows (approximately)
DELETE FROM `dtb_movies`;
/*!40000 ALTER TABLE `dtb_movies` DISABLE KEYS */;
INSERT INTO `dtb_movies` (`id`, `name`, `genre`, `description`, `actor`, `year`, `durations`, `trailer`, `created_at`, `updated_at`, `image`) VALUES
	(1, 'Mỹ Nhân Ngư', 'Phim hài hước, Phim chiếu rạp, Phim lẻ', 'MỸ NHÂN NGƯ của Châu Tinh Trì lấy bối cảnh ở thời hiện đại. Phim xoay quanh chuyện tình cảm giữa cô người cá San San và doanh nhân trẻ thành đạt Lưu Hiên. Phim không chỉ hài hước còn mang nhiều giá trị nhân văn về tình yêu, cuộc sống và việc bảo vệ môi trường.', NULL, '2016', 93, 'https://www.youtube.com/embed/J2ccVB_4I44', '2016-06-09 15:02:46', '2016-06-09 15:08:46', '1.jpg'),
	(2, 'Tây Du Ký', ' Phiêu lưu - Hành động, Cổ Trang - Thần Thoại, Chiếu Rạp', 'Tây Du Ký 2: Ba Lần Đánh Bạch Cốt Tinh, The Monkey King 2 (2016)\r\n\r\nPhim Tây Du Ký 2: Tôn Ngộ Không 3 Lần Đánh Bạch Cốt Tinh VietSub - Thuyết Minh. Tây Du Ký 2 - Ba Lần Đánh Bạch Cốt Tinh được coi là một trong những kiếp nạn đáng nhớ nhất của thầy trò Đường Tăng trên đường đi thỉnh kinh.', 'Quách Phú Thành, Phùng Thiệu Phong, Củng Lợi', '2016', 120, 'https://youtu.be/gst0fLXk-iE', '2016-06-09 15:02:46', '2016-06-09 15:08:50', '2.jpg'),
	(3, 'Iron man 3', 'Hành động, Viễn Tưởng', 'Iron Man 3 (stylized onscreen as Iron Man Three) is a 2013 American[4] superhero film featuring the Marvel Comics character Iron Man, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures.1 It is the sequel to 2008\'s Iron Man and 2010\'s Iron Man 2, and the seventh film in the Marvel Cinematic Universe. Shane Black directed a screenplay he co-wrote with Drew Pearce, which uses concepts from the "Extremis" story arc by Warren Ellis. The film stars Robert Downey Jr., Gwyneth Paltrow, Don Cheadle, Guy Pearce, Rebecca Hall, Stephanie Szostak, James Badge Dale, Jon Favreau, and Ben Kingsley. In Iron Man 3, Tony Stark deals with posttraumatic stress disorder caused by the events of The Avengers, while investigating a terrorist organization led by the mysterious Mandarin.', 'Robert Downey Jr', '2016', 130, 'https://youtu.be/Ke1Y3P9D0Bc', '2016-06-09 15:02:46', '2016-06-09 15:17:53', '3.jpg'),
	(4, 'Iron man 2', 'Hành động, Viễn Tưởng', 'Iron Man  2 is a 2013 American[4] superhero film featuring the Marvel Comics character Iron Man, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures.1 It is the sequel to 2008\'s Iron Man and 2010\'s Iron Man 2, and the seventh film in the Marvel Cinematic Universe. Shane Black directed a screenplay he co-wrote with Drew Pearce, which uses concepts from the "Extremis" story arc by Warren Ellis. The film stars Robert Downey Jr., Gwyneth Paltrow, Don Cheadle, Guy Pearce, Rebecca Hall, Stephanie Szostak, James Badge Dale, Jon Favreau, and Ben Kingsley. In Iron Man 3, Tony Stark deals with posttraumatic stress disorder caused by the events of The Avengers, while investigating a terrorist organization led by the mysterious Mandarin.', 'Robert Downey Jr', '2013', 130, 'https://youtu.be/Ke1Y3P9D0Bc', '2016-06-09 15:02:46', '2016-06-09 16:33:10', '3.jpg'),
	(5, 'Iron man', 'Hành động, Viễn Tưởng', 'Iron Man is a 2013 American[4] superhero film featuring the Marvel Comics character Iron Man, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures.1 It is the sequel to 2008\'s Iron Man and 2010\'s Iron Man 2, and the seventh film in the Marvel Cinematic Universe. Shane Black directed a screenplay he co-wrote with Drew Pearce, which uses concepts from the "Extremis" story arc by Warren Ellis. The film stars Robert Downey Jr., Gwyneth Paltrow, Don Cheadle, Guy Pearce, Rebecca Hall, Stephanie Szostak, James Badge Dale, Jon Favreau, and Ben Kingsley. In Iron Man 3, Tony Stark deals with posttraumatic stress disorder caused by the events of The Avengers, while investigating a terrorist organization led by the mysterious Mandarin.', 'Robert Downey Jr', '2010', 130, 'https://youtu.be/Ke1Y3P9D0Bc', '2016-06-09 15:02:46', '2016-06-09 16:33:07', '3.jpg');
/*!40000 ALTER TABLE `dtb_movies` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_movie_cinemas: ~4 rows (approximately)
DELETE FROM `dtb_movie_cinemas`;
/*!40000 ALTER TABLE `dtb_movie_cinemas` DISABLE KEYS */;
INSERT INTO `dtb_movie_cinemas` (`id`, `movie_id`, `cinema_id`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2016-06-09', '2016-07-09', '2016-06-09 15:26:47', '2016-06-09 15:26:47'),
	(2, 2, 2, '2016-06-09', '2016-06-16', '2016-06-09 15:27:08', '2016-06-09 15:27:08'),
	(3, 3, 3, '2016-08-10', '2016-10-13', '2016-06-09 15:27:26', '2016-06-10 13:46:31'),
	(4, 4, 1, '2016-05-10', '2016-08-09', '2016-06-09 15:27:26', '2016-06-09 16:37:28'),
	(5, 5, 3, '2016-05-10', '2016-08-09', '2016-06-09 15:27:26', '2016-06-09 16:37:29');
/*!40000 ALTER TABLE `dtb_movie_cinemas` ENABLE KEYS */;


-- Dumping structure for table movie_theater.dtb_performances
CREATE TABLE IF NOT EXISTS `dtb_performances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `performance_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_performances: ~10 rows (approximately)
DELETE FROM `dtb_performances`;
/*!40000 ALTER TABLE `dtb_performances` DISABLE KEYS */;
INSERT INTO `dtb_performances` (`id`, `performance_time`, `created_at`, `updated_at`) VALUES
	(1, '08:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:52'),
	(2, '09:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:53'),
	(3, '12:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:48'),
	(4, '13:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:48'),
	(5, '15:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:48'),
	(6, '18:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:48'),
	(7, '19:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:48'),
	(8, '20:00:00', '2016-06-09 15:22:48', '2016-06-09 15:22:48'),
	(9, '21:00:00', '2016-06-09 15:22:48', '2016-06-09 15:23:10'),
	(10, '22:00:00', '2016-06-09 15:22:48', '2016-06-09 15:23:10'),
	(11, '23:00:00', '2016-06-09 15:22:48', '2016-06-09 15:23:21');
/*!40000 ALTER TABLE `dtb_performances` ENABLE KEYS */;


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

-- Dumping data for table movie_theater.dtb_rate: ~0 rows (approximately)
DELETE FROM `dtb_rate`;
/*!40000 ALTER TABLE `dtb_rate` DISABLE KEYS */;
INSERT INTO `dtb_rate` (`customer_id`, `movie_id`, `cinema_id`, `date_rate`, `rate_times`, `rate`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2016-06-10', 1, 5, '2016-06-10 16:46:12', '2016-06-10 16:46:12'),
	(1, 2, 2, '2016-06-10', 2, 4, '2016-06-10 16:46:12', '2016-06-10 16:46:12'),
	(2, 1, 1, '2016-06-10', 2, 4, '2016-06-10 16:46:12', '2016-06-10 16:46:12'),
	(2, 2, 2, '2016-06-10', 1, 4, '2016-06-10 16:46:12', '2016-06-10 16:46:12');
/*!40000 ALTER TABLE `dtb_rate` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_seats: ~2 rows (approximately)
DELETE FROM `dtb_seats`;
/*!40000 ALTER TABLE `dtb_seats` DISABLE KEYS */;
INSERT INTO `dtb_seats` (`id`, `row`, `column`, `type`, `cinema_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'NORMAL', 1, '2016-06-09 15:25:40', '2016-06-09 15:25:40'),
	(2, 1, 2, 'NORMAL', 1, '2016-06-09 15:25:40', '2016-06-09 15:25:40'),
	(3, 1, 3, 'NORMAL', 1, '2016-06-09 15:25:40', '2016-06-09 15:25:40');
/*!40000 ALTER TABLE `dtb_seats` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table movie_theater.dtb_showtimes: ~17 rows (approximately)
DELETE FROM `dtb_showtimes`;
/*!40000 ALTER TABLE `dtb_showtimes` DISABLE KEYS */;
INSERT INTO `dtb_showtimes` (`id`, `movie_cinema_id`, `performance_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2016-06-09 15:27:38', '2016-06-09 15:27:40'),
	(2, 1, 2, '2016-06-09 15:27:38', '2016-06-09 15:27:40'),
	(3, 1, 5, '2016-06-09 15:27:38', '2016-06-09 15:28:08'),
	(4, 1, 6, '2016-06-09 15:27:38', '2016-06-09 15:28:10'),
	(5, 1, 8, '2016-06-09 15:27:38', '2016-06-09 15:28:10'),
	(6, 1, 9, '2016-06-09 15:27:38', '2016-06-09 15:28:33'),
	(7, 1, 11, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(8, 2, 3, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(9, 2, 5, '2016-06-09 15:28:42', '2016-06-09 15:29:30'),
	(10, 2, 7, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(11, 2, 9, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(12, 3, 1, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(13, 3, 3, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(14, 3, 5, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(15, 3, 7, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(16, 3, 9, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(17, 3, 11, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(18, 4, 3, '2016-06-09 15:28:42', '2016-06-09 15:28:42'),
	(19, 5, 8, '2016-06-09 15:28:42', '2016-06-09 15:28:42');
/*!40000 ALTER TABLE `dtb_showtimes` ENABLE KEYS */;


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

-- Dumping data for table movie_theater.dtb_tickets: ~0 rows (approximately)
DELETE FROM `dtb_tickets`;
/*!40000 ALTER TABLE `dtb_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `dtb_tickets` ENABLE KEYS */;


-- Dumping structure for table movie_theater.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_theater.migrations: ~2 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2014_10_12_000000_create_users_table', 1),
	('2014_10_12_100000_create_password_resets_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Dumping structure for table movie_theater.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_theater.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;




-- Dumping structure for table movie_theater.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_theater.users: ~0 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'Nhu Ngoc', 'nhungoc@stu.vn', '$2y$10$7oHU9A1Jcv6WKyQMdvP2uulAzejancm0/ZbZmpUNxksWnQPEdVM4a', '5B0nfMsB1hzPBGlosne4pXTlZTh3e6P4KWb8QfvrQ3QajTFybgtOk9ZItgE1', '2016-06-01 03:21:00', '2016-06-02 02:00:23');
