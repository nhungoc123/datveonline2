
--
-- Database: `movie_theater`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_cinemas` (IN `p_name` VARCHAR(50), IN `p_description` TEXT, IN `p_total_seat` INT, IN `p_seat_in_row` INT, IN `p_row` INT, OUT `p_result` TINYINT, OUT `p_id` INT)  BEGIN
	DECLARE v_i integer default 1;
	DECLARE v_j integer default 1;
	DECLARE v_id integer default 0;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
	ROLLBACK;
	SET p_result = 1;     -- lỗi xảy ra
    SET p_id = 0;
	END;

	START TRANSACTION;
	-- thêm dữ liệu vào bảng cinemas
	insert into dtb_cinemas (`name`,`description`,`seat_in_row`,`total_seat`,`created_at`) values (p_name,p_description,p_seat_in_row,p_total_seat,now());
	
	-- lấy giá trị id vừa thêm vào bảng cinemas
	SET v_id = LAST_INSERT_ID();
	while v_i <= p_row do
		SET v_j = 1;
		while v_j <= p_seat_in_row do
			insert into dtb_seats (`row`,`column`,`cinema_id`,`created_at`) values (v_i,v_j,v_id,now());
			set v_j=v_j+1;
		end while;
		set v_i=v_i+1;
	end while;

	COMMIT;
	SET p_result = 0;     -- mọi thứ thành công
    set p_id = v_id;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_showtimes` (IN `p_movie_cinema_id` INT, IN `p_performance_id` INT, IN `p_status` VARCHAR(30), IN `p_price` FLOAT, OUT `p_result` TINYINT, OUT `p_id` INT)  BEGIN
DECLARE v_showtime_id integer default 0;
DECLARE v_seat_id integer default 0;
DECLARE v_done int default false;
DECLARE v_start_date date;
DECLARE v_end_date date;

DECLARE c_seats CURSOR FOR 
select s.id from dtb_seats s
left join dtb_movie_cinemas mc on mc.cinema_id = s.cinema_id
where mc.id = p_movie_cinema_id;

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
ROLLBACK;
SET p_result = 1; -- có lỗi xảy ra
SET p_id = 0;
END;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = true;

START TRANSACTION;
-- thêm dữ liệu vào bảng showtimes

insert into dtb_showtimes (`movie_cinema_id`,`performance_id`,`created_at`) values (p_movie_cinema_id,p_performance_id,now());


-- lấy giá trị id vừa thêm vào bảng showtimes

SET v_showtime_id = LAST_INSERT_ID();

SELECT `start_date`, `end_date` into v_start_date, v_end_date FROM `dtb_movie_cinemas` where `id` = p_movie_cinema_id;


-- tự động tạo vé trong bảng tickets
while v_start_date <= v_end_date do
	set v_done = false;
    -- bắt đầu cursor
    OPEN c_seats;
	
	  read_loop: LOOP
	  FETCH c_seats INTO v_seat_id;
	  IF v_done THEN
	  LEAVE read_loop;
	  END IF;

	  -- thêm dữ liệu vào bảng vé
	  INSERT INTO `dtb_tickets` (`seat_id`,`showtime_id`,`date`,`status`,`customer_id`,`price`,`created_at`,`updated_at`) 
	  VALUES(v_seat_id,v_showtime_id,v_start_date,p_status,'',p_price,now(),'');

	  END LOOP;

	CLOSE c_seats;
	-- kết thúc cursor
	set v_start_date = DATE_ADD(v_start_date, INTERVAL 1 DAY);
end while;
    


COMMIT;
SET p_result = 0; -- mọi thứ thành công
SET p_id = v_showtime_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_cinemas` (IN `p_id` INT, IN `p_name` VARCHAR(50), IN `p_description` TEXT, IN `p_total_seat` INT, IN `p_seat_in_row` INT, IN `p_row` INT, OUT `p_result` TINYINT)  BEGIN
	DECLARE v_i integer default 1;
	DECLARE v_j integer default 1;
    DECLARE v_row_old integer default 0;
    DECLARE v_column_old integer default 0;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
	ROLLBACK;
	SET p_result = 1;     -- lỗi xảy ra
	END;

	START TRANSACTION;
    -- lấy dữ liệu cũ
    select `total_seat`/`seat_in_row` , `seat_in_row` into v_row_old, v_column_old
    from dtb_cinemas
    where `id` = p_id;
    
    
	-- thêm dữ liệu vào bảng cinemas
	update dtb_cinemas set `name` = p_name,`description` = p_description,`seat_in_row` = p_seat_in_row,`total_seat` = p_total_seat,`updated_at` = now()
    where `id` = p_id;

	if v_row_old != p_row or v_column_old != p_seat_in_row then
        -- xóa dữ liệu ghế cũ
        delete from dtb_seats where cinema_id = p_id;
        
        -- thêm dữ liệu ghế mới
        while v_i <= p_row do
			SET v_j = 1;
			while v_j <= p_seat_in_row do
				insert into dtb_seats (`row`,`column`,`cinema_id`,`created_at`) values (v_i,v_j,p_id,now());
				set v_j=v_j+1;
			end while;
			set v_i=v_i+1;
		end while;
    end if;

	COMMIT;
	SET p_result = 0;     -- mọi thứ thành công
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_showtimes` (IN `p_id` INT, IN `p_movie_cinema_id` INT, IN `p_performance_id` INT, IN `p_status` VARCHAR(30), IN `p_price` FLOAT, OUT `p_result` TINYINT)  BEGIN
DECLARE v_movie_cinema_id_old integer default 0;
DECLARE v_seat_id integer default 0;
DECLARE v_done int default false;
DECLARE v_start_date date;
DECLARE v_end_date date;

DECLARE c_seats CURSOR FOR 
select s.id from dtb_seats s
left join dtb_movie_cinemas mc on mc.cinema_id = s.cinema_id
where mc.id = p_movie_cinema_id;

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
ROLLBACK;
SET p_result = 1; -- có lỗi xảy ra
END;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = true;

START TRANSACTION;

select `movie_cinema_id` into v_movie_cinema_id_old from dtb_showtimes where `id` = p_id;

-- thêm dữ liệu vào bảng showtimes
update dtb_showtimes set `movie_cinema_id` = p_movie_cinema_id,`performance_id` = p_performance_id,`updated_at` = now()
where `id` = p_id;



if p_movie_cinema_id != v_movie_cinema_id_old then

-- xóa dữ liệu cũ
delete from `dtb_tickets` where `showtime_id` = p_id;

SELECT `start_date`, `end_date` into v_start_date, v_end_date FROM `dtb_movie_cinemas` where `id` = p_movie_cinema_id;

-- tự động tạo vé trong bảng tickets
while v_start_date <= v_end_date do

	set v_done = false;
    -- bắt đầu cursor
    OPEN c_seats;
	
	  read_loop: LOOP
	  FETCH c_seats INTO v_seat_id;
	  IF v_done THEN
	  LEAVE read_loop;
	  END IF;

	  -- thêm dữ liệu vào bảng vé
	  INSERT INTO `dtb_tickets` (`seat_id`,`showtime_id`,`date`,`status`,`customer_id`,`price`,`created_at`,`updated_at`) 
	  VALUES(v_seat_id,p_id,v_start_date,p_status,'',p_price,now(),'');

	  END LOOP;

	CLOSE c_seats;
	-- kết thúc cursor
	set v_start_date = DATE_ADD(v_start_date, INTERVAL 1 DAY);
end while;

end if;

COMMIT;
SET p_result = 0; -- mọi thứ thành công
END$$

DELIMITER ;


--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- password: admin
REPLACE INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Nhu Ngoc', 'nhungoc@stu.vn', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '5B0nfMsB1hzPBGlosne4pXTlZTh3e6P4KWb8QfvrQ3QajTFybgtOk9ZItgE1', 'now()', 'now()'),
(3, 'Admin', 'admin@stu.vn', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', NULL, 'now()', 'now()');
