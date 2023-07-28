-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour siteblacklions
CREATE DATABASE IF NOT EXISTS `siteblacklions` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `siteblacklions`;

-- Listage de la structure de table siteblacklions. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table siteblacklions.doctrine_migration_versions : ~2 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230707073153', '2023-07-07 07:31:58', 32),
	('DoctrineMigrations\\Version20230707124750', '2023-07-07 12:47:55', 30);

-- Listage de la structure de table siteblacklions. event
CREATE TABLE IF NOT EXISTS `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nb_max_pers` int NOT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `is_lock` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3BAE0AA7A76ED395` (`user_id`),
  CONSTRAINT `FK_3BAE0AA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.event : ~7 rows (environ)
INSERT INTO `event` (`id`, `nb_max_pers`, `date_create`, `name`, `description`, `poster`, `user_id`, `is_lock`) VALUES
	(7, 30, '2023-06-30 00:00:00', 'attack & annihilate', 'ac turpis egestas integer eget aliquet nibh praesent tristique magna sit amet purus gravida quis blandit turpis cursus in hac habitasse platea dictumst quisque sagittis purus sit amet volutpat consequat mauris nunc congue nisi vitae suscipit tellus mauris a diam maecenas sed enim ut sem viverra aliquet eget sit amet', 'hhrtrt-6491db9de181f.jpg', NULL, 1),
	(9, 10, '2023-06-29 00:00:00', 'search & destroy', 'consequat mauris nunc congue nisi vitae suscipit tellus mauris a diam maecenas sed enim ut sem viverra aliquet eget sit amet tellus cras adipiscing enim eu turpis egestas pretium aenean pharetra magna ac placerat vestibulum lectus mauris ultrices eros in cursus turpis massa tincidunt dui ut ornare lectus sit amet', 'equipement-airsoft1-649179996780f.jpg', NULL, 1),
	(10, 5, '2023-09-01 00:00:00', 'R&D Reseach & Destroy', 'orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales', '43-z8hcvs-64bd0bb7c2962.jpg', NULL, 0),
	(12, 10, '2023-06-29 00:00:00', 'Défense de position', 'turpis nunc eget lorem dolor sed viverra ipsum nunc aliquet bibendum enim facilisis gravida neque convallis a cras semper auctor neque vitae tempus quam pellentesque nec nam aliquam sem et tortor consequat id porta nibh venenatis cras sed felis eget velit aliquet sagittis id consectetur purus ut faucibus pulvinar elementum', 'equipement-airsoft1-649179996780f.jpg', NULL, 1),
	(13, 5, '2023-07-28 00:00:00', 'Affrontement Total', 'neque gravida in fermentum et sollicitudin ac orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla facilisi cras fermentum odio eu feugiat pretium nibh ipsum consequat nisl vel pretium lectus quam id leo in vitae turpis massa sed elementum tempus egestas sed sed risus pretium quam vulputate', 'atrAQhD-64bd0bc645b54.jpg', NULL, 0),
	(14, 4, '2023-08-25 00:00:00', 'Assaut sur l\'ennemi', 'rhoncus est pellentesque elit ullamcorper dignissim cras tincidunt lobortis feugiat vivamus at augue eget arcu dictum varius duis at consectetur lorem donec massa sapien faucibus et molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan in nisl nisi scelerisque eu ultrices vitae auctor eu augue ut lectus arcu bibendum', 'entraide-64bd0ba122193.jpg', NULL, 0),
	(15, 40, '2023-08-24 00:00:00', 'Infiltration', 'massa sapien faucibus et molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan in nisl nisi scelerisque eu ultrices', 'airsoft-64a7fcba5b782.jpg', NULL, 0);

-- Listage de la structure de table siteblacklions. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `received_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FB821E5F5` (`received_id`),
  CONSTRAINT `FK_B6BD307FB821E5F5` FOREIGN KEY (`received_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.message : ~4 rows (environ)
INSERT INTO `message` (`id`, `sender_id`, `received_id`, `title`, `text`, `created_at`, `is_read`) VALUES
	(5, 14, 14, 'hihi', 'hihi', '2023-07-07 09:23:29', 1),
	(6, 14, 5, 'haha', 'haha', '2023-07-07 09:32:35', 1),
	(7, 14, 14, 'test lu', 'testtes', '2023-07-07 12:12:29', 0),
	(8, 14, 14, 'Fabien la licorne', 'venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non enim praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia', '2023-07-12 19:57:47', 1);

-- Listage de la structure de table siteblacklions. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table siteblacklions. multimedia
CREATE TABLE IF NOT EXISTS `multimedia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `media` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6131286371F7E88B` (`event_id`),
  CONSTRAINT `FK_6131286371F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.multimedia : ~26 rows (environ)
INSERT INTO `multimedia` (`id`, `media`, `event_id`) VALUES
	(1, 'atrAQhD-647cee8b73805.jpg', 9),
	(10, 'Airsoft-Trailer-OP-Gorgon-Theater-Bonus-60-FPS-64804d8074445.mp4', 12),
	(11, 'Airsoft-Francais-OP-Dark-Time-Trailer-onlinevideoconverter-com-64804d807f841.mp4', 14),
	(12, 'Stirling-Airsoft-s-Operation-Empire-Trailer-onlinevideoconverter-com-64804d8080213.mp4', 7),
	(13, 'Trailer-Operation-Casablanca-Airsoft-onlinevideoconverter-com-64804d8080b8a.mp4', 10),
	(14, 'UBISOFT-Division-2-Trailer-Airsoft-OP-by-Overwatch-Tactics-and-Breachpoint-Productions-KWA-onlinevideoconverter-com-64804d808147d.mp4', 13),
	(15, 'atrAQhD-64804f3c75e55.jpg', 12),
	(16, 'DutKdp7WsAQ37Za-64804f3c76423.jpg', 14),
	(17, 'hhrtrt-64804f3c76871.jpg', 7),
	(18, 'op-64804f3c76c65.jpg', 10),
	(19, 'airsoft-64817f108faee.jpg', 10),
	(20, 'airsoft-quoi-64808eb714a36.jpg', 13),
	(21, 'Combatants-airsoft-64808eb715089.jpg', 9),
	(22, 'equipement-airsoft1-64808eb7155fe.jpg', 12),
	(23, 'pexels-aaron-ulsh-2882660-649ace534c21b.jpg', 9),
	(24, 'pexels-artem-lysenko-1499341-649ace534cc17.jpg', 9),
	(25, 'pexels-asad-photo-maldives-1450353-649ace5fe054d.jpg', 12),
	(26, 'pexels-asad-photo-maldives-3250614-649ace5fe0f9c.jpg', 12),
	(27, 'pexels-asad-photo-maldives-3601425-649ace6cdb80e.jpg', 14),
	(28, 'pexels-daniel-jurin-1835718-649ace6cdc2c9.jpg', 14),
	(29, 'pexels-darwis-alwan-1817048-649ace7abb8d7.jpg', 7),
	(30, 'pexels-herman-io-3556117-649ace7abc194.jpg', 7),
	(31, 'pexels-jess-loiterton-4321802-649ace86c5139.jpg', 10),
	(32, 'pexels-jess-loiterton-4602279-649ace86c5a1d.jpg', 10),
	(33, 'pexels-life-of-pix-62389-649ace9295d08.jpg', 13),
	(34, 'pexels-maria-isabella-bernotti-1049298-649ace9296d2b.jpg', 13);

-- Listage de la structure de table siteblacklions. participate
CREATE TABLE IF NOT EXISTS `participate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_regis` datetime NOT NULL,
  `event_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D02B13871F7E88B` (`event_id`),
  KEY `IDX_D02B138A76ED395` (`user_id`),
  CONSTRAINT `FK_D02B13871F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `FK_D02B138A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.participate : ~20 rows (environ)
INSERT INTO `participate` (`id`, `date_regis`, `event_id`, `user_id`) VALUES
	(34, '2023-06-20 09:58:41', 7, 5),
	(35, '2023-06-20 12:09:36', 9, 7),
	(36, '2023-06-20 12:09:47', 7, 8),
	(37, '2023-06-20 12:09:36', 9, 6),
	(40, '2023-06-20 12:10:24', 12, 7),
	(43, '2023-06-20 12:10:24', 12, 8),
	(44, '2023-06-20 12:09:47', 7, 6),
	(45, '2023-06-20 12:16:58', 10, 6),
	(47, '2023-06-20 12:17:20', 13, 8),
	(49, '2023-06-20 12:16:58', 10, 7),
	(52, '2023-06-20 12:17:20', 13, 6),
	(53, '2023-06-20 12:17:20', 13, 7),
	(54, '2023-06-20 19:05:58', 14, 7),
	(55, '2023-06-20 19:05:58', 14, 6),
	(57, '2023-06-20 19:05:58', 14, 8),
	(60, '2023-07-05 20:26:01', 9, 14),
	(62, '2023-07-06 13:22:06', 12, 14),
	(68, '2023-07-13 22:06:18', 13, 14),
	(74, '2023-07-19 20:26:44', 10, 5),
	(75, '2023-07-23 18:04:31', 15, 14);

-- Listage de la structure de table siteblacklions. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `created_date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  KEY `IDX_5A8A6C8D71F7E88B` (`event_id`),
  CONSTRAINT `FK_5A8A6C8D71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.post : ~3 rows (environ)
INSERT INTO `post` (`id`, `user_id`, `event_id`, `created_date`, `content`) VALUES
	(1, 6, 9, '2023-07-06 20:06:23', 'hello'),
	(2, 6, 9, '2023-07-06 20:06:30', 'test'),
	(5, 14, 13, '2023-07-12 20:29:33', 'gtfh');

-- Listage de la structure de table siteblacklions. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.reset_password_request : ~0 rows (environ)

-- Listage de la structure de table siteblacklions. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` date NOT NULL,
  `discord_nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `is_banned` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.user : ~6 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nickname`, `date_create`, `discord_nickname`, `is_verified`, `is_banned`) VALUES
	(5, 'admin@admin.fr', '["ROLE_ADMIN"]', '$2y$13$wl5OnHwoRc2YS6g48g8hN.6LRTrXgZtAqF.aFgC/g5r/n598porQG', 'admin', '2023-06-12', 'admindiscord', 1, 0),
	(6, 'pelo@test.fr', '[]', '$2y$13$dr8Lp440tZtKzwa2nqUZYeSLTs884kFGHINde3UrjocJAqBRGdNLS', 'pelo', '2023-01-31', 'peloty', 1, 0),
	(7, 'donploto@test.fr', '[]', '$2y$13$owQrHgCXAmbLRkfjl6QzjeTyonNvH6GbOibK/gMipAwuGbNtZaxN6', 'Don Ploto', '2023-03-05', 'Don Ploto', 0, 0),
	(8, 'test2@test.fr', '[]', '$2y$13$QjfTliZoqHy87GbGswWN7uIob0qThUm4hjGr6E7Y0GhQggXcL3cny', 'test2', '2023-06-04', 'test2', 1, 0),
	(14, 'test@test.fr', '[]', '$2y$13$fvmN5rHyUNs4/dJGfunA9ORGQumnPMSY3.tm2r2kBYDFBVRug4O3G', 'test', '2023-06-23', 'test', 1, 0),
	(15, 'test@test.com', '[]', '$2y$13$LuLzmAD08m2COXHTb6kWbeC4DfOPqQEbxVZGFCMx3i7ROwhAlhAKq', 'test', '2023-06-25', 'pluto', 0, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
