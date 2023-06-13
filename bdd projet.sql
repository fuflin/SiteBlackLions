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
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table siteblacklions.doctrine_migration_versions : ~4 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230526142132', '2023-05-26 14:21:54', 87),
	('DoctrineMigrations\\Version20230531084758', '2023-05-31 08:48:48', 234),
	('DoctrineMigrations\\Version20230605090049', '2023-06-05 09:01:02', 60),
	('DoctrineMigrations\\Version20230612122804', '2023-06-13 06:39:28', 129);

-- Listage de la structure de table siteblacklions. event
CREATE TABLE IF NOT EXISTS `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nb_max_pers` int NOT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3BAE0AA7A76ED395` (`user_id`),
  CONSTRAINT `FK_3BAE0AA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.event : ~3 rows (environ)
INSERT INTO `event` (`id`, `nb_max_pers`, `date_create`, `name`, `description`, `poster`, `user_id`) VALUES
	(1, 20, '2023-06-18 00:00:00', 'Initiation DELTA Forces', 'Engagez vous avec une unité d\'élite: la DELTA Force. Votre objectif sera des les accompagner, les soutenir et les aider dans l\'accomplissement de leurs divers objectifs. Vous expérimenterez l\'univers impitaoyable de la guerre et découvrirez l\'envers du décor. Soyez prêts', '360-F-53893908-cS4Xg8Yaq1XgtJaaAH4xaB85aSkpo4CH-64881d5811430.jpg', NULL),
	(2, 15, '2023-06-04 00:00:00', 'Recherche dans la Forêt', 'Vous êtes une escouade en recherche d\'un objectif en pleine forêt. Vous devez accomplir votre objectif coûte que coûte, faute de cela seule la mort vous attends. Soyez vigilants et bonne chance.', 'wp2650500-6481816a8639e.jpg', NULL),
	(6, 35, '2023-07-28 00:00:00', 'Assaut nocturne', 'Infiltrez-vous dans la base ennemi à la tombé de la nuit, vous devrez éliminer les cibles et récupérer des objectifs pour pouvoir accomplir votre mission', 'cqb-airsoft-800x800-6481935ea3c58.jpg', NULL);

-- Listage de la structure de table siteblacklions. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.multimedia : ~11 rows (environ)
INSERT INTO `multimedia` (`id`, `media`, `event_id`) VALUES
	(33, 'UBISOFT-Division-2-Trailer-Airsoft-OP-by-Overwatch-Tactics-and-Breachpoint-Productions-KWA-onlinevideoconverter-com-64804d808147d.mp4', NULL),
	(34, 'Trailer-Operation-Casablanca-Airsoft-onlinevideoconverter-com-64804d8080b8a.mp4', NULL),
	(35, 'Stirling-Airsoft-s-Operation-Empire-Trailer-onlinevideoconverter-com-64804d8080213.mp4', NULL),
	(36, 'Airsoft-Trailer-OP-Gorgon-Theater-Bonus-60-FPS-64804d8074445.mp4', NULL),
	(37, 'Airsoft-Francais-OP-Dark-Time-Trailer-onlinevideoconverter-com-64804d807f841.mp4', NULL),
	(39, 'airsoft-64817f108faee.jpg', NULL),
	(40, 'airsoft-quoi-64817f10900c3.jpg', NULL),
	(41, 'Combatants-airsoft-64817f109053e.jpg', NULL),
	(46, 'wp2650500-6481816a8639e.jpg', NULL),
	(47, '360-F-53893908-cS4Xg8Yaq1XgtJaaAH4xaB85aSkpo4CH-648818f3b3f8b.jpg', NULL),
	(48, 'cqb-airsoft-800x800-648818f3b4594.jpg', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.participate : ~7 rows (environ)
INSERT INTO `participate` (`id`, `date_regis`, `event_id`, `user_id`) VALUES
	(4, '2023-06-13 06:55:17', 2, 3),
	(6, '2023-06-13 06:55:42', 1, 3),
	(7, '2023-06-13 06:56:51', 6, 3),
	(9, '2023-06-13 06:57:48', 2, 2),
	(20, '2023-06-13 12:35:23', 1, 4),
	(21, '2023-06-13 12:35:24', 2, 4),
	(25, '2023-06-13 12:36:38', 6, 4);

-- Listage de la structure de table siteblacklions. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.reset_password_request : ~0 rows (environ)

-- Listage de la structure de table siteblacklions. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` date NOT NULL,
  `discord_nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table siteblacklions.user : ~3 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nickname`, `date_create`, `discord_nickname`, `is_verified`) VALUES
	(2, 'admin@admin.fr', '["ROLE_ADMIN"]', '$2y$13$qbq1eUwI0xacOVsZrNY5COVuUOtFlYdK.G/VvQOoQ12oJnRWbu6vu', 'Admin', '2023-05-26', NULL, 1),
	(3, 'test@test.fr', '[]', '$2y$13$LP9wYkVNqB/8YRW/etfsB.mmKevBWIMrg4plkOISm7QiyeEW5af8G', 'test1', '2023-06-06', 'testeur', 0),
	(4, 'test@test.com', '[]', '$2y$13$/5N7Xoo9R.mxgWuFtAOrNOsbv78nEDlcZDsYus7gCArt2w5qy97I.', 'test1', '2023-06-08', 'testdiscord', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
