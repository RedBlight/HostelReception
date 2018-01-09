-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 08 Oca 2018, 04:12:57
-- Sunucu sürümü: 5.5.52-cll
-- PHP Sürümü: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `reception`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fee`
--

CREATE TABLE IF NOT EXISTS `fee` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id // 5',
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'fee name // Room Fee',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='fee types' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `fee`
--

INSERT INTO `fee` (`id`, `name`) VALUES
(1, 'Room Fee');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `finance`
--

CREATE TABLE IF NOT EXISTS `finance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id // 5',
  `class` tinyint(3) unsigned NOT NULL COMMENT 'fee or payment 0:fee 1:payment // 0',
  `type` mediumint(8) unsigned NOT NULL COMMENT 'type id // 5',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'description // 3 kola',
  `date` int(10) unsigned NOT NULL COMMENT 'payment date // 20140621',
  `reservation` int(10) unsigned NOT NULL COMMENT 'reservation id // 5',
  `amount` int(11) NOT NULL COMMENT 'amount of payment // -1250',
  `currency` enum('TL','$','€','£') COLLATE utf8_unicode_ci NOT NULL COMMENT 'currency // $',
  `done` tinyint(3) unsigned NOT NULL COMMENT 'is paid? 0:unpaid 1:paid // 1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='holds financial data' AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `finance`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'useless id // 1',
  `option` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'bools for option opt:opt // 1:0:1:1:0',
  `forex` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'forex rate for $:€:£ // 2.21:3.05:3.74',
  `ordroom` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'order of undeleted room ids id:id:id // 5:2:3:7',
  `ordsource` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'order of undeleted source ids id:id:id // 5:2:3:7',
  `ordfee` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'order of undeleted fee ids id:id:id // 5:2:3:7',
  `ordpayment` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'order of undeleted payment ids id:id:id // 5:2:3:7',
  `cuser` int(10) unsigned NOT NULL COMMENT 'last id of user',
  `croom` int(10) unsigned NOT NULL COMMENT 'last id of room',
  `creservation` int(10) unsigned NOT NULL COMMENT 'last id of reservation',
  `cpeople` int(10) unsigned NOT NULL COMMENT 'last id of people',
  `csource` int(10) unsigned NOT NULL COMMENT 'last id of source',
  `cfee` int(10) unsigned NOT NULL COMMENT 'last id of fee',
  `cpayment` int(10) unsigned NOT NULL COMMENT 'last id of payment',
  `cfinance` int(10) unsigned NOT NULL COMMENT 'last id of finance',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='holds main data of system' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `main`
--

INSERT INTO `main` (`id`, `option`, `forex`, `ordroom`, `ordsource`, `ordfee`, `ordpayment`, `cuser`, `croom`, `creservation`, `cpeople`, `csource`, `cfee`, `cpayment`, `cfinance`) VALUES
(1, '1:1:1', '2.91:3.08:4.38', '1:2:3', '1:2:3', '1', '1:2:3:4:5', 1, 3, 0, 0, 3, 1, 5, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'note id // 5',
  `note` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'note body // 103''teki problemi halletmeyi unutmayın.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='notes' AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `note`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id // 5',
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'payment name // Kira',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='payment types' AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `payment`
--

INSERT INTO `payment` (`id`, `name`) VALUES
(1, 'Breakfast Expenses'),
(2, 'ADSL'),
(3, 'Bills'),
(4, 'Rent'),
(5, 'Employee Wage');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id // 5',
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'first-last name // John Doe',
  `passport` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'passport no // 192AD556Q',
  `country` smallint(5) unsigned NOT NULL COMMENT 'country enum // 35',
  `birth` int(10) unsigned NOT NULL COMMENT 'birthdate // 19950812',
  `reservation` int(10) unsigned NOT NULL COMMENT 'reservation id // 41',
  `checkin` int(10) unsigned NOT NULL COMMENT 'checkin date // 20140621',
  `checkout` int(10) unsigned NOT NULL COMMENT 'checkout date // 20140621',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='holds people info' AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `people`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'reservation id // 53',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'description // bu adamlara dikkat',
  `stay` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'staying days and rooms day.room:day.room // 20140621.12:20140622:1',
  `people` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'people ids of this reservation // 56.57.59',
  `fee` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'fee ids // 98.99.112',
  `source` mediumint(8) unsigned NOT NULL COMMENT 'source id // 4',
  `status` tinyint(3) unsigned NOT NULL COMMENT 'arrival status 0:not arrived 1:checkin 2:checkout 3:cancelled // 2',
  `allfeepaid` tinyint(3) unsigned NOT NULL COMMENT 'all fees paid 0:unpaid 1:paid // 1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='reservation data' AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `reservation`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'room id // 5',
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'name // 101',
  `type` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'type // Double Room',
  `bed` smallint(5) unsigned NOT NULL COMMENT 'bed count // 4',
  `active` mediumint(8) unsigned NOT NULL COMMENT 'active reservations in room // 0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='holds room data' AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `room`
--

INSERT INTO `room` (`id`, `name`, `type`, `bed`, `active`) VALUES
(1, '101', 'Female Dormitory', 4, 12),
(2, '102', 'Double Room', 2, 6),
(3, '103', 'Double Room', 2, 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id // 5',
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'name // booking.com',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='booking sources' AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `source`
--

INSERT INTO `source` (`id`, `name`) VALUES
(1, 'Gmail'),
(2, 'Booking.com'),
(3, 'Trip Advisor');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `table`
--

CREATE TABLE IF NOT EXISTS `table` (
  `time` int(10) unsigned NOT NULL COMMENT 'entry date yyyymmdd // 20140621',
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'reservation ids id:id:id // 213:342:712',
  PRIMARY KEY (`time`),
  UNIQUE KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='holds reservations made for each day';

--
-- Tablo döküm verisi `table`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'user id // 5',
  `type` enum('Manager','Employee') COLLATE utf8_unicode_ci NOT NULL COMMENT 'user type // manager',
  `username` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'username // xxhos43',
  `passwordhash` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'password hash // algorithm:iteraiton:salt:hash',
  `cookeyhash` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'cookie key hash // algorithm:iteraiton:salt:hash',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`id`, `type`, `username`, `passwordhash`, `cookeyhash`) VALUES
(1, 'Manager', 'root', 'sha256:4096:xy5FxSIyV6Z11A6LK80UEsB8yLoGDDdF:u9eDgH9Wib+grIVeY9cf1PY+Thf3J4s/', 'sha256:1024:u3vsNxMliLwjO+CJNIlCOBRswcfkZ+FD:kaZse7yeScOHivyGqtPs12k1kAxr8khR');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
