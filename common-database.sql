-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 16 juil. 2018 à 14:54
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `common-database`
--
CREATE DATABASE IF NOT EXISTS `common-database` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `common-database`;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_tweet` int(11) NOT NULL,
  `content_comment` varchar(140) DEFAULT NULL,
  `date_comment` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_comment` tinyint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_comment`),
  KEY `fk_comment_user1_idx` (`id_user`),
  KEY `fk_comment_tweet1_idx` (`id_tweet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `id_followed` int(11) NOT NULL,
  `id_follower` int(11) NOT NULL,
  `status_follow` tinyint(5) NOT NULL DEFAULT '1',
  KEY `fk_follow_user2_idx` (`id_follower`),
  KEY `fk_follow_user1_idx` (`id_followed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `hashtag`
--

DROP TABLE IF EXISTS `hashtag`;
CREATE TABLE IF NOT EXISTS `hashtag` (
  `id_hashtag` int(11) NOT NULL AUTO_INCREMENT,
  `name_hashtag` varchar(255) NOT NULL,
  PRIMARY KEY (`id_hashtag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

DROP TABLE IF EXISTS `like`;
CREATE TABLE IF NOT EXISTS `like` (
  `id_like` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_tweet` int(11) NOT NULL,
  `status_like` tinyint(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_like`),
  KEY `fk_like_user1_idx` (`id_user`),
  KEY `fk_like_tweet1_idx` (`id_tweet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT,
  `id_tweet` int(11) NOT NULL,
  `name_media` varchar(255) DEFAULT NULL,
  `file_media` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_media`),
  KEY `fk_media_tweet_idx` (`id_tweet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `content_message` text,
  `date_message` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_message` tinyint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message`),
  KEY `fk_message_user1_idx` (`id_sender`),
  KEY `fk_message_user2_idx` (`id_receiver`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `retweet`
--

DROP TABLE IF EXISTS `retweet`;
CREATE TABLE IF NOT EXISTS `retweet` (
  `id_retweet` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_tweet` int(11) NOT NULL,
  `date_retweet` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_retweet` tinyint(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_retweet`),
  KEY `fk_retweet_user1_idx` (`id_user`),
  KEY `fk_retweet_tweet1_idx` (`id_tweet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tweet`
--

DROP TABLE IF EXISTS `tweet`;
CREATE TABLE IF NOT EXISTS `tweet` (
  `id_tweet` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `content_tweet` varchar(140) DEFAULT NULL,
  `date_tweet` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_tweet` tinyint(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tweet`),
  KEY `fk_tweet_user1_idx` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tweet_to_tag`
--

DROP TABLE IF EXISTS `tweet_to_tag`;
CREATE TABLE IF NOT EXISTS `tweet_to_tag` (
  `id_tweet` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `status_ttt` int(11) NOT NULL DEFAULT '1',
  KEY `id_tweet` (`id_tweet`),
  KEY `id_tag` (`id_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `theme` varchar(255) NOT NULL DEFAULT '#1da1f2',
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
