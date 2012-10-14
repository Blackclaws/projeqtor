-- phpMyAdmin SQL Dump
-- version 3.2.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 14 Octobre 2011 à 14:26
-- Version du serveur: 5.1.37
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `projectorria_manual`
--

-- --------------------------------------------------------

--
-- Structure de la table `accessprofile`
--

CREATE TABLE IF NOT EXISTS `accessprofile` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idAccessScopeRead` int(12) DEFAULT NULL,
  `idAccessScopeCreate` int(12) DEFAULT NULL,
  `idAccessScopeUpdate` int(12) DEFAULT NULL,
  `idAccessScopeDelete` int(12) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `accessprofile`
--

INSERT INTO `accessprofile` (`id`, `name`, `description`, `idAccessScopeRead`, `idAccessScopeCreate`, `idAccessScopeUpdate`, `idAccessScopeDelete`, `sortOrder`, `idle`) VALUES
(1, 'accessProfileRestrictiedReader', 'Read only his projects', 3, 1, 1, 1, 100, 0),
(2, 'accessProfileGlobalReader', 'Read all projects', 4, 1, 1, 1, 150, 0),
(3, 'accessProfileRestrictedUpdater', 'Read and Update only his projects', 3, 1, 3, 1, 200, 0),
(4, 'accessProfileGlobalUpdater', 'Read and Update all projects', 4, 1, 4, 1, 250, 0),
(5, 'accessProfileRestricedCreator', 'Read only his projects\nCan create\nUpdate and delete his own elements', 3, 3, 2, 2, 300, 0),
(6, 'accessProfileGlobalCreator', 'Read all projects\nCan create\nUpdate and delete his own elements', 4, 4, 2, 2, 350, 0),
(7, 'accessProfileRestrictedManager', 'Read only his projects\nCan create\nUpdate and delete his projects', 3, 3, 3, 3, 400, 0),
(8, 'accessProfileGlobalManager', 'Read all projects\nCan create\nUpdate and delete his projects', 4, 4, 4, 4, 450, 0),
(9, 'accessProfileNoAccess', 'no access allowed', 1, 1, 1, 1, 999, 0),
(10, 'accessReadOwnOnly', NULL, 2, 1, 1, 1, 900, 0);

-- --------------------------------------------------------

--
-- Structure de la table `accessright`
--

CREATE TABLE IF NOT EXISTS `accessright` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProfile` int(12) unsigned DEFAULT NULL,
  `idMenu` int(12) unsigned DEFAULT NULL,
  `idAccessProfile` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accessrightProfile` (`idProfile`),
  KEY `accessrightMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=127 ;

--
-- Contenu de la table `accessright`
--

INSERT INTO `accessright` (`id`, `idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1, 1, 3, 8),
(2, 2, 3, 2),
(3, 3, 3, 7),
(4, 4, 3, 1),
(5, 6, 3, 1),
(6, 7, 3, 1),
(7, 5, 3, 1),
(8, 1, 4, 8),
(9, 2, 4, 4),
(10, 3, 4, 7),
(11, 4, 4, 3),
(12, 6, 4, 3),
(13, 7, 4, 1),
(14, 5, 4, 1),
(15, 1, 5, 8),
(16, 2, 5, 2),
(17, 3, 5, 7),
(18, 4, 5, 1),
(19, 6, 5, 1),
(20, 7, 5, 1),
(21, 5, 5, 1),
(22, 1, 50, 8),
(23, 2, 50, 2),
(24, 3, 50, 7),
(25, 4, 50, 1),
(26, 6, 50, 9),
(27, 7, 50, 9),
(28, 5, 50, 9),
(29, 1, 22, 8),
(30, 2, 22, 2),
(31, 3, 22, 7),
(32, 4, 22, 7),
(33, 6, 22, 7),
(34, 7, 22, 5),
(35, 5, 22, 1),
(36, 1, 51, 8),
(37, 2, 51, 9),
(38, 3, 51, 7),
(39, 4, 51, 9),
(40, 6, 51, 9),
(41, 7, 51, 9),
(42, 5, 51, 9),
(43, 1, 25, 8),
(44, 2, 25, 2),
(45, 3, 25, 7),
(46, 4, 25, 3),
(47, 6, 25, 1),
(48, 7, 25, 1),
(49, 5, 25, 1),
(50, 1, 26, 8),
(51, 2, 26, 2),
(52, 3, 26, 7),
(53, 4, 26, 3),
(54, 6, 26, 1),
(55, 7, 26, 1),
(56, 5, 26, 1),
(57, 1, 16, 8),
(58, 2, 16, 2),
(59, 3, 16, 7),
(60, 4, 16, 9),
(61, 6, 16, 9),
(62, 7, 16, 9),
(63, 5, 16, 9),
(64, 1, 62, 8),
(65, 2, 62, 2),
(66, 3, 62, 7),
(67, 4, 62, 1),
(68, 6, 62, 1),
(69, 7, 62, 1),
(70, 5, 62, 1),
(71, 1, 63, 8),
(72, 2, 63, 2),
(73, 3, 63, 7),
(74, 4, 63, 1),
(75, 6, 63, 1),
(76, 7, 63, 1),
(77, 5, 63, 1),
(78, 1, 64, 8),
(79, 2, 64, 2),
(80, 3, 64, 7),
(81, 4, 64, 1),
(82, 6, 64, 1),
(83, 7, 64, 1),
(84, 5, 64, 1),
(85, 1, 69, 2),
(86, 2, 69, 9),
(87, 3, 69, 1),
(88, 4, 69, 1),
(89, 6, 69, 9),
(90, 7, 69, 9),
(91, 5, 69, 9),
(92, 1, 75, 8),
(93, 2, 75, 2),
(94, 3, 75, 7),
(95, 4, 75, 5),
(96, 6, 75, 9),
(97, 7, 75, 9),
(98, 5, 75, 9),
(99, 1, 76, 8),
(100, 2, 76, 2),
(101, 3, 76, 7),
(102, 4, 76, 9),
(103, 6, 76, 9),
(104, 7, 76, 9),
(105, 5, 76, 9),
(106, 1, 77, 8),
(107, 2, 77, 2),
(108, 3, 77, 7),
(109, 4, 77, 9),
(110, 6, 77, 9),
(111, 7, 77, 9),
(112, 5, 77, 9),
(113, 1, 78, 8),
(114, 2, 78, 2),
(115, 3, 78, 7),
(116, 4, 78, 9),
(117, 6, 78, 9),
(118, 7, 78, 9),
(119, 5, 78, 9),
(120, 1, 91, 2),
(121, 2, 91, 1),
(122, 3, 91, 1),
(123, 4, 91, 10),
(124, 6, 91, 10),
(125, 7, 91, 10),
(126, 5, 91, 10);

-- --------------------------------------------------------

--
-- Structure de la table `accessscope`
--

CREATE TABLE IF NOT EXISTS `accessscope` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `accessCode` varchar(3) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `accessscope`
--

INSERT INTO `accessscope` (`id`, `name`, `accessCode`, `sortOrder`, `idle`) VALUES
(1, 'accessScopeNo', 'NO', 100, 0),
(2, 'accessScopeOwn', 'OWN', 200, 0),
(3, 'accessScopeProject', 'PRO', 300, 0),
(4, 'accessScopeAll', 'ALL', 400, 0);

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `initialDueDate` date DEFAULT NULL,
  `actualDueDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idActionType` int(12) unsigned DEFAULT NULL,
  `idPriority` int(12) unsigned DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `actionProject` (`idProject`),
  KEY `actionUser` (`idUser`),
  KEY `actionResource` (`idResource`),
  KEY `actionStatus` (`idStatus`),
  KEY `actionType` (`idActionType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `action`
--


-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idActivityType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idActivity` int(12) unsigned DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activityProject` (`idProject`),
  KEY `activityUser` (`idUser`),
  KEY `activityResource` (`idResource`),
  KEY `activityStatus` (`idStatus`),
  KEY `activityType` (`idActivityType`),
  KEY `activityActivity` (`idActivity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `activity`
--

INSERT INTO `activity` (`id`, `idProject`, `idActivityType`, `name`, `description`, `creationDate`, `idUser`, `idStatus`, `idResource`, `result`, `comment`, `idle`, `idActivity`, `done`, `idleDate`, `doneDate`, `handled`, `handledDate`, `idVersion`) VALUES
(1, 2, 26, 'bug fixing', 'Main activity to follow-up work spent of bug fixing tickets', '2011-09-01', 1, 3, 3, NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2011-09-01', NULL),
(2, 3, 20, 'Evolution X', NULL, '2011-09-02', 1, 3, 8, NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2011-09-03', 2),
(3, 3, 26, 'Evolutoin X - Analysis', NULL, '2011-09-02', 1, 1, NULL, NULL, NULL, 0, 2, 0, NULL, NULL, 0, NULL, NULL),
(4, 3, 26, 'Evolution X - Development', NULL, '2011-09-02', 1, 1, NULL, NULL, NULL, 0, 2, 0, NULL, NULL, 0, NULL, NULL),
(5, 3, 26, 'Evolution X - Tests', NULL, '2011-09-02', 1, 1, NULL, NULL, NULL, 0, 2, 0, NULL, NULL, 0, NULL, NULL),
(6, 3, 20, 'Evolution Y', NULL, '2011-09-02', 1, 1, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `affectation`
--

CREATE TABLE IF NOT EXISTS `affectation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `rate` int(3) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idRole` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idResourceSelect` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `affectationProject` (`idProject`),
  KEY `affectationResource` (`idResource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `affectation`
--

INSERT INTO `affectation` (`id`, `idResource`, `idProject`, `rate`, `description`, `idle`, `idRole`, `startDate`, `endDate`, `idContact`, `idUser`, `idResourceSelect`) VALUES
(1, 3, 1, 80, NULL, 0, NULL, NULL, NULL, NULL, 3, 3),
(2, 3, 4, 20, NULL, 0, NULL, NULL, NULL, NULL, 3, 3),
(3, 3, 6, 0, NULL, 0, NULL, NULL, NULL, NULL, 3, 3),
(4, 4, 2, 100, NULL, 0, NULL, NULL, NULL, NULL, 4, 4),
(5, 8, 3, 100, NULL, 0, NULL, NULL, NULL, NULL, 8, 8),
(6, 9, 4, 100, NULL, 0, NULL, NULL, NULL, NULL, 9, 9),
(7, 4, 6, 0, NULL, 0, NULL, NULL, NULL, NULL, 4, 4),
(8, 8, 6, 0, NULL, 0, NULL, NULL, NULL, NULL, 8, 8),
(9, 9, 6, 0, NULL, 0, NULL, NULL, NULL, NULL, 9, 9),
(10, 10, 1, 100, NULL, 0, NULL, NULL, NULL, NULL, NULL, 10),
(11, 11, 4, 100, NULL, 0, NULL, NULL, NULL, NULL, NULL, 11),
(12, 12, 1, 80, NULL, 0, NULL, NULL, NULL, NULL, NULL, 12),
(13, 12, 4, 20, NULL, 0, NULL, NULL, NULL, NULL, NULL, 12),
(14, 7, 1, 100, NULL, 0, NULL, NULL, NULL, 7, NULL, NULL),
(15, 5, 1, 100, NULL, 0, NULL, NULL, NULL, 5, 5, NULL),
(16, 6, 4, 100, NULL, 0, NULL, NULL, NULL, 6, 6, NULL),
(18, 3, 3, 100, NULL, 0, NULL, NULL, NULL, NULL, 3, 3),
(19, 1, 1, 100, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL),
(20, 1, 4, 100, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `alert`
--

CREATE TABLE IF NOT EXISTS `alert` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `idIndicatorValue` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `alertType` varchar(10) DEFAULT NULL,
  `alertInitialDateTime` datetime DEFAULT NULL,
  `alertDateTime` datetime DEFAULT NULL,
  `alertReadDateTime` datetime DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `message` varchar(4000) DEFAULT NULL,
  `readFlag` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `alert`
--

INSERT INTO `alert` (`id`, `idProject`, `refType`, `refId`, `idIndicatorValue`, `idUser`, `alertType`, `alertInitialDateTime`, `alertDateTime`, `alertReadDateTime`, `title`, `message`, `readFlag`, `idle`) VALUES
(1, 1, 'Ticket', 1, NULL, 1, 'WARNING', '2011-10-13 17:24:39', '2011-10-13 17:24:00', '2011-10-13 17:30:15', 'WARNING - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="30%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="30%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="30%" align="right">warning value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 17:30</td></table>', 1, 0),
(2, 1, 'Ticket', 1, NULL, 3, 'WARNING', '2011-10-13 17:24:39', '2011-10-13 17:24:00', NULL, 'WARNING - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="30%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="30%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="30%" align="right">warning value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 17:30</td></table>', 0, 0),
(3, 1, 'Ticket', 1, NULL, 1, 'ALERT', '2011-10-13 17:24:39', '2011-10-13 17:24:00', '2011-10-13 17:30:19', 'ALERT - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="30%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="30%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="30%" align="right">alert value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td></table>', 1, 0),
(4, 1, 'Ticket', 1, NULL, 3, 'ALERT', '2011-10-13 17:24:39', '2011-10-13 17:24:00', NULL, 'ALERT - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="30%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="30%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="30%" align="right">alert value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td></table>', 0, 0),
(5, 1, 'Ticket', 1, NULL, 1, 'WARNING', '2011-10-13 17:24:39', '2011-10-13 17:24:00', '2011-10-13 17:30:22', 'WARNING - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="30%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of initial due date/time</td><tr><td width="30%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>02/09/2011 18:00</td><tr><td width="30%" align="right">warning value</td><td>&nbsp;:&nbsp;</td><td>02/09/2011 18:00</td></table>', 1, 0),
(6, 1, 'Ticket', 1, NULL, 1, 'WARNING', '2011-10-13 17:31:53', '2011-10-13 17:31:00', '2011-10-13 17:33:13', 'WARNING - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="35%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="35%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="35%" align="right">warning value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 17:30</td></table>', 1, 0),
(7, 1, 'Ticket', 1, NULL, 3, 'WARNING', '2011-10-13 17:31:53', '2011-10-13 17:31:00', NULL, 'WARNING - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="35%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="35%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="35%" align="right">warning value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 17:30</td></table>', 0, 0),
(8, 1, 'Ticket', 1, NULL, 1, 'ALERT', '2011-10-13 17:31:53', '2011-10-13 17:31:00', '2011-10-13 17:33:33', 'ALERT - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="35%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="35%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="35%" align="right">alert value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td></table>', 1, 0),
(9, 1, 'Ticket', 1, NULL, 3, 'ALERT', '2011-10-13 17:31:53', '2011-10-13 17:31:00', NULL, 'ALERT - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="35%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of actual due date/time</td><tr><td width="35%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td><tr><td width="35%" align="right">alert value</td><td>&nbsp;:&nbsp;</td><td>09/09/2011 18:30</td></table>', 0, 0),
(10, 1, 'Ticket', 1, NULL, 1, 'WARNING', '2011-10-13 17:31:53', '2011-10-13 17:31:00', '2011-10-13 17:33:36', 'WARNING - Ticket #1', '<table><tr><td colspan="3" style="border:1px solid grey">bug: it does not work</td></tr><tr><td width="35%" align="right" valign="top">indicator</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">respect of initial due date/time</td><tr><td width="35%" align="right">target value</td><td>&nbsp;:&nbsp;</td><td>02/09/2011 18:00</td><tr><td width="35%" align="right">warning value</td><td>&nbsp;:&nbsp;</td><td>02/09/2011 18:00</td></table>', 1, 0),
(11, NULL, NULL, NULL, NULL, 1, 'INFO', '2011-10-13 17:33:00', '2011-10-13 17:33:00', '2011-10-14 14:08:43', 'Information from Admin', 'Access will be shut down tomorrow from 22:00 to 23:00', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `rate` int(3) unsigned DEFAULT '100',
  `assignedWork` decimal(12,5) unsigned DEFAULT NULL,
  `realWork` decimal(12,5) unsigned DEFAULT NULL,
  `leftWork` decimal(12,5) unsigned DEFAULT NULL,
  `plannedWork` decimal(12,5) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `realStartDate` date DEFAULT NULL,
  `realEndDate` date DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `plannedStartDate` date DEFAULT NULL,
  `plannedEndDate` date DEFAULT NULL,
  `idRole` int(12) unsigned DEFAULT NULL,
  `dailyCost` decimal(7,2) DEFAULT NULL,
  `newDailyCost` decimal(7,2) DEFAULT NULL,
  `assignedCost` decimal(11,2) DEFAULT NULL,
  `realCost` decimal(11,2) DEFAULT NULL,
  `leftCost` decimal(11,2) DEFAULT NULL,
  `plannedCost` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignmentProject` (`idProject`),
  KEY `assignmentResource` (`idResource`),
  KEY `assignmentRef` (`refType`,`refId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `assignment`
--

INSERT INTO `assignment` (`id`, `idResource`, `idProject`, `refType`, `refId`, `rate`, `assignedWork`, `realWork`, `leftWork`, `plannedWork`, `idle`, `realStartDate`, `realEndDate`, `comment`, `plannedStartDate`, `plannedEndDate`, `idRole`, `dailyCost`, `newDailyCost`, `assignedCost`, `realCost`, `leftCost`, `plannedCost`) VALUES
(1, 3, 2, 'Activity', 1, 20, 10.00000, 0.00000, 10.00000, 10.00000, 0, NULL, NULL, NULL, '2011-10-10', '2011-11-04', 1, 500.00, 500.00, 5000.00, NULL, 5000.00, 5000.00),
(2, 10, 2, 'Activity', 1, 50, 75.00000, 0.00000, 75.00000, 75.00000, 0, NULL, NULL, NULL, '2011-10-10', '2012-01-25', 3, 220.00, 220.00, 16500.00, 0.00, 16500.00, 16500.00),
(3, 8, 3, 'Activity', 3, 100, 5.00000, 5.70000, 0.00000, 5.70000, 0, '2011-09-05', '2011-10-13', NULL, '2011-10-10', '2011-10-12', 2, 300.00, 300.00, 1500.00, 1710.00, 0.00, 1710.00),
(4, 10, 3, 'Activity', 4, 100, 10.00000, 0.00000, 10.00000, 10.00000, 0, NULL, NULL, NULL, '2011-10-13', '2011-10-17', 3, 220.00, 220.00, 2200.00, NULL, 2200.00, 2200.00),
(5, 8, 3, 'Activity', 5, 100, 3.00000, 0.00000, 3.00000, 3.00000, 0, NULL, NULL, 'Work could be anticipated to prepare tests', '2011-10-18', '2011-10-20', 2, 300.00, 300.00, 900.00, 0.00, 900.00, 900.00);

-- --------------------------------------------------------

--
-- Structure de la table `attachement`
--

CREATE TABLE IF NOT EXISTS `attachement` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `fileName` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `subDirectory` varchar(100) DEFAULT NULL,
  `mimeType` varchar(100) DEFAULT NULL,
  `fileSize` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attachementUser` (`idUser`),
  KEY `attachementRef` (`refType`,`refId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `attachement`
--

INSERT INTO `attachement` (`id`, `refType`, `refId`, `idUser`, `creationDate`, `fileName`, `description`, `subDirectory`, `mimeType`, `fileSize`) VALUES
(1, 'Anomaly', 3, 1, '2009-09-08 17:26:45', 'vlc.exe.manifest', 'Test fichier', 'D:\\TEMP\\attachement_1\\', 'application/octet-stream', 606),
(2, 'Ticket', 1, 1, '2011-10-13 18:28:19', 'readme.txt', 'readme file', '../files/attach//attachement_2/', 'text/plain', 1183);

-- --------------------------------------------------------

--
-- Structure de la table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `isOffDay` int(1) unsigned DEFAULT '0',
  `calendarDate` date DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `calendarDay` (`day`),
  KEY `calendarWeek` (`week`),
  KEY `calendarMonth` (`month`),
  KEY `calendarYear` (`year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `calendar`
--

INSERT INTO `calendar` (`id`, `name`, `isOffDay`, `calendarDate`, `day`, `week`, `month`, `year`, `idle`) VALUES
(1, 'New year day', 1, '2011-01-01', '20110101', '201152', '201101', '2011', 0),
(2, 'Christmas', 1, '2011-12-25', '20111225', '201151', '201112', '2011', 0);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `clientCode` varchar(25) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `name`, `description`, `clientCode`, `idle`) VALUES
(1, 'client one', NULL, '001', 0),
(2, 'client two', NULL, '002', 0),
(3, 'internal', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `copyable`
--

CREATE TABLE IF NOT EXISTS `copyable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `sortOrder` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `copyable`
--

INSERT INTO `copyable` (`id`, `name`, `idle`, `sortOrder`) VALUES
(1, 'Ticket', 0, 10),
(2, 'Activity', 0, 20),
(3, 'Milestone', 0, 30),
(4, 'IndividualExpense', 0, 40),
(5, 'ProjectExpense', 0, 50),
(6, 'Risk', 0, 60),
(7, 'Action', 0, 70),
(8, 'Issue', 0, 80),
(9, 'Meeting', 0, 90),
(10, 'Decision', 0, 100),
(11, 'Question', 0, 110);

-- --------------------------------------------------------

--
-- Structure de la table `criticality`
--

CREATE TABLE IF NOT EXISTS `criticality` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) unsigned DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `criticality`
--

INSERT INTO `criticality` (`id`, `name`, `value`, `color`, `sortOrder`, `idle`) VALUES
(1, 'Low', 1, '#32cd32', 10, 0),
(2, 'Medium', 2, '#ffd700', 20, 0),
(3, 'High', 4, '#ff0000', 30, 0),
(4, 'Critical', 8, '#000000', 40, 0);

-- --------------------------------------------------------

--
-- Structure de la table `decision`
--

CREATE TABLE IF NOT EXISTS `decision` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idDecisionType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `decisionDate` date DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `decisionProject` (`idProject`),
  KEY `decisionType` (`idDecisionType`),
  KEY `decisionUser` (`idUser`),
  KEY `decisionResource` (`idResource`),
  KEY `decisionStatus` (`idStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `decision`
--


-- --------------------------------------------------------

--
-- Structure de la table `delay`
--

CREATE TABLE IF NOT EXISTS `delay` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) DEFAULT NULL,
  `idType` int(12) unsigned DEFAULT NULL,
  `idUrgency` int(12) unsigned DEFAULT NULL,
  `value` decimal(6,3) DEFAULT NULL,
  `idDelayUnit` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `delay`
--

INSERT INTO `delay` (`id`, `scope`, `idType`, `idUrgency`, `value`, `idDelayUnit`, `idle`) VALUES
(1, 'Ticket', 16, 1, 2.000, 2, 0),
(2, 'Ticket', 16, 2, 1.000, 4, 0),
(3, 'Ticket', 17, 1, 1.000, 4, 0),
(4, 'Ticket', 17, 1, 4.000, 4, 0),
(5, 'Ticket', 18, 1, 4.000, 2, 0),
(6, 'Ticket', 18, 2, 2.000, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `delayunit`
--

CREATE TABLE IF NOT EXISTS `delayunit` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `delayunit`
--

INSERT INTO `delayunit` (`id`, `code`, `name`, `type`, `sortOrder`, `idle`) VALUES
(1, 'HH', 'hours', 'delay', 100, 0),
(2, 'OH', 'openHours', 'delay', 200, 0),
(3, 'DD', 'days', 'delay', 300, 0),
(4, 'OD', 'openDays', 'delay', 400, 0),
(5, 'PCT', 'percent', 'percent', 500, 0);

-- --------------------------------------------------------

--
-- Structure de la table `dependable`
--

CREATE TABLE IF NOT EXISTS `dependable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `dependable`
--

INSERT INTO `dependable` (`id`, `name`, `idle`) VALUES
(1, 'Activity', 0),
(2, 'Milestone', 0),
(3, 'Project', 0);

-- --------------------------------------------------------

--
-- Structure de la table `dependency`
--

CREATE TABLE IF NOT EXISTS `dependency` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `predecessorId` int(12) unsigned NOT NULL,
  `predecessorRefType` varchar(100) DEFAULT NULL,
  `predecessorRefId` int(12) unsigned NOT NULL,
  `successorId` int(12) unsigned NOT NULL,
  `successorRefType` varchar(100) DEFAULT NULL,
  `successorRefId` int(12) unsigned NOT NULL,
  `dependencyType` varchar(12) DEFAULT NULL,
  `dependencyDelay` decimal(3,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dependencyPredecessorRef` (`predecessorRefType`,`predecessorRefId`),
  KEY `dependencyPredecessorId` (`predecessorId`),
  KEY `dependencySuccessorRef` (`successorRefType`,`successorRefId`),
  KEY `dependencySuccessorId` (`successorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `dependency`
--

INSERT INTO `dependency` (`id`, `predecessorId`, `predecessorRefType`, `predecessorRefId`, `successorId`, `successorRefType`, `successorRefId`, `dependencyType`, `dependencyDelay`) VALUES
(1, 9, 'Activity', 3, 10, 'Activity', 4, 'E-S', NULL),
(2, 10, 'Activity', 4, 11, 'Activity', 5, 'E-S', NULL),
(3, 11, 'Activity', 5, 12, 'Milestone', 1, 'E-S', NULL),
(4, 12, 'Milestone', 1, 13, 'Activity', 6, 'E-S', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `expense`
--

CREATE TABLE IF NOT EXISTS `expense` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idExpenseType` int(12) unsigned DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `expensePlannedDate` date DEFAULT NULL,
  `expenseRealDate` date DEFAULT NULL,
  `plannedAmount` decimal(11,2) DEFAULT NULL,
  `realAmount` decimal(11,2) DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `expenseProject` (`idProject`),
  KEY `expenseType` (`idExpenseType`),
  KEY `expenseUser` (`idUser`),
  KEY `expenseResource` (`idResource`),
  KEY `expenseStatus` (`idStatus`),
  KEY `expenseDay` (`day`),
  KEY `expenseWeek` (`week`),
  KEY `expenseMonth` (`month`),
  KEY `expenseYear` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `expense`
--


-- --------------------------------------------------------

--
-- Structure de la table `expensedetail`
--

CREATE TABLE IF NOT EXISTS `expensedetail` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idExpense` int(12) unsigned DEFAULT NULL,
  `expenseDate` date DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idExpenseDetailType` int(12) unsigned DEFAULT NULL,
  `value01` decimal(8,2) DEFAULT NULL,
  `value02` decimal(8,2) DEFAULT NULL,
  `value03` decimal(8,2) DEFAULT NULL,
  `unit01` varchar(20) DEFAULT NULL,
  `unit02` varchar(20) DEFAULT NULL,
  `unit03` varchar(20) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `expensedetailProject` (`idProject`),
  KEY `expensedetailType` (`idExpenseDetailType`),
  KEY `expensedetailExpense` (`idExpense`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `expensedetail`
--


-- --------------------------------------------------------

--
-- Structure de la table `expensedetailtype`
--

CREATE TABLE IF NOT EXISTS `expensedetailtype` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `value01` decimal(8,2) DEFAULT NULL,
  `value02` decimal(8,2) DEFAULT NULL,
  `value03` decimal(8,2) DEFAULT NULL,
  `unit01` varchar(20) DEFAULT NULL,
  `unit02` varchar(20) DEFAULT NULL,
  `unit03` varchar(20) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `expensedetailtype`
--

INSERT INTO `expensedetailtype` (`id`, `name`, `sortOrder`, `value01`, `value02`, `value03`, `unit01`, `unit02`, `unit03`, `idle`) VALUES
(1, 'travel by car', 10, NULL, 0.54, NULL, 'km', 'â‚¬/km', NULL, 0),
(2, 'regular mission car travel', 20, NULL, NULL, 0.54, 'days', 'km/day', 'â‚¬/km', 0),
(3, 'lunch for guests', 30, NULL, NULL, NULL, 'guests', 'â‚¬/guest', NULL, 0),
(4, 'justified expense', 40, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `filter`
--

CREATE TABLE IF NOT EXISTS `filter` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filterUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `filter`
--


-- --------------------------------------------------------

--
-- Structure de la table `filtercriteria`
--

CREATE TABLE IF NOT EXISTS `filtercriteria` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idFilter` int(12) unsigned NOT NULL,
  `dispAttribute` varchar(100) DEFAULT NULL,
  `dispOperator` varchar(100) DEFAULT NULL,
  `dispValue` varchar(4000) DEFAULT NULL,
  `sqlAttribute` varchar(100) DEFAULT NULL,
  `sqlOperator` varchar(100) DEFAULT NULL,
  `sqlValue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filtercriteriaFilter` (`idFilter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `filtercriteria`
--


-- --------------------------------------------------------

--
-- Structure de la table `habilitation`
--

CREATE TABLE IF NOT EXISTS `habilitation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProfile` int(12) unsigned DEFAULT NULL,
  `idMenu` int(12) unsigned DEFAULT NULL,
  `allowAccess` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `habilitationProfile` (`idProfile`),
  KEY `habilitationMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=489 ;

--
-- Contenu de la table `habilitation`
--

INSERT INTO `habilitation` (`id`, `idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 1, 14, 1),
(2, 1, 13, 1),
(3, 1, 21, 1),
(4, 1, 17, 1),
(5, 2, 20, 1),
(6, 1, 1, 1),
(7, 2, 1, 1),
(8, 3, 1, 1),
(9, 4, 1, 1),
(10, 6, 1, 1),
(11, 7, 1, 1),
(12, 5, 1, 1),
(13, 1, 2, 1),
(14, 2, 2, 0),
(15, 3, 2, 1),
(16, 4, 2, 1),
(17, 6, 2, 1),
(18, 7, 2, 1),
(19, 5, 2, 0),
(20, 1, 3, 1),
(21, 2, 3, 1),
(22, 3, 3, 1),
(23, 4, 3, 0),
(24, 6, 3, 1),
(25, 7, 3, 0),
(26, 5, 3, 0),
(27, 1, 4, 1),
(28, 2, 4, 1),
(29, 3, 4, 1),
(30, 4, 4, 1),
(31, 6, 4, 1),
(32, 7, 4, 1),
(33, 5, 4, 1),
(34, 1, 5, 1),
(35, 2, 5, 1),
(36, 3, 5, 1),
(37, 4, 5, 0),
(38, 6, 5, 0),
(39, 7, 5, 0),
(40, 5, 5, 0),
(41, 1, 6, 1),
(42, 2, 6, 1),
(43, 3, 6, 1),
(44, 4, 6, 1),
(45, 6, 6, 1),
(46, 7, 6, 1),
(47, 5, 6, 1),
(48, 1, 7, 1),
(49, 2, 7, 1),
(50, 3, 7, 1),
(51, 4, 7, 1),
(52, 6, 7, 1),
(53, 7, 7, 1),
(54, 5, 7, 1),
(55, 1, 8, 1),
(56, 2, 8, 1),
(57, 3, 8, 1),
(58, 4, 8, 1),
(59, 6, 8, 1),
(60, 7, 8, 1),
(61, 5, 8, 1),
(62, 1, 9, 1),
(63, 2, 9, 1),
(64, 3, 9, 1),
(65, 4, 9, 1),
(66, 6, 9, 1),
(67, 7, 9, 1),
(68, 5, 9, 1),
(69, 1, 10, 0),
(70, 2, 10, 0),
(71, 3, 10, 0),
(72, 4, 10, 0),
(73, 6, 10, 0),
(74, 7, 10, 0),
(75, 5, 10, 0),
(76, 1, 11, 1),
(77, 2, 11, 0),
(78, 3, 11, 1),
(79, 4, 11, 1),
(80, 6, 11, 0),
(81, 7, 11, 0),
(82, 5, 11, 0),
(83, 1, 12, 0),
(84, 2, 12, 0),
(85, 3, 12, 0),
(86, 4, 12, 0),
(87, 6, 12, 0),
(88, 7, 12, 0),
(89, 5, 12, 0),
(90, 2, 13, 1),
(91, 3, 13, 1),
(92, 4, 13, 1),
(93, 6, 13, 1),
(94, 7, 13, 1),
(95, 5, 13, 1),
(96, 2, 14, 1),
(97, 3, 14, 1),
(98, 4, 14, 0),
(99, 6, 14, 0),
(100, 7, 14, 0),
(101, 5, 14, 0),
(102, 1, 15, 1),
(103, 2, 15, 0),
(104, 3, 15, 0),
(105, 4, 15, 0),
(106, 6, 15, 0),
(107, 7, 15, 0),
(108, 5, 15, 0),
(109, 1, 16, 1),
(110, 2, 16, 1),
(111, 3, 16, 1),
(112, 4, 16, 0),
(113, 6, 16, 0),
(114, 7, 16, 0),
(115, 5, 16, 0),
(116, 2, 17, 0),
(117, 3, 17, 0),
(118, 4, 17, 0),
(119, 6, 17, 0),
(120, 7, 17, 0),
(121, 5, 17, 0),
(122, 2, 21, 0),
(123, 3, 21, 0),
(124, 4, 21, 0),
(125, 6, 21, 0),
(126, 7, 21, 0),
(127, 5, 21, 0),
(128, 1, 18, 1),
(129, 2, 18, 0),
(130, 3, 18, 0),
(131, 4, 18, 0),
(132, 6, 18, 0),
(133, 7, 18, 0),
(134, 5, 18, 0),
(135, 1, 19, 0),
(136, 2, 19, 0),
(137, 3, 19, 0),
(138, 4, 19, 0),
(139, 6, 19, 0),
(140, 7, 19, 0),
(141, 5, 19, 0),
(142, 1, 20, 1),
(143, 3, 20, 1),
(144, 4, 20, 1),
(145, 6, 20, 1),
(146, 7, 20, 1),
(147, 5, 20, 1),
(148, 1, 22, 1),
(149, 2, 22, 0),
(150, 3, 22, 1),
(151, 4, 22, 1),
(152, 6, 22, 1),
(153, 7, 22, 1),
(154, 5, 22, 0),
(155, 1, 23, 0),
(156, 2, 23, 0),
(157, 3, 23, 0),
(158, 4, 23, 0),
(159, 6, 23, 0),
(160, 7, 23, 0),
(161, 5, 23, 0),
(162, 1, 24, 0),
(163, 2, 24, 0),
(164, 3, 24, 0),
(165, 4, 24, 0),
(166, 6, 24, 0),
(167, 7, 24, 0),
(168, 5, 24, 0),
(169, 1, 25, 1),
(170, 2, 25, 0),
(171, 3, 25, 1),
(172, 4, 25, 1),
(173, 6, 25, 1),
(174, 7, 25, 1),
(175, 5, 25, 0),
(176, 1, 26, 1),
(177, 2, 26, 0),
(178, 3, 26, 1),
(179, 4, 26, 1),
(180, 6, 26, 1),
(181, 7, 26, 1),
(182, 5, 26, 0),
(183, 1, 32, 0),
(184, 2, 32, 0),
(185, 3, 32, 0),
(186, 4, 32, 0),
(187, 6, 32, 0),
(188, 7, 32, 0),
(189, 5, 32, 0),
(190, 1, 33, 0),
(191, 2, 33, 0),
(192, 3, 33, 0),
(193, 4, 33, 0),
(194, 6, 33, 0),
(195, 7, 33, 0),
(196, 5, 33, 0),
(197, 1, 34, 1),
(198, 2, 34, 0),
(199, 3, 34, 0),
(200, 4, 34, 0),
(201, 6, 34, 0),
(202, 7, 34, 0),
(203, 5, 34, 0),
(204, 1, 36, 1),
(205, 2, 36, 0),
(206, 3, 36, 0),
(207, 4, 36, 0),
(208, 6, 36, 0),
(209, 7, 36, 0),
(210, 5, 36, 0),
(211, 1, 37, 1),
(212, 2, 37, 0),
(213, 3, 37, 0),
(214, 4, 37, 0),
(215, 6, 37, 0),
(216, 7, 37, 0),
(217, 5, 37, 0),
(218, 1, 38, 1),
(219, 2, 38, 0),
(220, 3, 38, 0),
(221, 4, 38, 0),
(222, 6, 38, 0),
(223, 7, 38, 0),
(224, 5, 38, 0),
(225, 1, 39, 1),
(226, 2, 39, 0),
(227, 3, 39, 0),
(228, 4, 39, 0),
(229, 6, 39, 0),
(230, 7, 39, 0),
(231, 5, 39, 0),
(232, 1, 40, 1),
(233, 2, 40, 0),
(234, 3, 40, 0),
(235, 4, 40, 0),
(236, 6, 40, 0),
(237, 7, 40, 0),
(238, 5, 40, 0),
(239, 1, 42, 1),
(240, 2, 42, 0),
(241, 3, 42, 0),
(242, 4, 42, 0),
(243, 6, 42, 0),
(244, 7, 42, 0),
(245, 5, 42, 0),
(246, 1, 41, 1),
(247, 2, 41, 0),
(248, 3, 41, 0),
(249, 4, 41, 0),
(250, 6, 41, 0),
(251, 7, 41, 0),
(252, 5, 41, 0),
(253, 1, 43, 1),
(254, 2, 43, 1),
(255, 3, 43, 1),
(256, 4, 43, 1),
(257, 6, 43, 1),
(258, 7, 43, 1),
(259, 5, 43, 1),
(260, 1, 44, 1),
(261, 2, 44, 0),
(262, 3, 44, 1),
(263, 4, 44, 0),
(264, 6, 44, 0),
(265, 7, 44, 0),
(266, 5, 44, 0),
(267, 1, 45, 1),
(268, 2, 45, 0),
(269, 3, 45, 0),
(270, 4, 45, 0),
(271, 6, 45, 0),
(272, 7, 45, 0),
(273, 5, 45, 0),
(274, 1, 46, 1),
(275, 2, 46, 0),
(276, 3, 46, 0),
(277, 4, 46, 0),
(278, 6, 46, 0),
(279, 7, 46, 0),
(280, 5, 46, 0),
(281, 1, 50, 1),
(282, 2, 50, 0),
(283, 3, 50, 1),
(284, 4, 50, 0),
(285, 6, 50, 0),
(286, 7, 50, 0),
(287, 5, 50, 0),
(288, 1, 49, 1),
(289, 2, 49, 0),
(290, 3, 49, 0),
(291, 4, 49, 0),
(292, 6, 49, 0),
(293, 7, 49, 0),
(294, 5, 49, 0),
(295, 1, 47, 1),
(296, 2, 47, 0),
(297, 3, 47, 0),
(298, 4, 47, 0),
(299, 6, 47, 0),
(300, 7, 47, 0),
(301, 5, 47, 0),
(302, 1, 48, 1),
(303, 2, 48, 0),
(304, 3, 48, 0),
(305, 4, 48, 0),
(306, 6, 48, 0),
(307, 7, 48, 0),
(308, 5, 48, 0),
(309, 1, 51, 1),
(310, 2, 51, 0),
(311, 3, 51, 1),
(312, 4, 51, 0),
(313, 6, 51, 0),
(314, 7, 51, 0),
(315, 5, 51, 0),
(316, 1, 52, 1),
(317, 2, 52, 0),
(318, 3, 52, 0),
(319, 4, 52, 0),
(320, 6, 52, 0),
(321, 7, 52, 0),
(322, 5, 52, 0),
(323, 1, 53, 1),
(324, 2, 53, 0),
(325, 3, 53, 0),
(326, 4, 53, 0),
(327, 6, 53, 0),
(328, 7, 53, 0),
(329, 5, 53, 0),
(330, 1, 55, 1),
(331, 2, 55, 0),
(332, 3, 55, 0),
(333, 4, 55, 0),
(334, 6, 55, 0),
(335, 7, 55, 0),
(336, 5, 55, 0),
(337, 1, 56, 1),
(338, 2, 56, 0),
(339, 3, 56, 0),
(340, 4, 56, 0),
(341, 6, 56, 0),
(342, 7, 56, 0),
(343, 5, 56, 0),
(344, 1, 57, 1),
(345, 2, 57, 1),
(346, 3, 57, 1),
(347, 4, 57, 0),
(348, 6, 57, 0),
(349, 7, 57, 0),
(350, 5, 57, 0),
(351, 1, 58, 1),
(352, 2, 58, 0),
(353, 3, 58, 0),
(354, 4, 58, 0),
(355, 5, 58, 0),
(356, 6, 58, 0),
(357, 7, 58, 0),
(358, 1, 59, 1),
(359, 1, 60, 1),
(360, 1, 61, 1),
(361, 2, 61, 1),
(362, 3, 61, 1),
(363, 1, 62, 1),
(364, 2, 62, 1),
(365, 3, 62, 1),
(366, 4, 62, 1),
(367, 6, 62, 1),
(368, 7, 62, 1),
(369, 5, 62, 1),
(370, 1, 63, 1),
(371, 2, 63, 1),
(372, 3, 63, 1),
(373, 4, 63, 1),
(374, 6, 63, 1),
(375, 7, 63, 1),
(376, 5, 63, 1),
(377, 1, 64, 1),
(378, 2, 64, 1),
(379, 3, 64, 1),
(380, 4, 64, 1),
(381, 6, 64, 1),
(382, 7, 64, 1),
(383, 5, 64, 1),
(384, 1, 65, 1),
(385, 2, 65, 0),
(386, 3, 65, 0),
(387, 4, 65, 0),
(388, 6, 65, 0),
(389, 7, 65, 0),
(390, 5, 65, 0),
(391, 1, 66, 1),
(392, 2, 66, 0),
(393, 3, 66, 0),
(394, 4, 66, 0),
(395, 6, 66, 0),
(396, 7, 66, 0),
(397, 5, 66, 0),
(398, 1, 67, 1),
(399, 2, 67, 0),
(400, 3, 67, 0),
(401, 4, 67, 0),
(402, 6, 67, 0),
(403, 7, 67, 0),
(404, 5, 67, 0),
(405, 1, 68, 1),
(406, 2, 68, 0),
(407, 3, 68, 0),
(408, 4, 68, 0),
(409, 6, 68, 0),
(410, 7, 68, 0),
(411, 5, 68, 0),
(412, 1, 69, 1),
(413, 2, 69, 0),
(414, 3, 69, 1),
(415, 4, 69, 1),
(416, 6, 69, 0),
(417, 7, 69, 0),
(418, 5, 69, 0),
(419, 1, 70, 1),
(420, 2, 70, 0),
(421, 3, 70, 0),
(422, 4, 70, 0),
(423, 6, 70, 0),
(424, 7, 70, 0),
(425, 1, 71, 1),
(426, 2, 71, 0),
(427, 3, 71, 0),
(428, 4, 71, 0),
(429, 6, 71, 0),
(430, 7, 71, 0),
(431, 1, 72, 1),
(432, 1, 73, 1),
(433, 1, 74, 1),
(434, 2, 74, 1),
(435, 3, 74, 1),
(436, 1, 75, 1),
(437, 2, 75, 1),
(438, 3, 75, 1),
(439, 4, 75, 1),
(440, 1, 76, 1),
(441, 2, 76, 1),
(442, 3, 76, 1),
(443, 1, 77, 0),
(444, 2, 77, 0),
(445, 3, 77, 0),
(446, 1, 78, 0),
(447, 2, 78, 0),
(448, 3, 78, 0),
(449, 1, 79, 1),
(450, 2, 79, 1),
(451, 3, 79, 1),
(452, 1, 80, 1),
(453, 2, 80, 1),
(454, 1, 81, 1),
(455, 2, 81, 1),
(456, 1, 82, 0),
(457, 2, 82, 0),
(458, 1, 83, 0),
(459, 2, 83, 0),
(460, 1, 84, 1),
(461, 2, 84, 1),
(462, 1, 85, 1),
(463, 2, 85, 1),
(464, 3, 85, 1),
(465, 1, 86, 1),
(466, 2, 86, 1),
(467, 3, 86, 1),
(468, 1, 87, 1),
(469, 2, 87, 1),
(470, 3, 87, 1),
(471, 1, 88, 1),
(472, 2, 88, 1),
(473, 3, 88, 1),
(474, 1, 89, 1),
(475, 2, 89, 1),
(476, 3, 89, 1),
(477, 1, 90, 1),
(478, 2, 90, 1),
(479, 3, 90, 1),
(480, 1, 91, 1),
(481, 2, 91, 1),
(482, 3, 91, 1),
(483, 4, 91, 1),
(484, 5, 91, 1),
(485, 6, 91, 1),
(486, 7, 91, 1),
(488, 1, 92, 1);

-- --------------------------------------------------------

--
-- Structure de la table `habilitationother`
--

CREATE TABLE IF NOT EXISTS `habilitationother` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProfile` int(12) unsigned DEFAULT NULL,
  `scope` varchar(10) DEFAULT NULL,
  `rightAccess` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `habilitationotherProfile` (`idProfile`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `habilitationother`
--

INSERT INTO `habilitationother` (`id`, `idProfile`, `scope`, `rightAccess`) VALUES
(1, 1, 'imputation', '4'),
(2, 2, 'imputation', '2'),
(3, 3, 'imputation', '3'),
(4, 4, 'imputation', '2'),
(5, 6, 'imputation', '1'),
(6, 7, 'imputation', '1'),
(7, 5, 'imputation', '1'),
(8, 1, 'work', '4'),
(9, 2, 'work', '4'),
(10, 3, 'work', '4'),
(11, 4, 'work', '4'),
(12, 6, 'work', '2'),
(13, 7, 'work', '1'),
(14, 5, 'work', '1'),
(15, 1, 'cost', '4'),
(16, 2, 'cost', '4'),
(17, 3, 'cost', '4'),
(18, 4, 'cost', '1'),
(19, 6, 'cost', '2'),
(20, 7, 'cost', '1'),
(21, 5, 'cost', '1'),
(22, 1, 'combo', '1'),
(23, 2, 'combo', '2'),
(24, 3, 'combo', '1'),
(25, 4, 'combo', '2'),
(26, 6, 'combo', '2'),
(27, 7, 'combo', '2'),
(28, 5, 'combo', '2');

-- --------------------------------------------------------

--
-- Structure de la table `habilitationreport`
--

CREATE TABLE IF NOT EXISTS `habilitationreport` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProfile` int(12) unsigned DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `allowAccess` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `habilitationReportProfile` (`idProfile`),
  KEY `habilitationReportReport` (`idReport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Contenu de la table `habilitationreport`
--

INSERT INTO `habilitationreport` (`id`, `idProfile`, `idReport`, `allowAccess`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 1, 11, 1),
(12, 1, 12, 1),
(13, 1, 13, 1),
(14, 1, 14, 1),
(15, 1, 15, 1),
(16, 1, 16, 1),
(17, 1, 17, 1),
(18, 1, 18, 1),
(19, 1, 19, 1),
(20, 1, 20, 1),
(21, 1, 21, 1),
(22, 1, 22, 1),
(23, 1, 23, 1),
(24, 1, 24, 1),
(25, 1, 25, 1),
(26, 2, 1, 1),
(27, 2, 2, 1),
(28, 2, 3, 1),
(29, 2, 4, 1),
(30, 2, 5, 1),
(31, 2, 6, 1),
(32, 2, 7, 1),
(33, 2, 8, 1),
(34, 2, 9, 1),
(35, 2, 10, 1),
(36, 2, 11, 1),
(37, 2, 12, 1),
(38, 2, 13, 1),
(39, 2, 14, 1),
(40, 2, 15, 1),
(41, 2, 16, 1),
(42, 2, 17, 1),
(43, 2, 18, 1),
(44, 2, 19, 1),
(45, 2, 20, 1),
(46, 2, 21, 1),
(47, 2, 22, 1),
(48, 2, 23, 1),
(49, 3, 1, 1),
(50, 3, 2, 1),
(51, 3, 3, 1),
(52, 3, 4, 1),
(53, 3, 5, 1),
(54, 3, 6, 1),
(55, 3, 7, 1),
(56, 3, 8, 1),
(57, 3, 9, 1),
(58, 3, 10, 1),
(59, 3, 11, 1),
(60, 3, 12, 1),
(61, 3, 13, 1),
(62, 3, 14, 1),
(63, 3, 15, 1),
(64, 3, 16, 1),
(65, 3, 17, 1),
(66, 3, 18, 1),
(67, 3, 19, 1),
(68, 3, 20, 1),
(69, 3, 21, 1),
(70, 3, 22, 1),
(71, 3, 23, 1),
(72, 1, 26, 1),
(73, 1, 27, 1),
(74, 2, 26, 1),
(75, 2, 27, 1),
(76, 3, 26, 1),
(77, 3, 27, 1),
(78, 1, 28, 1),
(79, 1, 29, 1),
(80, 1, 30, 1),
(81, 2, 28, 1),
(82, 2, 29, 1),
(83, 2, 30, 1),
(84, 3, 28, 1),
(85, 3, 29, 1),
(86, 3, 30, 1),
(87, 1, 31, 1),
(88, 2, 31, 1),
(89, 3, 31, 1),
(90, 1, 32, 1),
(91, 2, 32, 1),
(92, 3, 32, 1),
(93, 1, 33, 1),
(94, 2, 33, 1),
(95, 3, 33, 1),
(96, 1, 34, 1),
(97, 2, 34, 1),
(98, 3, 34, 1),
(99, 1, 35, 1),
(100, 2, 35, 1),
(101, 3, 35, 1),
(102, 1, 36, 1),
(103, 2, 36, 1),
(104, 3, 36, 1);

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `operation` varchar(10) DEFAULT NULL,
  `colName` varchar(100) DEFAULT NULL,
  `oldValue` varchar(4000) DEFAULT NULL,
  `newValue` varchar(4000) DEFAULT NULL,
  `operationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idUser` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `historyUser` (`idUser`),
  KEY `historyRef` (`refType`,`refId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=344 ;

--
-- Contenu de la table `history`
--

INSERT INTO `history` (`id`, `refType`, `refId`, `operation`, `colName`, `oldValue`, `newValue`, `operationDate`, `idUser`) VALUES
(1, 'Project', 1, 'insert', NULL, NULL, NULL, '2011-09-01 18:48:44', NULL),
(2, 'ProjectPlanningElement', 1, 'insert', NULL, NULL, NULL, '2011-09-01 18:48:44', NULL),
(3, 'Client', 1, 'insert', NULL, NULL, NULL, '2011-09-01 18:50:04', 1),
(4, 'Client', 2, 'insert', NULL, NULL, NULL, '2011-09-01 18:50:14', 1),
(5, 'Client', 2, 'update', 'clientCode', NULL, '002', '2011-09-01 18:50:18', 1),
(6, 'Client', 3, 'insert', NULL, NULL, NULL, '2011-09-01 18:50:25', 1),
(7, 'Project', 1, 'update', 'name', 'Default project', 'project one', '2011-09-01 18:51:13', 1),
(8, 'Project', 1, 'update', 'idClient', NULL, '1', '2011-09-01 18:51:13', 1),
(9, 'Project', 1, 'update', 'projectCode', NULL, '001-001', '2011-09-01 18:51:13', 1),
(10, 'Project', 1, 'update', 'contractCode', NULL, 'X23-472-722', '2011-09-01 18:51:13', 1),
(11, 'ProjectPlanningElement', 1, 'update', 'idProject', NULL, '1', '2011-09-01 18:51:13', 1),
(12, 'ProjectPlanningElement', 1, 'update', 'refName', 'Default project', 'project one', '2011-09-01 18:51:13', 1),
(13, 'Project', 1, 'update', 'color', '#0000FF', '#4169e1', '2011-09-01 18:51:20', 1),
(14, 'Project', 1, 'update', 'description', 'Default project\nFor example use only.\nRemove or rename this project when initializing your own data.', '1st project\nFor example use only.\nRemove or rename this project when initializing your own data.', '2011-09-01 18:51:34', 1),
(15, 'Project', 1, 'update', 'description', '1st project\nFor example use only.\nRemove or rename this project when initializing your own data.', '1st project\nThis project has 2 sub-projects', '2011-09-01 18:51:49', 1),
(16, 'Project', 2, 'insert', NULL, NULL, NULL, '2011-09-01 18:51:56', 1),
(17, 'ProjectPlanningElement', 2, 'insert', NULL, NULL, NULL, '2011-09-01 18:51:56', 1),
(18, 'Project', 2, 'update', 'name', 'project one', 'project one - subproject 1', '2011-09-01 18:52:14', 1),
(19, 'Project', 2, 'update', 'projectCode', '001-001', '001-001-1', '2011-09-01 18:52:14', 1),
(20, 'ProjectPlanningElement', 2, 'update', 'idProject', '1', '2', '2011-09-01 18:52:14', 1),
(21, 'ProjectPlanningElement', 2, 'update', 'refName', 'project one', 'project one - subproject 1', '2011-09-01 18:52:14', 1),
(22, 'Project', 2, 'update', 'idProject', NULL, '1', '2011-09-01 18:52:20', 1),
(23, 'ProjectPlanningElement', 2, 'update', 'wbs', '2', '1.1', '2011-09-01 18:52:20', 1),
(24, 'ProjectPlanningElement', 2, 'update', 'wbsSortable', '002', '001.001', '2011-09-01 18:52:20', 1),
(25, 'ProjectPlanningElement', 2, 'update', 'topId', NULL, '1', '2011-09-01 18:52:20', 1),
(26, 'ProjectPlanningElement', 2, 'update', 'topRefType', NULL, 'Project', '2011-09-01 18:52:20', 1),
(27, 'ProjectPlanningElement', 2, 'update', 'topRefId', NULL, '1', '2011-09-01 18:52:20', 1),
(28, 'PlanningElement', 1, 'update', 'elementary', '1', '0', '2011-09-01 18:52:20', 1),
(29, 'Resource', 3, 'insert', NULL, NULL, NULL, '2011-09-01 18:52:58', 1),
(30, 'Resource', 3, 'update', 'idRole', NULL, '1', '2011-09-01 18:53:01', 1),
(31, 'ResourceCost', 1, 'insert', NULL, NULL, NULL, '2011-09-01 18:53:07', 1),
(32, 'Resource', 4, 'insert', NULL, NULL, NULL, '2011-09-01 18:54:02', 1),
(33, 'Resource', 4, 'update', 'idRole', NULL, '2', '2011-09-01 18:54:06', 1),
(34, 'Resource', 3, 'update', 'isUser', '0', '1', '2011-09-01 18:54:34', 1),
(35, 'Resource', 3, 'update', 'userName', NULL, 'pl', '2011-09-01 18:54:34', 1),
(36, 'Team', 1, 'insert', NULL, NULL, NULL, '2011-09-01 18:55:03', 1),
(37, 'Team', 2, 'insert', NULL, NULL, NULL, '2011-09-01 18:55:14', 1),
(38, 'Product', 1, 'insert', NULL, NULL, NULL, '2011-09-01 18:55:51', 1),
(39, 'Contact', 5, 'insert', NULL, NULL, NULL, '2011-09-01 18:56:39', 1),
(40, 'Contact', 5, 'update', 'userName', NULL, 'extprolea', '2011-09-01 18:57:10', 1),
(41, 'Contact', 6, 'insert', NULL, NULL, NULL, '2011-09-01 18:57:18', 1),
(42, 'Contact', 6, 'update', 'name', 'external project leader one', 'external project leader two', '2011-09-01 18:57:37', 1),
(43, 'Contact', 6, 'update', 'idClient', '1', '2', '2011-09-01 18:57:37', 1),
(44, 'Contact', 6, 'update', 'userName', 'extprolea', 'external2', '2011-09-01 18:57:37', 1),
(45, 'Contact', 5, 'update', 'userName', 'extprolea', 'external1', '2011-09-01 18:57:45', 1),
(46, 'Contact', 7, 'insert', NULL, NULL, NULL, '2011-09-01 18:58:14', 1),
(47, 'Contact', 7, 'update', 'idProfile', NULL, '5', '2011-09-01 18:58:24', 1),
(48, 'Contact', 5, 'update', 'isUser', '0', '1', '2011-09-01 19:46:37', 1),
(49, 'Contact', 6, 'update', 'isUser', '0', '1', '2011-09-01 19:46:43', 1),
(50, 'Project', 3, 'insert', NULL, NULL, NULL, '2011-09-01 19:47:06', 1),
(51, 'ProjectPlanningElement', 3, 'insert', NULL, NULL, NULL, '2011-09-01 19:47:06', 1),
(52, 'Project', 3, 'update', 'name', 'project one - subproject 1', 'project one - subproject 2', '2011-09-01 19:47:26', 1),
(53, 'Project', 3, 'update', 'projectCode', '001-001-1', '001-001-2', '2011-09-01 19:47:26', 1),
(54, 'ProjectPlanningElement', 3, 'update', 'idProject', '2', '3', '2011-09-01 19:47:26', 1),
(55, 'ProjectPlanningElement', 3, 'update', 'refName', 'project one - subproject 1', 'project one - subproject 2', '2011-09-01 19:47:26', 1),
(56, 'Project', 4, 'insert', NULL, NULL, NULL, '2011-09-01 19:47:50', 1),
(57, 'ProjectPlanningElement', 4, 'insert', NULL, NULL, NULL, '2011-09-01 19:47:50', 1),
(58, 'Project', 4, 'update', 'name', 'project one', 'project two', '2011-09-01 19:48:32', 1),
(59, 'Project', 4, 'update', 'idClient', '1', '2', '2011-09-01 19:48:32', 1),
(60, 'Project', 4, 'update', 'projectCode', '001-001', '002-002', '2011-09-01 19:48:32', 1),
(61, 'Project', 4, 'update', 'contractCode', 'X23-472-722', 'X24-001-007', '2011-09-01 19:48:32', 1),
(62, 'ProjectPlanningElement', 4, 'update', 'idProject', '1', '4', '2011-09-01 19:48:32', 1),
(63, 'ProjectPlanningElement', 4, 'update', 'refName', 'project one', 'project two', '2011-09-01 19:48:32', 1),
(64, 'Project', 4, 'update', 'idUser', NULL, '6', '2011-09-01 19:48:46', 1),
(65, 'Project', 1, 'update', 'idUser', NULL, '5', '2011-09-01 19:48:53', 1),
(66, 'Project', 2, 'update', 'idUser', NULL, '5', '2011-09-01 19:49:00', 1),
(67, 'Project', 3, 'update', 'idUser', NULL, '5', '2011-09-01 19:49:06', 1),
(68, 'Product', 2, 'insert', NULL, NULL, NULL, '2011-09-01 19:50:04', 1),
(69, 'Product', 1, 'update', 'idContact', NULL, '5', '2011-09-01 19:50:19', 1),
(70, 'Version', 1, 'insert', NULL, NULL, NULL, '2011-09-01 19:50:53', 1),
(71, 'VersionProject', 1, 'insert', NULL, NULL, NULL, '2011-09-01 19:51:07', 1),
(72, 'VersionProject', 2, 'insert', NULL, NULL, NULL, '2011-09-01 19:51:15', 1),
(73, 'Project', 2, 'update', 'name', 'project one - subproject 1', 'project one - subproject 1 - maintenance', '2011-09-01 19:52:11', 1),
(74, 'Project', 2, 'update', 'description', '1st project\nThis project has 2 sub-projects', 'This project is dedicated to maintenance of web app V1.0', '2011-09-01 19:52:11', 1),
(75, 'ProjectPlanningElement', 2, 'update', 'refName', 'project one - subproject 1', 'project one - subproject 1 - maintenance', '2011-09-01 19:52:11', 1),
(76, 'Project', 2, 'update', 'description', 'This project is dedicated to maintenance of web app V1.0', 'This project is dedicated to maintenance of "web application" V1.0', '2011-09-01 19:52:23', 1),
(77, 'Project', 2, 'update', 'description', 'This project is dedicated to maintenance of "web application" V1.0', 'This project is dedicated to maintenance of ''''web application'''' V1.0\nIt is sub-project of project one.', '2011-09-01 19:52:38', 1),
(78, 'Project', 3, 'update', 'name', 'project one - subproject 2', 'project one - subproject 2 - developement', '2011-09-01 19:52:46', 1),
(79, 'ProjectPlanningElement', 3, 'update', 'refName', 'project one - subproject 2', 'project one - subproject 2 - developement', '2011-09-01 19:52:46', 1),
(80, 'Project', 3, 'update', 'description', '1st project\nThis project has 2 sub-projects', 'This project is dedicated to developement of ''''web application'''' V2.0\nIt is sub-project of project one.', '2011-09-01 19:53:25', 1),
(81, 'Project', 5, 'insert', NULL, NULL, NULL, '2011-09-01 20:31:03', 1),
(82, 'ProjectPlanningElement', 5, 'insert', NULL, NULL, NULL, '2011-09-01 20:31:03', 1),
(83, 'Project', 5, 'update', 'description', 'internal project', 'internal project\nout of project work', '2011-09-01 20:31:31', 1),
(84, 'ProjectPlanningElement', 5, 'update', 'idProject', NULL, '5', '2011-09-01 20:31:31', 1),
(85, 'Project', 6, 'insert', NULL, NULL, NULL, '2011-09-01 20:32:16', 1),
(86, 'ProjectPlanningElement', 6, 'insert', NULL, NULL, NULL, '2011-09-01 20:32:16', 1),
(87, 'PlanningElement', 5, 'update', 'elementary', '1', '0', '2011-09-01 20:32:16', 1),
(88, 'Version', 2, 'insert', NULL, NULL, NULL, '2011-09-01 20:33:15', 1),
(89, 'Version', 1, 'update', 'name', 'wa W1.0', 'wa V1.0', '2011-09-01 20:33:25', 1),
(90, 'VersionProject', 3, 'insert', NULL, NULL, NULL, '2011-09-01 20:33:35', 1),
(91, 'VersionProject', 4, 'insert', NULL, NULL, NULL, '2011-09-01 20:33:41', 1),
(92, 'Product', 3, 'insert', NULL, NULL, NULL, '2011-09-01 21:01:15', 1),
(93, 'Product', 3, 'delete', NULL, NULL, NULL, '2011-09-01 21:01:41', 1),
(94, 'Project', 2, 'update', 'color', '#4169e1', '#6495ed', '2011-09-01 21:39:00', 1),
(95, 'Project', 3, 'update', 'color', '#4169e1', '#87ceeb', '2011-09-01 21:39:09', 1),
(96, 'Project', 1, 'update', 'color', '#4169e1', '#6a5acd', '2011-09-01 21:39:20', 1),
(97, 'Project', 4, 'update', 'color', '#4169e1', '#b22222', '2011-09-01 21:39:31', 1),
(98, 'Project', 5, 'update', 'color', NULL, '#008b8b', '2011-09-01 21:39:42', 1),
(99, 'Project', 6, 'update', 'color', NULL, '#20b2aa', '2011-09-01 21:39:54', 1),
(100, 'ProjectPlanningElement', 6, 'update', 'idProject', NULL, '6', '2011-09-01 21:39:54', 1),
(101, 'Version', 3, 'insert', NULL, NULL, NULL, '2011-09-01 21:55:43', 1),
(102, 'Version', 3, 'update', 'idContact', NULL, '6', '2011-09-01 21:55:52', 1),
(103, 'Version', 3, 'update', 'idResource', NULL, '3', '2011-09-01 21:55:52', 1),
(104, 'VersionProject', 5, 'insert', NULL, NULL, NULL, '2011-09-01 21:56:15', 1),
(105, 'VersionProject', 5, 'update', 'startDate', NULL, '2011-09-01', '2011-09-01 21:56:31', 1),
(106, 'VersionProject', 5, 'update', 'endDate', NULL, '2011-12-31', '2011-09-01 21:56:31', 1),
(107, 'User', 3, 'update', 'name', 'pl', 'manager1', '2011-09-01 21:59:24', 1),
(108, 'User', 4, 'update', 'name', 'John DOE', 'memeber1', '2011-09-01 21:59:39', 1),
(109, 'Resource', 4, 'update', 'idTeam', NULL, '1', '2011-09-01 22:00:29', 1),
(110, 'Resource', 3, 'update', 'idTeam', NULL, '1', '2011-09-01 22:00:39', 1),
(111, 'Team', 1, 'update', 'name', 'developement team', 'web team', '2011-09-01 22:00:52', 1),
(112, 'Team', 2, 'update', 'name', 'maintenance team', 'swing team', '2011-09-01 22:01:01', 1),
(113, 'Resource', 8, 'insert', NULL, NULL, NULL, '2011-09-01 22:01:59', 1),
(114, 'Resource', 8, 'update', 'idRole', NULL, '2', '2011-09-01 22:02:07', 1),
(115, 'Resource', 9, 'insert', NULL, NULL, NULL, '2011-09-01 22:02:45', 1),
(116, 'Resource', 9, 'update', 'idRole', NULL, '2', '2011-09-01 22:02:49', 1),
(117, 'Resource', 10, 'insert', NULL, NULL, NULL, '2011-09-01 22:03:28', 1),
(118, 'Resource', 10, 'update', 'idRole', NULL, '3', '2011-09-01 22:03:34', 1),
(119, 'Resource', 11, 'insert', NULL, NULL, NULL, '2011-09-01 22:04:09', 1),
(120, 'Resource', 12, 'insert', NULL, NULL, NULL, '2011-09-01 22:04:42', 1),
(121, 'Affectation', 1, 'insert', NULL, NULL, NULL, '2011-09-01 22:10:13', 1),
(122, 'Affectation', 2, 'insert', NULL, NULL, NULL, '2011-09-01 22:10:29', 1),
(123, 'Affectation', 3, 'insert', NULL, NULL, NULL, '2011-09-01 22:10:50', 1),
(124, 'Affectation', 4, 'insert', NULL, NULL, NULL, '2011-09-01 22:11:30', 1),
(125, 'Affectation', 5, 'insert', NULL, NULL, NULL, '2011-09-01 22:11:41', 1),
(126, 'Affectation', 6, 'insert', NULL, NULL, NULL, '2011-09-01 22:11:58', 1),
(127, 'Affectation', 7, 'insert', NULL, NULL, NULL, '2011-09-01 22:12:12', 1),
(128, 'Affectation', 8, 'insert', NULL, NULL, NULL, '2011-09-01 22:12:26', 1),
(129, 'Affectation', 9, 'insert', NULL, NULL, NULL, '2011-09-01 22:12:41', 1),
(130, 'Affectation', 10, 'insert', NULL, NULL, NULL, '2011-09-01 22:13:08', 1),
(131, 'Affectation', 11, 'insert', NULL, NULL, NULL, '2011-09-01 22:13:25', 1),
(132, 'Affectation', 12, 'insert', NULL, NULL, NULL, '2011-09-01 22:13:39', 1),
(133, 'Affectation', 13, 'insert', NULL, NULL, NULL, '2011-09-01 22:15:15', 1),
(134, 'Affectation', 7, 'update', 'rate', '100', '0', '2011-09-01 22:21:56', 1),
(135, 'Affectation', 8, 'update', 'rate', '100', '0', '2011-09-01 22:22:04', 1),
(136, 'Affectation', 9, 'update', 'rate', '100', '0', '2011-09-01 22:22:16', 1),
(137, 'Resource', 10, 'update', 'name', 'web devloper', 'web developer', '2011-09-01 22:23:16', 1),
(138, 'Resource', 12, 'update', 'name', 'multi devloper', 'multi developer', '2011-09-01 22:23:28', 1),
(139, 'Resource', 11, 'update', 'name', 'swing devloper', 'swing developer', '2011-09-01 22:23:34', 1),
(140, 'Resource', 4, 'update', 'userName', 'memeber1', 'member1', '2011-09-01 22:23:47', 1),
(141, 'Calendar', 1, 'insert', NULL, NULL, NULL, '2011-09-01 22:24:51', 1),
(142, 'Calendar', 2, 'insert', NULL, NULL, NULL, '2011-09-01 22:25:15', 1),
(143, 'Affectation', 14, 'insert', NULL, NULL, NULL, '2011-09-01 22:33:01', 1),
(144, 'Affectation', 15, 'insert', NULL, NULL, NULL, '2011-09-01 22:34:21', 1),
(145, 'Affectation', 16, 'insert', NULL, NULL, NULL, '2011-09-01 22:34:56', 1),
(146, 'Affectation', 17, 'insert', NULL, NULL, NULL, '2011-09-01 22:36:04', 1),
(147, 'Affectation', 17, 'delete', NULL, NULL, NULL, '2011-09-01 22:36:17', 1),
(148, 'Ticket', 1, 'insert', NULL, NULL, NULL, '2011-09-02 01:45:12', 1),
(149, 'Ticket', 1, 'update', 'idUrgency', NULL, '2', '2011-09-02 01:54:51', 1),
(150, 'Ticket', 1, 'update', 'creationDateTime', '2011-09-02 01:44:00', '2011-09-01 12:00:00', '2011-09-02 01:54:51', 1),
(151, 'Ticket', 1, 'update', 'idOriginalVersion', NULL, '1', '2011-09-02 01:54:51', 1),
(152, 'Ticket', 1, 'update', 'idStatus', '1', '3', '2011-09-02 01:54:51', 1),
(153, 'Ticket', 1, 'update', 'idResource', NULL, '3', '2011-09-02 01:54:51', 1),
(154, 'Ticket', 1, 'update', 'idCriticality', NULL, '1', '2011-09-02 01:54:51', 1),
(155, 'Ticket', 1, 'update', 'idPriority', NULL, '1', '2011-09-02 01:54:52', 1),
(156, 'Ticket', 1, 'update', 'initialDueDateTime', NULL, '2011-09-02 18:00:00', '2011-09-02 01:54:52', 1),
(157, 'Ticket', 1, 'update', 'actualDueDateTime', NULL, '2011-09-02 18:30:00', '2011-09-02 01:54:52', 1),
(158, 'Ticket', 1, 'update', 'handled', '0', '1', '2011-09-02 01:54:52', 1),
(159, 'Ticket', 1, 'update', 'handledDateTime', NULL, '2011-09-02 01:54:00', '2011-09-02 01:54:52', 1),
(160, 'Activity', 1, 'insert', NULL, NULL, NULL, '2011-09-02 10:13:01', 1),
(161, 'ActivityPlanningElement', 7, 'insert', NULL, NULL, NULL, '2011-09-02 10:13:01', 1),
(162, 'Activity', 1, 'update', 'idStatus', '1', '3', '2011-09-02 10:13:19', 1),
(163, 'Activity', 1, 'update', 'idResource', NULL, '3', '2011-09-02 10:13:19', 1),
(164, 'Activity', 1, 'update', 'handled', '0', '1', '2011-09-02 10:13:19', 1),
(165, 'Activity', 1, 'update', 'handledDate', NULL, '2011-09-01', '2011-09-02 10:13:19', 1),
(166, 'Assignment', 1, 'insert', NULL, NULL, NULL, '2011-09-02 10:13:20', 1),
(167, 'ActivityPlanningElement', 7, 'update', 'validatedStartDate', NULL, '2011-09-01', '2011-09-02 10:13:33', 1),
(168, 'ActivityPlanningElement', 7, 'update', 'validatedEndDate', NULL, '2011-12-31', '2011-09-02 10:13:33', 1),
(169, 'ActivityPlanningElement', 7, 'update', 'validatedDuration', NULL, '87', '2011-09-02 10:13:33', 1),
(170, 'Activity', 1, 'update', 'idProject', '1', '2', '2011-09-02 10:13:48', 1),
(171, 'ActivityPlanningElement', 7, 'update', 'idProject', '1', '2', '2011-09-02 10:13:49', 1),
(172, 'ActivityPlanningElement', 7, 'update', 'wbs', '1.3', '1.1.1', '2011-09-02 10:13:49', 1),
(173, 'ActivityPlanningElement', 7, 'update', 'wbsSortable', '001.003', '001.001.001', '2011-09-02 10:13:49', 1),
(174, 'ActivityPlanningElement', 7, 'update', 'topId', '1', '2', '2011-09-02 10:13:49', 1),
(175, 'ActivityPlanningElement', 7, 'update', 'topRefId', '1', '2', '2011-09-02 10:13:49', 1),
(176, 'PlanningElement', 2, 'update', 'elementary', '1', '0', '2011-09-02 10:13:49', 1),
(177, 'Assignment', 1, 'update', 'idProject', '1', '2', '2011-09-02 10:13:49', 1),
(178, 'Assignment', 1, 'update', 'realWork', NULL, '0', '2011-09-02 10:13:49', 1),
(179, 'Assignment', 1, 'update', 'plannedWork', NULL, '0', '2011-09-02 10:13:49', 1),
(180, 'Assignment', 1, 'update', 'assignedCost', NULL, '0', '2011-09-02 10:13:49', 1),
(181, 'Assignment', 1, 'update', 'leftCost', NULL, '0', '2011-09-02 10:13:49', 1),
(182, 'Assignment', 1, 'update', 'plannedCost', NULL, '0', '2011-09-02 10:13:49', 1),
(183, 'Assignment', 1, 'update', 'assignedWork', NULL, '10', '2011-09-02 10:17:59', 1),
(184, 'Assignment', 1, 'update', 'leftWork', NULL, '10', '2011-09-02 10:17:59', 1),
(185, 'Assignment', 1, 'update', 'plannedWork', '0.00', '10', '2011-09-02 10:17:59', 1),
(186, 'Assignment', 1, 'update', 'rate', '100', '20', '2011-09-02 10:17:59', 1),
(187, 'Assignment', 1, 'update', 'assignedCost', '0.00', '5000', '2011-09-02 10:17:59', 1),
(188, 'Assignment', 1, 'update', 'leftCost', '0.00', '5000', '2011-09-02 10:17:59', 1),
(189, 'Assignment', 1, 'update', 'plannedCost', '0.00', '5000', '2011-09-02 10:17:59', 1),
(190, 'ActivityPlanningElement', 7, 'update', 'idActivityPlanningMode', '1', '3', '2011-09-02 10:18:09', 1),
(191, 'ActivityPlanningElement', 7, 'update', 'idActivityPlanningMode', '3', '7', '2011-09-02 10:18:23', 1),
(192, 'Assignment', 2, 'insert', NULL, NULL, NULL, '2011-09-02 10:18:55', 1),
(193, 'ResourceCost', 2, 'insert', NULL, NULL, NULL, '2011-09-02 10:22:45', 1),
(194, 'ResourceCost', 3, 'insert', NULL, NULL, NULL, '2011-09-02 10:22:52', 1),
(195, 'ResourceCost', 4, 'insert', NULL, NULL, NULL, '2011-09-02 10:22:59', 1),
(196, 'ResourceCost', 5, 'insert', NULL, NULL, NULL, '2011-09-02 10:23:06', 1),
(197, 'Assignment', 2, 'update', 'realWork', NULL, '0', '2011-09-02 10:23:06', 1),
(198, 'Assignment', 2, 'update', 'dailyCost', NULL, '220.00', '2011-09-02 10:23:07', 1),
(199, 'Assignment', 2, 'update', 'newDailyCost', NULL, '220.00', '2011-09-02 10:23:07', 1),
(200, 'Assignment', 2, 'update', 'assignedCost', NULL, '0', '2011-09-02 10:23:07', 1),
(201, 'Assignment', 2, 'update', 'realCost', NULL, '0', '2011-09-02 10:23:07', 1),
(202, 'Assignment', 2, 'update', 'leftCost', NULL, '22000', '2011-09-02 10:23:07', 1),
(203, 'Assignment', 2, 'update', 'plannedCost', NULL, '22000', '2011-09-02 10:23:07', 1),
(204, 'ResourceCost', 6, 'insert', NULL, NULL, NULL, '2011-09-02 10:23:14', 1),
(205, 'ResourceCost', 7, 'insert', NULL, NULL, NULL, '2011-09-02 10:23:21', 1),
(206, 'Assignment', 2, 'update', 'assignedCost', '0.00', '22000', '2011-09-02 10:23:36', 1),
(207, 'Activity', 2, 'insert', NULL, NULL, NULL, '2011-09-02 11:05:06', 1),
(208, 'ActivityPlanningElement', 8, 'insert', NULL, NULL, NULL, '2011-09-02 11:05:06', 1),
(209, 'PlanningElement', 3, 'update', 'elementary', '1', '0', '2011-09-02 11:05:06', 1),
(210, 'Activity', 3, 'insert', NULL, NULL, NULL, '2011-09-02 11:05:28', 1),
(211, 'ActivityPlanningElement', 9, 'insert', NULL, NULL, NULL, '2011-09-02 11:05:28', 1),
(212, 'Activity', 3, 'update', 'idProject', '1', '3', '2011-09-02 11:05:57', 1),
(213, 'Activity', 3, 'update', 'idActivity', NULL, '2', '2011-09-02 11:05:57', 1),
(214, 'ActivityPlanningElement', 9, 'update', 'idProject', '1', '3', '2011-09-02 11:05:57', 1),
(215, 'ActivityPlanningElement', 9, 'update', 'wbs', '1.3', '1.2.1.1', '2011-09-02 11:05:58', 1),
(216, 'ActivityPlanningElement', 9, 'update', 'wbsSortable', '001.003', '001.002.001.001', '2011-09-02 11:05:58', 1),
(217, 'ActivityPlanningElement', 9, 'update', 'topId', '1', '8', '2011-09-02 11:05:58', 1),
(218, 'ActivityPlanningElement', 9, 'update', 'topRefType', 'Project', 'Activity', '2011-09-02 11:05:58', 1),
(219, 'ActivityPlanningElement', 9, 'update', 'topRefId', '1', '2', '2011-09-02 11:05:58', 1),
(220, 'PlanningElement', 8, 'update', 'elementary', '1', '0', '2011-09-02 11:05:58', 1),
(221, 'Project', 2, 'update', 'name', 'project one - subproject 1 - maintenance', 'project one - maintenance', '2011-09-02 11:06:24', 1),
(222, 'ProjectPlanningElement', 2, 'update', 'refName', 'project one - subproject 1 - maintenance', 'project one - maintenance', '2011-09-02 11:06:25', 1),
(223, 'Project', 3, 'update', 'name', 'project one - subproject 2 - developement', 'project one - developement', '2011-09-02 11:06:32', 1),
(224, 'ProjectPlanningElement', 3, 'update', 'refName', 'project one - subproject 2 - developement', 'project one - developement', '2011-09-02 11:06:32', 1),
(225, 'Activity', 4, 'insert', NULL, NULL, NULL, '2011-09-02 11:07:05', 1),
(226, 'ActivityPlanningElement', 10, 'insert', NULL, NULL, NULL, '2011-09-02 11:07:05', 1),
(227, 'Dependency', 1, 'insert', NULL, NULL, NULL, '2011-09-02 11:07:29', 1),
(228, 'Activity', 4, 'update', 'idProject', '1', '3', '2011-09-02 11:07:43', 1),
(229, 'Activity', 4, 'update', 'idActivity', NULL, '2', '2011-09-02 11:07:44', 1),
(230, 'ActivityPlanningElement', 10, 'update', 'idProject', '1', '3', '2011-09-02 11:07:44', 1),
(231, 'ActivityPlanningElement', 10, 'update', 'wbs', '1.3', '1.2.1.2', '2011-09-02 11:07:44', 1),
(232, 'ActivityPlanningElement', 10, 'update', 'wbsSortable', '001.003', '001.002.001.002', '2011-09-02 11:07:44', 1),
(233, 'ActivityPlanningElement', 10, 'update', 'topId', '1', '8', '2011-09-02 11:07:44', 1),
(234, 'ActivityPlanningElement', 10, 'update', 'topRefType', 'Project', 'Activity', '2011-09-02 11:07:44', 1),
(235, 'ActivityPlanningElement', 10, 'update', 'topRefId', '1', '2', '2011-09-02 11:07:44', 1),
(236, 'Activity', 5, 'insert', NULL, NULL, NULL, '2011-09-02 11:08:12', 1),
(237, 'ActivityPlanningElement', 11, 'insert', NULL, NULL, NULL, '2011-09-02 11:08:12', 1),
(238, 'Dependency', 2, 'insert', NULL, NULL, NULL, '2011-09-02 11:08:26', 1),
(239, 'Milestone', 1, 'insert', NULL, NULL, NULL, '2011-09-02 17:26:06', 1),
(240, 'MilestonePlanningElement', 12, 'insert', NULL, NULL, NULL, '2011-09-02 17:26:06', 1),
(241, 'Dependency', 3, 'insert', NULL, NULL, NULL, '2011-09-02 17:26:23', 1),
(242, 'Assignment', 3, 'insert', NULL, NULL, NULL, '2011-09-02 17:27:07', 1),
(243, 'Assignment', 4, 'insert', NULL, NULL, NULL, '2011-09-02 17:27:25', 1),
(244, 'Assignment', 5, 'insert', NULL, NULL, NULL, '2011-09-02 17:27:45', 1),
(245, 'PlanningElement', 12, 'update', 'plannedStartDate', NULL, '2011-09-27', '2011-09-02 17:27:53', 1),
(246, 'PlanningElement', 12, 'update', 'plannedEndDate', NULL, '2011-09-27', '2011-09-02 17:27:53', 1),
(247, 'PlanningElement', 12, 'update', 'plannedDuration', NULL, '1', '2011-09-02 17:27:53', 1),
(248, 'Assignment', 2, 'update', 'rate', '100', '50', '2011-09-02 17:29:30', 1),
(249, 'Milestone', 1, 'update', 'idActivity', NULL, '2', '2011-09-02 17:30:16', 1),
(250, 'Milestone', 1, 'update', 'idStatus', '0', '1', '2011-09-02 17:30:16', 1),
(251, 'MilestonePlanningElement', 12, 'update', 'wbs', '1.2.2', '1.2.1.4', '2011-09-02 17:30:16', 1),
(252, 'MilestonePlanningElement', 12, 'update', 'wbsSortable', '001.002.002', '001.002.001.004', '2011-09-02 17:30:16', 1),
(253, 'MilestonePlanningElement', 12, 'update', 'topId', '3', '8', '2011-09-02 17:30:16', 1),
(254, 'MilestonePlanningElement', 12, 'update', 'topRefType', 'Project', 'Activity', '2011-09-02 17:30:16', 1),
(255, 'MilestonePlanningElement', 12, 'update', 'topRefId', '3', '2', '2011-09-02 17:30:16', 1),
(256, 'MilestonePlanningElement', 12, 'update', 'initialDuration', NULL, '0', '2011-09-02 17:30:16', 1),
(257, 'MilestonePlanningElement', 12, 'update', 'validatedDuration', NULL, '0', '2011-09-02 17:30:17', 1),
(258, 'MilestonePlanningElement', 12, 'update', 'initialWork', NULL, '0', '2011-09-02 17:30:17', 1),
(259, 'MilestonePlanningElement', 12, 'update', 'validatedWork', NULL, '0', '2011-09-02 17:30:17', 1),
(260, 'MilestonePlanningElement', 12, 'update', 'plannedWork', NULL, '0', '2011-09-02 17:30:17', 1),
(261, 'MilestonePlanningElement', 12, 'update', 'realWork', NULL, '0', '2011-09-02 17:30:17', 1),
(262, 'Resource', 8, 'update', 'capacity', '0.50', '1', '2011-09-02 17:31:54', 1),
(263, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-09-27', '2011-09-15', '2011-09-02 17:32:06', 1),
(264, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-09-27', '2011-09-15', '2011-09-02 17:32:06', 1),
(265, 'Activity', 6, 'insert', NULL, NULL, NULL, '2011-09-02 17:39:52', 1),
(266, 'ActivityPlanningElement', 13, 'insert', NULL, NULL, NULL, '2011-09-02 17:39:52', 1),
(267, 'Activity', 6, 'update', 'idStatus', '0', '1', '2011-09-02 17:40:17', 1),
(268, 'ActivityPlanningElement', 13, 'update', 'idActivityPlanningMode', '1', '8', '2011-09-02 17:40:17', 1),
(269, 'ActivityPlanningElement', 13, 'update', 'validatedDuration', NULL, '5', '2011-09-02 17:40:18', 1),
(270, 'Dependency', 4, 'insert', NULL, NULL, NULL, '2011-09-02 17:40:51', 1),
(271, 'PlanningElement', 13, 'update', 'plannedStartDate', NULL, '2011-09-16', '2011-09-02 17:40:58', 1),
(272, 'PlanningElement', 13, 'update', 'plannedEndDate', NULL, '2011-09-22', '2011-09-02 17:40:58', 1),
(273, 'PlanningElement', 13, 'update', 'plannedDuration', NULL, '5', '2011-09-02 17:40:58', 1),
(274, 'Assignment', 2, 'update', 'assignedWork', '100.00', '75', '2011-09-02 17:45:05', 1),
(275, 'Assignment', 2, 'update', 'leftWork', '100.00', '75', '2011-09-02 17:45:05', 1),
(276, 'Assignment', 2, 'update', 'plannedWork', '100.00', '75', '2011-09-02 17:45:05', 1),
(277, 'Assignment', 2, 'update', 'assignedCost', '22000.00', '16500', '2011-09-02 17:45:05', 1),
(278, 'Assignment', 2, 'update', 'leftCost', '22000.00', '16500', '2011-09-02 17:45:05', 1),
(279, 'Assignment', 2, 'update', 'plannedCost', '22000.00', '16500', '2011-09-02 17:45:05', 1),
(280, 'Assignment', 3, 'update', 'realWork', '0.00', '2.5', '2011-09-02 17:47:46', 1),
(281, 'Assignment', 3, 'update', 'leftWork', '5.00', '2.5', '2011-09-02 17:47:46', 1),
(282, 'Assignment', 3, 'update', 'realStartDate', NULL, '2011-09-05', '2011-09-02 17:47:46', 1),
(283, 'Assignment', 3, 'update', 'realEndDate', NULL, '2011-09-07', '2011-09-02 17:47:46', 1),
(284, 'Assignment', 3, 'update', 'realCost', NULL, '750', '2011-09-02 17:47:46', 1),
(285, 'Assignment', 3, 'update', 'leftCost', '1500.00', '750', '2011-09-02 17:47:46', 1),
(286, 'Assignment', 5, 'update', 'realCost', NULL, '0', '2011-09-02 17:47:46', 1),
(287, 'Assignment', 5, 'update', 'comment', NULL, 'Work could be anticipated to prepar tests', '2011-09-02 17:50:29', 1),
(288, 'Assignment', 5, 'update', 'comment', 'Work could be anticipated to prepar tests', 'Work could be anticipated to prepare tests', '2011-09-02 17:50:36', 1),
(289, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-09-15', '2011-09-20', '2011-09-02 18:22:41', 1),
(290, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-09-15', '2011-09-20', '2011-09-02 18:22:41', 1),
(291, 'PlanningElement', 13, 'update', 'plannedStartDate', '2011-09-16', '2011-09-21', '2011-09-02 18:22:42', 1),
(292, 'PlanningElement', 13, 'update', 'plannedEndDate', '2011-09-22', '2011-09-27', '2011-09-02 18:22:42', 1),
(293, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-09-20', '2011-09-19', '2011-09-02 18:23:49', 1),
(294, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-09-20', '2011-09-19', '2011-09-02 18:23:49', 1),
(295, 'PlanningElement', 13, 'update', 'plannedStartDate', '2011-09-21', '2011-09-20', '2011-09-02 18:23:49', 1),
(296, 'PlanningElement', 13, 'update', 'plannedEndDate', '2011-09-27', '2011-09-26', '2011-09-02 18:23:49', 1),
(297, 'Workflow', 2, 'update', 'workflowUpdate', '[      ]', '[     ]', '2011-09-03 00:53:35', 1),
(298, 'Activity', 2, 'update', 'idStatus', '1', '3', '2011-09-03 01:11:55', 1),
(299, 'Activity', 2, 'update', 'idResource', NULL, '8', '2011-09-03 01:11:55', 1),
(300, 'Activity', 2, 'update', 'handled', '0', '1', '2011-09-03 01:11:56', 1),
(301, 'Activity', 2, 'update', 'handledDate', NULL, '2011-09-03', '2011-09-03 01:11:56', 1),
(302, 'Affectation', 18, 'insert', NULL, NULL, NULL, '2011-09-03 01:12:32', 1),
(303, 'Activity', 2, 'update', 'idVersion', NULL, '2', '2011-09-03 01:16:09', 1),
(304, 'Assignment', 3, 'update', 'assignedWork', '5.00', '3', '2011-09-03 01:46:01', 1),
(305, 'Assignment', 3, 'update', 'leftWork', '2.50', '0.5', '2011-09-03 01:46:01', 1),
(306, 'Assignment', 3, 'update', 'plannedWork', '5.00', '3', '2011-09-03 01:46:01', 1),
(307, 'Assignment', 3, 'update', 'assignedCost', '1500.00', '900', '2011-09-03 01:46:01', 1),
(308, 'Assignment', 3, 'update', 'leftCost', '750.00', '150', '2011-09-03 01:46:01', 1),
(309, 'Assignment', 3, 'update', 'plannedCost', '1500.00', '900', '2011-09-03 01:46:01', 1),
(310, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-09-19', '2011-09-13', '2011-09-03 01:46:08', 1),
(311, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-09-19', '2011-09-13', '2011-09-03 01:46:08', 1),
(312, 'PlanningElement', 13, 'update', 'plannedStartDate', '2011-09-20', '2011-09-14', '2011-09-03 01:46:08', 1),
(313, 'PlanningElement', 13, 'update', 'plannedEndDate', '2011-09-26', '2011-09-20', '2011-09-03 01:46:08', 1),
(314, 'Assignment', 3, 'update', 'assignedWork', '3.00', '5', '2011-09-03 01:46:51', 1),
(315, 'Assignment', 3, 'update', 'leftWork', '0.50', '2.5', '2011-09-03 01:46:51', 1),
(316, 'Assignment', 3, 'update', 'plannedWork', '3.00', '5', '2011-09-03 01:46:51', 1),
(317, 'Assignment', 3, 'update', 'assignedCost', '900.00', '1500', '2011-09-03 01:46:51', 1),
(318, 'Assignment', 3, 'update', 'leftCost', '150.00', '750', '2011-09-03 01:46:51', 1),
(319, 'Assignment', 3, 'update', 'plannedCost', '900.00', '1500', '2011-09-03 01:46:51', 1),
(320, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-09-13', '2011-09-19', '2011-09-03 01:46:57', 1),
(321, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-09-13', '2011-09-19', '2011-09-03 01:46:57', 1),
(322, 'PlanningElement', 13, 'update', 'plannedStartDate', '2011-09-14', '2011-09-20', '2011-09-03 01:46:57', 1),
(323, 'PlanningElement', 13, 'update', 'plannedEndDate', '2011-09-20', '2011-09-26', '2011-09-03 01:46:57', 1),
(324, 'Habilitation', 487, 'delete', NULL, NULL, NULL, '2011-10-13 17:24:06', NULL),
(325, 'Ticket', 1, 'update', 'actualDueDateTime', '2011-09-02 18:30:00', '2011-09-09 18:30:00', '2011-10-13 17:24:39', 1),
(326, 'User', 3, 'update', 'password', NULL, '6d361b76b20af1a3ebbf75a00b501766', '2011-10-13 17:31:47', 1),
(327, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-09-19', '2011-10-26', '2011-10-13 17:54:53', 1),
(328, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-09-19', '2011-10-26', '2011-10-13 17:54:54', 1),
(329, 'PlanningElement', 13, 'update', 'plannedStartDate', '2011-09-20', '2011-10-27', '2011-10-13 17:54:54', 1),
(330, 'PlanningElement', 13, 'update', 'plannedEndDate', '2011-09-26', '2011-11-02', '2011-10-13 17:54:54', 1),
(331, 'Affectation', 19, 'insert', NULL, NULL, NULL, '2011-10-13 18:25:42', 1),
(332, 'Affectation', 20, 'insert', NULL, NULL, NULL, '2011-10-13 18:25:51', 1),
(333, 'PlanningElement', 12, 'update', 'plannedStartDate', '2011-10-26', '2011-10-21', '2011-10-13 18:33:16', 1),
(334, 'PlanningElement', 12, 'update', 'plannedEndDate', '2011-10-26', '2011-10-21', '2011-10-13 18:33:16', 1),
(335, 'PlanningElement', 13, 'update', 'plannedStartDate', '2011-10-27', '2011-10-24', '2011-10-13 18:33:17', 1),
(336, 'PlanningElement', 13, 'update', 'plannedEndDate', '2011-11-02', '2011-10-28', '2011-10-13 18:33:17', 1),
(337, 'Assignment', 3, 'update', 'realWork', '2.50000', '5.7', '2011-10-13 18:33:49', 1),
(338, 'Assignment', 3, 'update', 'leftWork', '2.50000', '0', '2011-10-13 18:33:49', 1),
(339, 'Assignment', 3, 'update', 'plannedWork', '5.00000', '5.7', '2011-10-13 18:33:49', 1),
(340, 'Assignment', 3, 'update', 'realEndDate', '2011-09-07', '2011-10-13', '2011-10-13 18:33:50', 1),
(341, 'Assignment', 3, 'update', 'realCost', '750.00', '1710', '2011-10-13 18:33:50', 1),
(342, 'Assignment', 3, 'update', 'leftCost', '750.00', '0', '2011-10-13 18:33:50', 1),
(343, 'Assignment', 3, 'update', 'plannedCost', '1500.00', '1710', '2011-10-13 18:33:50', 1);

-- --------------------------------------------------------

--
-- Structure de la table `indicator`
--

CREATE TABLE IF NOT EXISTS `indicator` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `indicator`
--

INSERT INTO `indicator` (`id`, `name`, `code`, `type`, `sortOrder`, `idle`) VALUES
(1, 'initialDueDateTime', 'IDDT', 'delay', 110, 0),
(2, 'actualDueDateTime', 'ADDT', 'delay', 120, 0),
(3, 'initialDueDate', 'IDD', 'delay', 130, 0),
(4, 'actualDueDate', 'ADD', 'delay', 140, 0),
(5, 'initialEndDate', 'IED', 'delay', 150, 0),
(6, 'validatedEndDate', 'VED', 'delay', 160, 0),
(7, 'plannedEndDate', 'PED', 'delay', 170, 0),
(8, 'initialStartDate', 'ISD', 'delay', 180, 0),
(9, 'validatedStartDate', 'VSD', 'delay', 190, 0),
(10, 'plannedStartDate', 'PSD', 'delay', 200, 0),
(11, 'PlannedCostOverValidatedCost', 'PCOVC', 'percent', 210, 0),
(12, 'PlannedCostOverAssignedCost', 'PCOAC', 'percent', 220, 0),
(13, 'PlannedWorkOverValidatedWork', 'PWOVW', 'percent', 230, 0),
(14, 'PlannedWorkOverAssignedWork', 'PWOAW', 'percent', 240, 0);

-- --------------------------------------------------------

--
-- Structure de la table `indicatorable`
--

CREATE TABLE IF NOT EXISTS `indicatorable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `indicatorable`
--

INSERT INTO `indicatorable` (`id`, `name`, `idle`) VALUES
(1, 'Ticket', 0),
(2, 'Activity', 0),
(3, 'Milestone', 0),
(4, 'Risk', 0),
(5, 'Action', 0),
(6, 'Issue', 0),
(7, 'Question', 0),
(8, 'Project', 0);

-- --------------------------------------------------------

--
-- Structure de la table `indicatorableindicator`
--

CREATE TABLE IF NOT EXISTS `indicatorableindicator` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idIndicatorable` int(12) unsigned DEFAULT NULL,
  `nameIndicatorable` varchar(100) DEFAULT NULL,
  `idIndicator` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indicatorableindicatorIndicatorable` (`idIndicatorable`),
  KEY `indicatorableindicatorIndicator` (`idIndicator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `indicatorableindicator`
--

INSERT INTO `indicatorableindicator` (`id`, `idIndicatorable`, `nameIndicatorable`, `idIndicator`, `idle`) VALUES
(1, 1, 'Ticket', 1, 0),
(2, 1, 'Ticket', 2, 0),
(3, 4, 'Risk', 3, 0),
(4, 5, 'Action', 3, 0),
(5, 6, 'Issue', 3, 0),
(6, 7, 'Question', 3, 0),
(7, 4, 'Risk', 4, 0),
(8, 5, 'Action', 4, 0),
(9, 6, 'Issue', 4, 0),
(10, 7, 'Question', 4, 0),
(11, 2, 'Activity', 5, 0),
(12, 3, 'Milestone', 5, 0),
(13, 8, 'Project', 5, 0),
(14, 2, 'Activity', 6, 0),
(15, 3, 'Milestone', 6, 0),
(16, 8, 'Project', 6, 0),
(17, 2, 'Activity', 7, 0),
(18, 3, 'Milestone', 7, 0),
(19, 8, 'Project', 7, 0),
(20, 2, 'Activity', 8, 0),
(21, 8, 'Project', 8, 0),
(22, 2, 'Activity', 9, 0),
(23, 8, 'Project', 9, 0),
(24, 2, 'Activity', 10, 0),
(25, 8, 'Project', 10, 0),
(26, 2, 'Activity', 11, 0),
(27, 8, 'Project', 11, 0),
(28, 2, 'Activity', 12, 0),
(29, 8, 'Project', 12, 0),
(30, 2, 'Activity', 13, 0),
(31, 8, 'Project', 13, 0),
(32, 2, 'Activity', 14, 0),
(33, 8, 'Project', 14, 0);

-- --------------------------------------------------------

--
-- Structure de la table `indicatordefinition`
--

CREATE TABLE IF NOT EXISTS `indicatordefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idIndicatorable` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nameIndicatorable` varchar(100) DEFAULT NULL,
  `idIndicator` int(12) unsigned DEFAULT NULL,
  `codeIndicator` varchar(10) DEFAULT NULL,
  `typeIndicator` varchar(10) DEFAULT NULL,
  `idType` int(12) unsigned DEFAULT NULL,
  `warningValue` decimal(6,3) DEFAULT NULL,
  `idWarningDelayUnit` int(12) unsigned DEFAULT NULL,
  `codeWarningDelayUnit` varchar(10) DEFAULT NULL,
  `alertValue` decimal(6,3) DEFAULT NULL,
  `idAlertDelayUnit` int(12) unsigned DEFAULT NULL,
  `codeAlertDelayUnit` varchar(10) DEFAULT NULL,
  `mailToUser` int(1) unsigned DEFAULT '0',
  `mailToResource` int(1) unsigned DEFAULT '0',
  `mailToProject` int(1) unsigned DEFAULT '0',
  `mailToContact` int(1) unsigned DEFAULT '0',
  `mailToLeader` int(1) unsigned DEFAULT '0',
  `mailToOther` int(1) unsigned DEFAULT '0',
  `alertToUser` int(1) unsigned DEFAULT '0',
  `alertToResource` int(1) unsigned DEFAULT '0',
  `alertToProject` int(1) unsigned DEFAULT '0',
  `alertToContact` int(1) unsigned DEFAULT '0',
  `alertToLeader` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indicatordefinitionIndicatorable` (`idIndicatorable`),
  KEY `indicatordefinitionIndicator` (`idIndicator`),
  KEY `indicatordefinitionType` (`idType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `indicatordefinition`
--

INSERT INTO `indicatordefinition` (`id`, `idIndicatorable`, `name`, `nameIndicatorable`, `idIndicator`, `codeIndicator`, `typeIndicator`, `idType`, `warningValue`, `idWarningDelayUnit`, `codeWarningDelayUnit`, `alertValue`, `idAlertDelayUnit`, `codeAlertDelayUnit`, `mailToUser`, `mailToResource`, `mailToProject`, `mailToContact`, `mailToLeader`, `mailToOther`, `alertToUser`, `alertToResource`, `alertToProject`, `alertToContact`, `alertToLeader`, `idle`) VALUES
(1, 1, 'actualDueDateTime', 'Ticket', 2, 'ADDT', 'delay', NULL, 1.000, 1, 'HH', 0.000, 1, 'HH', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0),
(2, 1, 'initialDueDateTime', 'Ticket', 1, 'IDDT', 'delay', NULL, 0.000, 1, 'HH', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(3, 2, 'validatedEndDate', 'Activity', 6, 'VED', 'delay', NULL, 1.000, 4, 'OD', 0.000, 1, 'HH', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0),
(4, 2, 'PlannedWorkOverValidatedWork', 'Activity', 13, 'PWOVW', 'percent', NULL, 100.000, 5, 'PCT', 110.000, 5, 'PCT', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0),
(5, 5, 'actualDueDate', 'Action', 4, 'ADD', 'delay', NULL, 1.000, 4, 'OD', 1.000, 2, 'OH', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(6, 3, 'validatedEndDate', 'Milestone', 6, 'VED', 'delay', 25, 1.000, 4, 'OD', NULL, NULL, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `indicatorvalue`
--

CREATE TABLE IF NOT EXISTS `indicatorvalue` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(10) unsigned DEFAULT NULL,
  `idIndicatorDefinition` int(10) unsigned DEFAULT NULL,
  `targetDateTime` datetime DEFAULT NULL,
  `targetValue` decimal(11,2) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `warningTargetDateTime` datetime DEFAULT NULL,
  `warningTargetValue` decimal(11,2) DEFAULT NULL,
  `warningSent` int(1) unsigned DEFAULT '0',
  `alertTargetDateTime` datetime DEFAULT NULL,
  `alertTargetValue` decimal(11,2) DEFAULT NULL,
  `alertSent` int(1) unsigned DEFAULT '0',
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `status` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indicatorvalueIndicatordefinition` (`idIndicatorDefinition`),
  KEY `indicatorvalueReference` (`refType`,`refId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `indicatorvalue`
--

INSERT INTO `indicatorvalue` (`id`, `refType`, `refId`, `idIndicatorDefinition`, `targetDateTime`, `targetValue`, `code`, `type`, `warningTargetDateTime`, `warningTargetValue`, `warningSent`, `alertTargetDateTime`, `alertTargetValue`, `alertSent`, `handled`, `done`, `idle`, `status`) VALUES
(3, 'Ticket', 1, 1, '2011-09-09 18:30:00', NULL, 'ADDT', 'delay', '2011-09-09 17:30:00', NULL, 1, '2011-09-09 18:30:00', NULL, 1, 1, 0, 0, NULL),
(4, 'Ticket', 1, 2, '2011-09-02 18:00:00', NULL, 'IDDT', 'delay', '2011-09-02 18:00:00', NULL, 1, NULL, NULL, 0, 1, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `issue`
--

CREATE TABLE IF NOT EXISTS `issue` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idIssueType` int(12) unsigned DEFAULT NULL,
  `cause` varchar(4000) DEFAULT NULL,
  `impact` varchar(4000) DEFAULT NULL,
  `idPriority` int(12) unsigned DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `initialEndDate` date DEFAULT NULL,
  `actualEndDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `idCriticality` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issueProject` (`idProject`),
  KEY `issueUser` (`idUser`),
  KEY `issueResource` (`idResource`),
  KEY `issueStatus` (`idStatus`),
  KEY `issueType` (`idIssueType`),
  KEY `issuePriority` (`idPriority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `issue`
--


-- --------------------------------------------------------

--
-- Structure de la table `likelihood`
--

CREATE TABLE IF NOT EXISTS `likelihood` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) unsigned DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `likelihood`
--

INSERT INTO `likelihood` (`id`, `name`, `value`, `color`, `sortOrder`, `idle`) VALUES
(1, 'Low (10%)', 1, '#32cd32', 10, 0),
(2, 'Medium (50%)', 2, '#ffd700', 20, 0),
(3, 'High (90%)', 4, '#ff0000', 30, 0);

-- --------------------------------------------------------

--
-- Structure de la table `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `ref1Type` varchar(100) DEFAULT NULL,
  `ref1Id` int(12) unsigned NOT NULL,
  `ref2Type` varchar(100) DEFAULT NULL,
  `ref2Id` int(12) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `linkRef1` (`ref1Type`,`ref1Id`),
  KEY `linkRef2` (`ref2Type`,`ref2Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `link`
--


-- --------------------------------------------------------

--
-- Structure de la table `linkable`
--

CREATE TABLE IF NOT EXISTS `linkable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `linkable`
--

INSERT INTO `linkable` (`id`, `name`, `idle`) VALUES
(1, 'Action', 0),
(2, 'Issue', 0),
(3, 'Risk', 0),
(4, 'Meeting', 0),
(5, 'Decision', 0),
(6, 'Question', 0);

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `list` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `listList` (`list`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `list`
--

INSERT INTO `list` (`id`, `list`, `name`, `code`, `sortOrder`, `idle`) VALUES
(1, 'yesNo', 'displayYes', 'YES', 20, 0),
(2, 'yesNo', 'displayNo', 'NO', 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `refType` int(12) unsigned DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `mailDateTime` datetime DEFAULT NULL,
  `mailTo` varchar(4000) DEFAULT NULL,
  `mailTitle` varchar(4000) DEFAULT NULL,
  `mailBody` varchar(4000) DEFAULT NULL,
  `mailStatus` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mailProject` (`idProject`),
  KEY `mailUser` (`idUser`),
  KEY `mailRef` (`refType`,`refId`),
  KEY `mailStatus` (`idStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `mail`
--

INSERT INTO `mail` (`id`, `idUser`, `idProject`, `refType`, `refId`, `idStatus`, `mailDateTime`, `mailTo`, `mailTitle`, `mailBody`, `mailStatus`, `idle`) VALUES
(1, 1, 1, 1, 1, 1, '2011-09-02 01:45:00', 'project.manager@toolware.fr', '[Project''Or RIA] Ticket #1 moved to status recorded', '<html>\n<head>\n<title>[Project''Or RIA] Ticket #1 moved to status recorded</title>\n</head>\n<body>\nThe status of Ticket #1 [bug: it does not work] has changed to\nrecorded<br/>\n<br/>\n<div style="font-weight: bold;">Ticket #1</div><br/>\n<div style="text-decoration:underline;font-weight: bold;">project\n:</div>\nproject one<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">ticket type\n:</div>\nIncident<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">name\n:</div>\nbug: it does not work<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">description\n:</div>\n<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">issuer\n:</div>\nadmin<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">status\n:</div>\nrecorded<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">responsible\n:</div>\n <br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">result\n:</div>\n<br/><br/>\n\n<body>\n</html>', 'ERROR', 0),
(2, 1, 1, 1, 1, 3, '2011-09-02 01:54:00', 'project.manager@toolware.fr', '[Project''Or RIA] Ticket #1 moved to status in progress', '<html>\n<head>\n<title>[Project''Or RIA] Ticket #1 moved to status in progress</title>\n</head>\n<body>\nThe status of Ticket #1 [bug: it does not work] has changed to in\nprogress<br/>\n<br/>\n<div style="font-weight: bold;">Ticket #1</div><br/>\n<div style="text-decoration:underline;font-weight: bold;">project\n:</div>\nproject one<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">ticket type\n:</div>\nIncident<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">name\n:</div>\nbug: it does not work<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">description\n:</div>\n<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">issuer\n:</div>\nadmin<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">status\n:</div>\nin progress<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">responsible\n:</div>\nproject manager<br/><br/>\n<div style="text-decoration:underline;font-weight: bold;">result\n:</div>\n<br/><br/>\n\n<body>\n</html>', 'ERROR', 0);

-- --------------------------------------------------------

--
-- Structure de la table `mailable`
--

CREATE TABLE IF NOT EXISTS `mailable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `mailable`
--

INSERT INTO `mailable` (`id`, `name`, `idle`) VALUES
(1, 'Ticket', 0),
(2, 'Activity', 0),
(3, 'Milestone', 0),
(4, 'Risk', 0),
(5, 'Action', 0),
(6, 'Issue', 0),
(7, 'Meeting', 0),
(8, 'Decision', 0),
(9, 'Question', 0);

-- --------------------------------------------------------

--
-- Structure de la table `meeting`
--

CREATE TABLE IF NOT EXISTS `meeting` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idMeetingType` int(12) unsigned DEFAULT NULL,
  `meetingDate` date DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `attendees` varchar(4000) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `sendTo` varchar(4000) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetingProject` (`idProject`),
  KEY `meetingType` (`idMeetingType`),
  KEY `meetingUser` (`idUser`),
  KEY `meetingResource` (`idResource`),
  KEY `meetingStatus` (`idStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `meeting`
--


-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idMenu` int(12) unsigned DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `menuMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(1, 'menuToday', 0, 'item', 100, NULL, 0),
(2, 'menuWork', 0, 'menu', 110, 'Project', 1),
(3, 'menuRisk', 43, 'object', 310, 'Project', 0),
(4, 'menuAction', 43, 'object', 320, 'Project', 0),
(5, 'menuIssue', 43, 'object', 330, 'Project', 0),
(6, 'menuReview', 0, 'menu', 350, NULL, 0),
(7, 'menuFollowup', 0, 'menu', 200, NULL, 1),
(8, 'menuImputation', 7, 'item', 210, NULL, 0),
(9, 'menuPlanning', 7, 'item', 220, NULL, 0),
(10, 'menuComponent', 0, 'class', 400, NULL, 1),
(11, 'menuTool', 0, 'menu', 500, NULL, 1),
(12, 'menuRequestor', 11, 'item', 501, NULL, 1),
(13, 'menuParameter', 0, 'menu', 600, NULL, 1),
(14, 'menuEnvironmentalParameter', 13, 'menu', 610, NULL, 1),
(15, 'menuClient', 14, 'object', 620, NULL, 0),
(16, 'menuProject', 14, 'object', 640, 'Project', 0),
(17, 'menuUser', 14, 'object', 650, NULL, 0),
(18, 'menuGlobalParameter', 13, 'item', 980, NULL, 0),
(19, 'menuProjectParameter', 13, 'item', 985, NULL, 1),
(20, 'menuUserParameter', 13, 'item', 990, '', 0),
(21, 'menuHabilitation', 37, 'item', 966, NULL, 0),
(22, 'menuTicket', 2, 'object', 120, 'Project', 0),
(25, 'menuActivity', 2, 'object', 135, 'Project', 0),
(26, 'menuMilestone', 2, 'object', 145, 'Project', 0),
(34, 'menuStatus', 36, 'object', 710, NULL, 0),
(36, 'menuListOfValues', 13, 'menu', 690, NULL, 1),
(37, 'menuHabilitationParameter', 13, 'menu', 960, NULL, 1),
(38, 'menuSeverity', 36, 'object', 740, NULL, 0),
(39, 'menuLikelihood', 36, 'object', 720, NULL, 0),
(40, 'menuCriticality', 36, 'object', 730, NULL, 0),
(41, 'menuPriority', 36, 'object', 760, NULL, 0),
(42, 'menuUrgency', 36, 'object', 750, NULL, 0),
(43, 'menuRiskManagementPlan', 0, 'menu', 300, '', 1),
(44, 'menuResource', 14, 'object', 670, NULL, 0),
(45, 'menuRiskType', 79, 'object', 880, NULL, 0),
(46, 'menuIssueType', 79, 'object', 900, NULL, 0),
(47, 'menuAccessProfile', 37, 'object', 964, NULL, 0),
(48, 'menuAccessRight', 37, 'item', 968, NULL, 0),
(49, 'menuProfile', 37, 'object', 962, NULL, 0),
(50, 'menuAffectation', 14, 'object', 680, 'Project', 0),
(51, 'menuMessage', 11, 'object', 510, 'Project', 0),
(52, 'menuMessageType', 79, 'object', 940, NULL, 0),
(53, 'menuTicketType', 79, 'object', 810, NULL, 0),
(55, 'menuActivityType', 79, 'object', 820, NULL, 0),
(56, 'menuMilestoneType', 79, 'object', 830, NULL, 0),
(57, 'menuTeam', 14, 'object', 660, NULL, 0),
(58, 'menuImportData', 11, 'item', 520, NULL, 0),
(59, 'menuWorkflow', 88, 'object', 770, NULL, 0),
(60, 'menuActionType', 79, 'object', 890, NULL, 0),
(61, 'menuReports', 7, 'item', 230, NULL, 0),
(62, 'menuMeeting', 6, 'object', 360, 'Project', 0),
(63, 'menuDecision', 6, 'object', 370, 'Project', 0),
(64, 'menuQuestion', 6, 'object', 380, 'Project', 0),
(65, 'menuMeetingType', 79, 'object', 910, NULL, 0),
(66, 'menuDecisionType', 79, 'object', 920, NULL, 0),
(67, 'menuQuestionType', 79, 'object', 930, NULL, 0),
(68, 'menuStatusMail', 88, 'object', 780, NULL, 0),
(69, 'menuMail', 11, 'object', 503, 'Project', 0),
(70, 'menuHabilitationReport', 37, 'item', 967, NULL, 0),
(71, 'menuHabilitationOther', 37, 'item', 970, NULL, 0),
(72, 'menuContact', 14, 'object', 630, NULL, 0),
(73, 'menuRole', 36, 'object', 700, NULL, 0),
(74, 'menuFinancial', 0, 'menu', 250, NULL, 1),
(75, 'menuIndividualExpense', 74, 'object', 255, 'project', 0),
(76, 'menuProjectExpense', 74, 'object', 260, 'project', 0),
(77, 'menuInvoice', 74, 'object', 265, 'project', 1),
(78, 'menuPayment', 74, 'object', 270, 'project', 1),
(79, 'menuType', 13, 'menu', 800, NULL, 0),
(80, 'menuIndividualExpenseType', 79, 'object', 840, NULL, 0),
(81, 'menuProjectExpenseType', 79, 'object', 850, NULL, 0),
(82, 'menuInvoiceType', 79, 'object', 860, NULL, 1),
(83, 'menuPaymentType', 79, 'object', 870, NULL, 1),
(84, 'menuExpenseDetailType', 79, 'object', 855, NULL, 0),
(85, 'menuCalendar', 14, 'object', 685, NULL, 0),
(86, 'menuProduct', 14, 'object', 642, NULL, 0),
(87, 'menuVersion', 14, 'object', 644, NULL, 0),
(88, 'menuAutomation', 13, 'menu', 765, NULL, 0),
(89, 'menuTicketDelay', 88, 'object', 785, NULL, 0),
(90, 'menuIndicatorDefinition', 88, 'object', 790, NULL, 0),
(91, 'menuAlert', 11, 'object', 505, 'Project', 0),
(92, 'menuAdmin', 13, 'item', 975, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idMessageType` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idProfile` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `messageProject` (`idProject`),
  KEY `messageUser` (`idUser`),
  KEY `messageType` (`idMessageType`),
  KEY `messageProfile` (`idProfile`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `idProject`, `name`, `idMessageType`, `description`, `idProfile`, `idUser`, `idle`) VALUES
(1, NULL, 'Welcome', 15, 'Welcome to ProjectOr web application', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `milestone`
--

CREATE TABLE IF NOT EXISTS `milestone` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idMilestoneType` int(12) unsigned DEFAULT NULL,
  `idActivity` int(12) unsigned DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milestoneProject` (`idProject`),
  KEY `milestoneUser` (`idUser`),
  KEY `milestoneResource` (`idResource`),
  KEY `milestoneStatus` (`idStatus`),
  KEY `milestoneType` (`idMilestoneType`),
  KEY `milestoneActivity` (`idActivity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `milestone`
--

INSERT INTO `milestone` (`id`, `idProject`, `name`, `description`, `creationDate`, `idUser`, `idStatus`, `idResource`, `result`, `comment`, `idle`, `idMilestoneType`, `idActivity`, `done`, `idleDate`, `doneDate`, `handled`, `handledDate`, `idVersion`) VALUES
(1, 3, 'Delivery of Evolution X', NULL, '2011-09-02', 1, 1, NULL, NULL, NULL, 0, 25, 2, 0, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  `note` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `noteUser` (`idUser`),
  KEY `noteRef` (`refType`,`refId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `note`
--


-- --------------------------------------------------------

--
-- Structure de la table `origin`
--

CREATE TABLE IF NOT EXISTS `origin` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `originType` varchar(100) DEFAULT NULL,
  `originId` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `originOrigin` (`originType`,`originId`),
  KEY `originRef` (`refType`,`refId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `origin`
--


-- --------------------------------------------------------

--
-- Structure de la table `originable`
--

CREATE TABLE IF NOT EXISTS `originable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `originable`
--

INSERT INTO `originable` (`id`, `name`, `idle`) VALUES
(1, 'Ticket', 0),
(2, 'Activity', 0),
(3, 'Milestone', 0),
(4, 'IndividualExpense', 0),
(5, 'ProjectExpense', 0),
(6, 'Risk', 0),
(7, 'Action', 0),
(8, 'Issue', 0),
(9, 'Meeting', 0),
(10, 'Decision', 0),
(11, 'Question', 0);

-- --------------------------------------------------------

--
-- Structure de la table `parameter`
--

CREATE TABLE IF NOT EXISTS `parameter` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `parameterCode` varchar(100) DEFAULT NULL,
  `parameterValue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parameterProject` (`idProject`),
  KEY `parameterUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `parameter`
--

INSERT INTO `parameter` (`id`, `idUser`, `idProject`, `parameterCode`, `parameterValue`) VALUES
(1, NULL, NULL, 'dbVersion', 'V1.8.0'),
(2, 1, NULL, 'destinationWidth', '847'),
(3, 1, NULL, 'theme', 'ProjectOrRia'),
(4, 1, NULL, 'lang', 'en'),
(5, 1, NULL, 'defaultProject', '*'),
(6, 1, NULL, 'displayAttachement', 'YES_OPENED'),
(7, 1, NULL, 'displayNote', 'YES_OPENED'),
(8, 1, NULL, 'displayHistory', 'YES_CLOSED'),
(9, 1, NULL, 'refreshUpdates', 'YES'),
(10, 3, NULL, 'destinationWidth', '719'),
(11, 3, NULL, 'theme', 'blue'),
(12, 3, NULL, 'lang', 'en'),
(13, 3, NULL, 'defaultProject', '3'),
(14, 3, NULL, 'displayAttachement', 'YES_CLOSED'),
(15, 3, NULL, 'displayNote', 'YES_CLOSED'),
(16, 3, NULL, 'displayHistory', 'YES_CLOSED'),
(17, 3, NULL, 'refreshUpdates', 'YES'),
(18, 1, NULL, 'hideMenu', 'NO'),
(19, 1, NULL, 'switchedMode', 'NO'),
(20, 1, NULL, 'printInNewWindow', 'NO'),
(21, 1, NULL, 'pdfInNewWindow', 'NO'),
(22, NULL, NULL, 'startAM', '08:00'),
(23, NULL, NULL, 'endAM', '12:00'),
(24, NULL, NULL, 'startPM', '14:00'),
(25, NULL, NULL, 'endPM', '18:00'),
(26, NULL, NULL, 'dayTime', '8.00'),
(27, NULL, NULL, 'alertCheckTime', '60'),
(28, NULL, NULL, 'cronSleepTime', '10'),
(29, NULL, NULL, 'cronCheckDates', '30'),
(30, NULL, NULL, 'ldapDefaultProfile', '5'),
(31, NULL, NULL, 'ldapMsgOnUserCreation', 'NO');

-- --------------------------------------------------------

--
-- Structure de la table `plannedwork`
--

CREATE TABLE IF NOT EXISTS `plannedwork` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idAssignment` int(12) unsigned DEFAULT NULL,
  `work` decimal(8,5) unsigned DEFAULT NULL,
  `workDate` date DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `dailyCost` decimal(7,2) DEFAULT NULL,
  `cost` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workDay` (`day`),
  KEY `plannedworkWeek` (`week`),
  KEY `plannedworkMonth` (`month`),
  KEY `plannedworkYear` (`year`),
  KEY `plannedworkRef` (`refType`,`refId`),
  KEY `plannedworkResource` (`idResource`),
  KEY `plannedworkAssignment` (`idAssignment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1335 ;

--
-- Contenu de la table `plannedwork`
--

INSERT INTO `plannedwork` (`id`, `idResource`, `idProject`, `refType`, `refId`, `idAssignment`, `work`, `workDate`, `day`, `week`, `month`, `year`, `dailyCost`, `cost`) VALUES
(1228, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-10', '20111010', '201141', '201110', '2011', NULL, NULL),
(1229, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-11', '20111011', '201141', '201110', '2011', NULL, NULL),
(1230, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-12', '20111012', '201141', '201110', '2011', NULL, NULL),
(1231, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-13', '20111013', '201141', '201110', '2011', NULL, NULL),
(1232, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-14', '20111014', '201141', '201110', '2011', NULL, NULL),
(1233, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-17', '20111017', '201142', '201110', '2011', NULL, NULL),
(1234, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-18', '20111018', '201142', '201110', '2011', NULL, NULL),
(1235, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-19', '20111019', '201142', '201110', '2011', NULL, NULL),
(1236, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-20', '20111020', '201142', '201110', '2011', NULL, NULL),
(1237, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-21', '20111021', '201142', '201110', '2011', NULL, NULL),
(1238, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-24', '20111024', '201143', '201110', '2011', NULL, NULL),
(1239, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-25', '20111025', '201143', '201110', '2011', NULL, NULL),
(1240, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-26', '20111026', '201143', '201110', '2011', NULL, NULL),
(1241, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-27', '20111027', '201143', '201110', '2011', NULL, NULL),
(1242, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-28', '20111028', '201143', '201110', '2011', NULL, NULL),
(1243, 3, 2, 'Activity', 1, 1, 0.50000, '2011-10-31', '20111031', '201144', '201110', '2011', NULL, NULL),
(1244, 3, 2, 'Activity', 1, 1, 0.50000, '2011-11-01', '20111101', '201144', '201111', '2011', NULL, NULL),
(1245, 3, 2, 'Activity', 1, 1, 0.50000, '2011-11-02', '20111102', '201144', '201111', '2011', NULL, NULL),
(1246, 3, 2, 'Activity', 1, 1, 0.50000, '2011-11-03', '20111103', '201144', '201111', '2011', NULL, NULL),
(1247, 3, 2, 'Activity', 1, 1, 0.50000, '2011-11-04', '20111104', '201144', '201111', '2011', NULL, NULL),
(1248, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-10', '20111010', '201141', '201110', '2011', NULL, NULL),
(1249, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-11', '20111011', '201141', '201110', '2011', NULL, NULL),
(1250, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-12', '20111012', '201141', '201110', '2011', NULL, NULL),
(1251, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-13', '20111013', '201141', '201110', '2011', NULL, NULL),
(1252, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-14', '20111014', '201141', '201110', '2011', NULL, NULL),
(1253, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-17', '20111017', '201142', '201110', '2011', NULL, NULL),
(1254, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-18', '20111018', '201142', '201110', '2011', NULL, NULL),
(1255, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-19', '20111019', '201142', '201110', '2011', NULL, NULL),
(1256, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-20', '20111020', '201142', '201110', '2011', NULL, NULL),
(1257, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-21', '20111021', '201142', '201110', '2011', NULL, NULL),
(1258, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-24', '20111024', '201143', '201110', '2011', NULL, NULL),
(1259, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-25', '20111025', '201143', '201110', '2011', NULL, NULL),
(1260, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-26', '20111026', '201143', '201110', '2011', NULL, NULL),
(1261, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-27', '20111027', '201143', '201110', '2011', NULL, NULL),
(1262, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-28', '20111028', '201143', '201110', '2011', NULL, NULL),
(1263, 10, 2, 'Activity', 1, 2, 0.50000, '2011-10-31', '20111031', '201144', '201110', '2011', NULL, NULL),
(1264, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-01', '20111101', '201144', '201111', '2011', NULL, NULL),
(1265, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-02', '20111102', '201144', '201111', '2011', NULL, NULL),
(1266, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-03', '20111103', '201144', '201111', '2011', NULL, NULL),
(1267, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-04', '20111104', '201144', '201111', '2011', NULL, NULL),
(1268, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-07', '20111107', '201145', '201111', '2011', NULL, NULL),
(1269, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-08', '20111108', '201145', '201111', '2011', NULL, NULL),
(1270, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-09', '20111109', '201145', '201111', '2011', NULL, NULL),
(1271, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-10', '20111110', '201145', '201111', '2011', NULL, NULL),
(1272, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-11', '20111111', '201145', '201111', '2011', NULL, NULL),
(1273, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-14', '20111114', '201146', '201111', '2011', NULL, NULL),
(1274, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-15', '20111115', '201146', '201111', '2011', NULL, NULL),
(1275, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-16', '20111116', '201146', '201111', '2011', NULL, NULL),
(1276, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-17', '20111117', '201146', '201111', '2011', NULL, NULL),
(1277, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-18', '20111118', '201146', '201111', '2011', NULL, NULL),
(1278, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-21', '20111121', '201147', '201111', '2011', NULL, NULL),
(1279, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-22', '20111122', '201147', '201111', '2011', NULL, NULL),
(1280, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-23', '20111123', '201147', '201111', '2011', NULL, NULL),
(1281, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-24', '20111124', '201147', '201111', '2011', NULL, NULL),
(1282, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-25', '20111125', '201147', '201111', '2011', NULL, NULL),
(1283, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-28', '20111128', '201148', '201111', '2011', NULL, NULL),
(1284, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-29', '20111129', '201148', '201111', '2011', NULL, NULL),
(1285, 10, 2, 'Activity', 1, 2, 0.50000, '2011-11-30', '20111130', '201148', '201111', '2011', NULL, NULL),
(1286, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-01', '20111201', '201148', '201112', '2011', NULL, NULL),
(1287, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-02', '20111202', '201148', '201112', '2011', NULL, NULL),
(1288, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-05', '20111205', '201149', '201112', '2011', NULL, NULL),
(1289, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-06', '20111206', '201149', '201112', '2011', NULL, NULL),
(1290, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-07', '20111207', '201149', '201112', '2011', NULL, NULL),
(1291, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-08', '20111208', '201149', '201112', '2011', NULL, NULL),
(1292, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-09', '20111209', '201149', '201112', '2011', NULL, NULL),
(1293, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-12', '20111212', '201150', '201112', '2011', NULL, NULL),
(1294, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-13', '20111213', '201150', '201112', '2011', NULL, NULL),
(1295, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-14', '20111214', '201150', '201112', '2011', NULL, NULL),
(1296, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-15', '20111215', '201150', '201112', '2011', NULL, NULL),
(1297, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-16', '20111216', '201150', '201112', '2011', NULL, NULL),
(1298, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-19', '20111219', '201151', '201112', '2011', NULL, NULL),
(1299, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-20', '20111220', '201151', '201112', '2011', NULL, NULL),
(1300, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-21', '20111221', '201151', '201112', '2011', NULL, NULL),
(1301, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-22', '20111222', '201151', '201112', '2011', NULL, NULL),
(1302, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-23', '20111223', '201151', '201112', '2011', NULL, NULL),
(1303, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-26', '20111226', '201152', '201112', '2011', NULL, NULL),
(1304, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-27', '20111227', '201152', '201112', '2011', NULL, NULL),
(1305, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-28', '20111228', '201152', '201112', '2011', NULL, NULL),
(1306, 10, 2, 'Activity', 1, 2, 0.50000, '2011-12-29', '20111229', '201152', '201112', '2011', NULL, NULL),
(1307, 10, 2, 'Activity', 1, 2, 2.50000, '2011-12-30', '20111230', '201152', '201112', '2011', NULL, NULL),
(1308, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-02', '20120102', '201201', '201201', '2012', NULL, NULL),
(1309, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-03', '20120103', '201201', '201201', '2012', NULL, NULL),
(1310, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-04', '20120104', '201201', '201201', '2012', NULL, NULL),
(1311, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-05', '20120105', '201201', '201201', '2012', NULL, NULL),
(1312, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-06', '20120106', '201201', '201201', '2012', NULL, NULL),
(1313, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-09', '20120109', '201202', '201201', '2012', NULL, NULL),
(1314, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-10', '20120110', '201202', '201201', '2012', NULL, NULL),
(1315, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-11', '20120111', '201202', '201201', '2012', NULL, NULL),
(1316, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-12', '20120112', '201202', '201201', '2012', NULL, NULL),
(1317, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-13', '20120113', '201202', '201201', '2012', NULL, NULL),
(1318, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-16', '20120116', '201203', '201201', '2012', NULL, NULL),
(1319, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-17', '20120117', '201203', '201201', '2012', NULL, NULL),
(1320, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-18', '20120118', '201203', '201201', '2012', NULL, NULL),
(1321, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-19', '20120119', '201203', '201201', '2012', NULL, NULL),
(1322, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-20', '20120120', '201203', '201201', '2012', NULL, NULL),
(1323, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-23', '20120123', '201204', '201201', '2012', NULL, NULL),
(1324, 10, 2, 'Activity', 1, 2, 2.50000, '2012-01-24', '20120124', '201204', '201201', '2012', NULL, NULL),
(1325, 10, 2, 'Activity', 1, 2, 0.50000, '2012-01-25', '20120125', '201204', '201201', '2012', NULL, NULL),
(1326, 8, 3, 'Activity', 3, 3, 1.00000, '2011-10-10', '20111010', '201141', '201110', '2011', NULL, NULL),
(1327, 8, 3, 'Activity', 3, 3, 1.00000, '2011-10-11', '20111011', '201141', '201110', '2011', NULL, NULL),
(1328, 8, 3, 'Activity', 3, 3, 0.50000, '2011-10-12', '20111012', '201141', '201110', '2011', NULL, NULL),
(1329, 10, 3, 'Activity', 4, 4, 4.50000, '2011-10-13', '20111013', '201141', '201110', '2011', NULL, NULL),
(1330, 10, 3, 'Activity', 4, 4, 4.50000, '2011-10-14', '20111014', '201141', '201110', '2011', NULL, NULL),
(1331, 10, 3, 'Activity', 4, 4, 1.00000, '2011-10-17', '20111017', '201142', '201110', '2011', NULL, NULL),
(1332, 8, 3, 'Activity', 5, 5, 1.00000, '2011-10-18', '20111018', '201142', '201110', '2011', NULL, NULL),
(1333, 8, 3, 'Activity', 5, 5, 1.00000, '2011-10-19', '20111019', '201142', '201110', '2011', NULL, NULL),
(1334, 8, 3, 'Activity', 5, 5, 1.00000, '2011-10-20', '20111020', '201142', '201110', '2011', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `planningelement`
--

CREATE TABLE IF NOT EXISTS `planningelement` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `refName` varchar(100) DEFAULT NULL,
  `initialStartDate` date DEFAULT NULL,
  `validatedStartDate` date DEFAULT NULL,
  `plannedStartDate` date DEFAULT NULL,
  `realStartDate` date DEFAULT NULL,
  `initialEndDate` date DEFAULT NULL,
  `validatedEndDate` date DEFAULT NULL,
  `plannedEndDate` date DEFAULT NULL,
  `realEndDate` date DEFAULT NULL,
  `initialDuration` int(5) DEFAULT NULL,
  `validatedDuration` int(5) unsigned DEFAULT NULL,
  `plannedDuration` int(5) DEFAULT NULL,
  `realDuration` int(5) DEFAULT NULL,
  `initialWork` decimal(14,5) unsigned DEFAULT NULL,
  `validatedWork` decimal(14,5) unsigned DEFAULT NULL,
  `plannedWork` decimal(14,5) unsigned DEFAULT NULL,
  `realWork` decimal(14,5) unsigned DEFAULT NULL,
  `wbs` varchar(100) DEFAULT NULL,
  `wbsSortable` varchar(400) DEFAULT NULL,
  `topId` int(12) unsigned DEFAULT NULL,
  `topRefType` varchar(100) DEFAULT NULL,
  `topRefId` int(12) unsigned DEFAULT NULL,
  `priority` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  `elementary` int(1) unsigned DEFAULT NULL,
  `leftWork` decimal(14,5) unsigned DEFAULT NULL,
  `assignedWork` decimal(14,5) unsigned DEFAULT NULL,
  `dependencyLevel` decimal(3,0) unsigned DEFAULT NULL,
  `idPlanningMode` int(12) DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `initialCost` decimal(11,2) DEFAULT NULL,
  `validatedCost` decimal(11,2) DEFAULT NULL,
  `assignedCost` decimal(11,2) DEFAULT NULL,
  `realCost` decimal(11,2) DEFAULT NULL,
  `leftCost` decimal(11,2) DEFAULT NULL,
  `plannedCost` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planningelementTopId` (`topId`),
  KEY `planningelementRef` (`refType`,`refId`),
  KEY `planningelementTopRef` (`topRefType`,`topRefId`),
  KEY `planningelementProject` (`idProject`),
  KEY `planningelementWbsSortable` (`wbsSortable`(255)),
  KEY `planningElementDependencyLevel` (`dependencyLevel`),
  KEY `planningelementPlanningMode` (`idPlanningMode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `planningelement`
--

INSERT INTO `planningelement` (`id`, `idProject`, `refType`, `refId`, `refName`, `initialStartDate`, `validatedStartDate`, `plannedStartDate`, `realStartDate`, `initialEndDate`, `validatedEndDate`, `plannedEndDate`, `realEndDate`, `initialDuration`, `validatedDuration`, `plannedDuration`, `realDuration`, `initialWork`, `validatedWork`, `plannedWork`, `realWork`, `wbs`, `wbsSortable`, `topId`, `topRefType`, `topRefId`, `priority`, `idle`, `elementary`, `leftWork`, `assignedWork`, `dependencyLevel`, `idPlanningMode`, `done`, `initialCost`, `validatedCost`, `assignedCost`, `realCost`, `leftCost`, `plannedCost`) VALUES
(1, 1, 'Project', 1, 'project one', NULL, NULL, '2011-09-05', '2011-09-05', NULL, NULL, '2012-01-25', NULL, NULL, NULL, 103, NULL, NULL, NULL, 103.70000, 5.70000, '1', '001', NULL, NULL, NULL, 500, 0, 0, 98.00000, 103.00000, NULL, NULL, 0, NULL, NULL, 26100.00, 1710.00, 24600.00, 26310.00),
(2, 2, 'Project', 2, 'project one - maintenance', NULL, NULL, '2011-10-10', NULL, NULL, NULL, '2012-01-25', NULL, NULL, NULL, 78, NULL, NULL, NULL, 85.00000, 0.00000, '1.1', '001.001', 1, 'Project', 1, 500, 0, 0, 85.00000, 85.00000, NULL, NULL, 0, NULL, NULL, 21500.00, 0.00, 21500.00, 21500.00),
(3, 3, 'Project', 3, 'project one - developement', NULL, NULL, '2011-09-05', '2011-09-05', NULL, NULL, '2011-10-28', NULL, NULL, NULL, 40, NULL, NULL, NULL, 18.70000, 5.70000, '1.2', '001.002', 1, 'Project', 1, 500, 0, 0, 13.00000, 18.00000, NULL, NULL, 0, NULL, NULL, 4600.00, 1710.00, 3100.00, 4810.00),
(4, 4, 'Project', 4, 'project two', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '002', NULL, NULL, NULL, 500, 0, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(5, 5, 'Project', 5, 'internal project', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00000, 0.00000, '3', '003', NULL, NULL, NULL, 500, 0, 0, 0.00000, 0.00000, NULL, NULL, 0, NULL, NULL, 0.00, 0.00, 0.00, 0.00),
(6, 6, 'Project', 6, 'holidays', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3.1', '003.001', 5, 'Project', 5, 500, 0, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 2, 'Activity', 1, 'bug fixing', NULL, '2011-09-01', '2011-10-10', NULL, NULL, '2011-12-31', '2012-01-25', NULL, NULL, 87, 78, NULL, NULL, NULL, 85.00000, 0.00000, '1.1.1', '001.001.001', 2, 'Project', 2, 500, 0, 1, 85.00000, 85.00000, NULL, 7, 0, NULL, NULL, 21500.00, 0.00, 21500.00, 21500.00),
(8, 3, 'Activity', 2, 'Evolution X', NULL, NULL, '2011-09-05', '2011-09-05', NULL, NULL, '2011-10-21', NULL, NULL, NULL, 35, NULL, NULL, NULL, 18.70000, 5.70000, '1.2.1', '001.002.001', 3, 'Project', 3, 500, 0, 0, 13.00000, 18.00000, NULL, 1, 0, NULL, NULL, 4600.00, 1710.00, 3100.00, 4810.00),
(9, 3, 'Activity', 3, 'Evolutoin X - Analysis', NULL, NULL, '2011-09-05', '2011-09-05', NULL, NULL, '2011-10-12', '2011-10-13', NULL, NULL, 28, 29, NULL, NULL, 5.70000, 5.70000, '1.2.1.1', '001.002.001.001', 8, 'Activity', 2, 500, 0, 1, 0.00000, 5.00000, NULL, 1, 0, NULL, NULL, 1500.00, 1710.00, 0.00, 1710.00),
(10, 3, 'Activity', 4, 'Evolution X - Development', NULL, NULL, '2011-10-13', NULL, NULL, NULL, '2011-10-17', NULL, NULL, NULL, 3, NULL, NULL, NULL, 10.00000, 0.00000, '1.2.1.2', '001.002.001.002', 8, 'Activity', 2, 500, 0, 1, 10.00000, 10.00000, NULL, 1, 0, NULL, NULL, 2200.00, 0.00, 2200.00, 2200.00),
(11, 3, 'Activity', 5, 'Evolution X - Tests', NULL, NULL, '2011-10-18', NULL, NULL, NULL, '2011-10-20', NULL, NULL, NULL, 3, NULL, NULL, NULL, 3.00000, 0.00000, '1.2.1.3', '001.002.001.003', 8, 'Activity', 2, 500, 0, 1, 3.00000, 3.00000, NULL, 1, 0, NULL, NULL, 900.00, 0.00, 900.00, 900.00),
(12, 3, 'Milestone', 1, 'Delivery of Evolution X', NULL, NULL, '2011-10-21', NULL, NULL, NULL, '2011-10-21', NULL, 0, 0, 1, NULL, 0.00000, 0.00000, 0.00000, 0.00000, '1.2.1.4', '001.002.001.004', 8, 'Activity', 2, 500, 0, 1, NULL, NULL, NULL, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 3, 'Activity', 6, 'Evolution Y', NULL, NULL, '2011-10-24', NULL, NULL, NULL, '2011-10-28', NULL, NULL, 5, 5, NULL, NULL, NULL, NULL, NULL, '1.2.2', '001.002.002', 3, 'Project', 3, 500, 0, 1, NULL, NULL, NULL, 8, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `planningmode`
--

CREATE TABLE IF NOT EXISTS `planningmode` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `mandatoryStartDate` int(1) unsigned DEFAULT '0',
  `mandatoryEndDate` int(1) unsigned DEFAULT '0',
  `applyTo` varchar(20) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `mandatoryDuration` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `planningmodeApplyTo` (`applyTo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `planningmode`
--

INSERT INTO `planningmode` (`id`, `name`, `code`, `sortOrder`, `mandatoryStartDate`, `mandatoryEndDate`, `applyTo`, `idle`, `mandatoryDuration`) VALUES
(1, 'PlanningModeASAP', 'ASAP', 100, 0, 0, 'Activity', 0, 0),
(2, 'PlanningModeREGUL', 'REGUL', 200, 1, 1, 'Activity', 0, 0),
(3, 'PlanningModeFULL', 'FULL', 300, 1, 1, 'Activity', 0, 0),
(4, 'PlanningModeALAP', 'ALAP', 400, 0, 1, 'Activity', 0, 0),
(5, 'PlanningModeFLOAT', 'FLOAT', 100, 0, 0, 'Milestone', 0, 0),
(6, 'PlanningModeFIXED', 'FIXED', 200, 0, 1, 'Milestone', 0, 0),
(7, 'PlanningModeHALF', 'HALF', 320, 0, 0, 'Activity', 0, 0),
(8, 'PlanningModeFDUR', 'FDUR', 450, 0, 0, 'Activity', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `priority`
--

CREATE TABLE IF NOT EXISTS `priority` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) unsigned DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `priority`
--

INSERT INTO `priority` (`id`, `name`, `value`, `color`, `sortOrder`, `idle`) VALUES
(1, 'Low priority', 1, '#32cd32', 40, 0),
(2, 'Medium priority', 2, '#ffd700', 30, 0),
(3, 'Hight priority', 4, '#ff0000', 20, 0),
(4, 'Critical priority', 8, '#000000', 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `productClient` (`idClient`),
  KEY `pruductContact` (`idContact`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `idClient`, `idContact`, `description`, `creationDate`, `idle`) VALUES
(1, 'web application', 1, 5, NULL, '2011-09-01', 0),
(2, 'swing application', 2, 6, NULL, '2011-09-01', 0);

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `profileCode` varchar(3) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `profile`
--

INSERT INTO `profile` (`id`, `name`, `description`, `profileCode`, `sortOrder`, `idle`) VALUES
(1, 'profileAdministrator', 'Has a visibility over all the projects', 'ADM', 100, 0),
(2, 'profileSupervisor', 'Has a visibility over all the projects', 'SUP', 200, 0),
(3, 'profileProjectLeader', 'Leads his owns project', 'PL', 310, 0),
(4, 'profileTeamMember', 'Works for a project', 'TM', 320, 0),
(5, 'profileGuest', 'Has limited visibility to a project', 'G', 500, 0),
(6, 'profileExternalProjectLeader', NULL, 'EPL', 410, 0),
(7, 'profileExternalTeamMember', NULL, 'ETM', 420, 0);

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idClient` int(12) DEFAULT NULL,
  `projectCode` varchar(25) DEFAULT NULL,
  `contractCode` varchar(25) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idUser` int(12) unsigned DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `sortOrder` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projectProject` (`idProject`),
  KEY `projectClient` (`idClient`),
  KEY `projectUser` (`idUser`),
  KEY `projectContact` (`idContact`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `idClient`, `projectCode`, `contractCode`, `color`, `idProject`, `idle`, `idUser`, `done`, `idleDate`, `doneDate`, `idContact`, `sortOrder`) VALUES
(1, 'project one', '1st project\nThis project has 2 sub-projects', 1, '001-001', 'X23-472-722', '#6a5acd', NULL, 0, 5, 0, NULL, NULL, NULL, '001'),
(2, 'project one - maintenance', 'This project is dedicated to maintenance of ''''web application'''' V1.0\nIt is sub-project of project one.', 1, '001-001-1', 'X23-472-722', '#6495ed', 1, 0, 5, 0, NULL, NULL, NULL, '001.001'),
(3, 'project one - developement', 'This project is dedicated to developement of ''''web application'''' V2.0\nIt is sub-project of project one.', 1, '001-001-2', 'X23-472-722', '#87ceeb', 1, 0, 5, 0, NULL, NULL, NULL, '001.002'),
(4, 'project two', '1st project\nThis project has 2 sub-projects', 2, '002-002', 'X24-001-007', '#b22222', NULL, 0, 6, 0, NULL, NULL, NULL, '002'),
(5, 'internal project', 'internal project\nout of project work', 3, NULL, NULL, '#008b8b', NULL, 0, 1, 0, NULL, NULL, NULL, '003'),
(6, 'holidays', 'holidays', 3, NULL, NULL, '#20b2aa', 5, 0, NULL, 0, NULL, NULL, NULL, '003.001');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idQuestionType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `sendMail` varchar(100) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `replier` varchar(100) DEFAULT NULL,
  `initialDueDate` date DEFAULT NULL,
  `actualDueDate` date DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionProject` (`idProject`),
  KEY `questionType` (`idQuestionType`),
  KEY `questionUser` (`idUser`),
  KEY `questionResource` (`idResource`),
  KEY `questionStatus` (`idStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `question`
--


-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idReportCategory` int(12) unsigned NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `sortOrder` int(5) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `reportCategory` (`idReportCategory`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `report`
--

INSERT INTO `report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) VALUES
(1, 'reportWorkWeekly', 1, 'work.php', 110, 0),
(2, 'reportWorkMonthly', 1, 'work.php', 120, 0),
(3, 'reportWorkYearly', 1, 'work.php', 130, 0),
(4, 'reportPlanColoredMonthly', 2, 'colorPlan.php', 230, 0),
(5, 'reportPlanResourceMonthly', 2, 'resourcePlan.php', 240, 0),
(6, 'reportPlanProjectMonthly', 2, 'projectPlan.php', 250, 0),
(7, 'reportPlanGantt', 2, '../tool/jsonPlanning.php?print=true', 210, 0),
(8, 'reportWorkPlan', 2, 'workPlan.php', 220, 0),
(9, 'reportTicketYearly', 3, 'ticketYearlyReport.php', 310, 0),
(10, 'reportTicketYearlyByType', 3, 'ticketYearlyReportByType.php', 320, 0),
(11, 'reportTicketWeeklyCrossReport', 3, 'ticketReport.php', 330, 0),
(12, 'reportTicketMonthlyCrossReport', 3, 'ticketReport.php', 340, 0),
(13, 'reportTicketYearlyCrossReport', 3, 'ticketReport.php', 350, 0),
(14, 'reportTicketWeeklySynthesis', 3, 'ticketSynthesis.php', 360, 0),
(15, 'reportTicketMonthlySynthesis', 3, 'ticketSynthesis.php', 370, 0),
(16, 'reportTicketYearlySynthesis', 3, 'ticketSynthesis.php', 380, 0),
(17, 'reportTicketGlobalCrossReport', 3, 'ticketReport.php', 355, 0),
(18, 'reportTicketGlobalSynthesis', 3, 'ticketSynthesis.php', 385, 0),
(19, 'reportGlobalWorkPlanningWeekly', 2, 'globalWorkPlanning.php?scale=week', 260, 0),
(20, 'reportGlobalWorkPlanningMonthly', 2, 'globalWorkPlanning.php?scale=month', 270, 0),
(21, 'reportStatusOngoing', 4, 'status.php', 410, 0),
(22, 'reportStatusAll', 4, 'status.php?showIdle=true', 420, 0),
(23, 'reportRiskManagementPlan', 4, 'riskManagementPlan.php', 430, 0),
(24, 'reportHistoryDeteled', 5, 'history.php?scope=deleted', 520, 0),
(25, 'reportHistoryDetail', 5, 'history.php?scope=item', 520, 0),
(26, 'reportCostDetail', 6, 'costPlan.php', 10, 0),
(27, 'reportCostMonthly', 6, 'globalCostPlanning.php?scale=month', 20, 0),
(28, 'reportWorkDetailWeekly', 1, 'workDetail.php?scale=week', 240, 0),
(29, 'reportWorkDetailMonthly', 1, 'workDetail.php?scale=month', 250, 0),
(30, 'reportWorkDetailYearly', 1, 'workDetail.php?scale=year', 260, 0),
(31, 'reportPlanDetail', 2, 'detailPlan.php', 455, 0),
(32, 'reportAvailabilityPlan', 2, 'availabilityPlan.php', 480, 0),
(33, 'reportExpenseProject', 6, 'expensePlan.php?scale=month&scope=Project', 660, 0),
(34, 'reportExpenseResource', 6, 'expensePlan.php?scale=month&scope=Individual', 670, 0),
(35, 'reportExpenseTotal', 6, 'expensePlan.php?scale=month', 680, 0),
(36, 'reportExpenseCostTotal', 6, 'expenseCostTotalPlan.php?scale=month', 690, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reportcategory`
--

CREATE TABLE IF NOT EXISTS `reportcategory` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `order` int(5) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `reportcategory`
--

INSERT INTO `reportcategory` (`id`, `name`, `order`, `idle`) VALUES
(1, 'reportCategoryWork', 10, 0),
(2, 'reportCategoryPlan', 20, 0),
(3, 'reportCategoryTicket', 30, 0),
(4, 'reportCategoryStatus', 40, 0),
(5, 'reportCategoryHistory', 90, 0),
(6, 'reportCategoryCost', 50, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reportparameter`
--

CREATE TABLE IF NOT EXISTS `reportparameter` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idReport` int(12) unsigned NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `paramType` varchar(100) DEFAULT NULL,
  `order` int(5) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `defaultValue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reportparameterReport` (`idReport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

--
-- Contenu de la table `reportparameter`
--

INSERT INTO `reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `idle`, `defaultValue`) VALUES
(1, 1, 'week', 'week', 10, 0, 'currentWeek'),
(2, 2, 'month', 'month', 10, 0, 'currentMonth'),
(3, 3, 'year', 'year', 10, 0, 'currentYear'),
(4, 4, 'month', 'month', 10, 0, 'currentMonth'),
(5, 5, 'month', 'month', 10, 0, 'currentMonth'),
(6, 6, 'month', 'month', 10, 0, 'currentMonth'),
(7, 7, 'startDate', 'date', 20, 0, 'today'),
(8, 7, 'endDate', 'date', 40, 0, NULL),
(9, 7, 'format', 'periodScale', 40, 0, 'day'),
(10, 7, 'idProject', 'projectList', 10, 0, 'currentProject'),
(11, 8, 'idProject', 'projectList', 10, 0, 'currentProject'),
(12, 9, 'idProject', 'projectList', 10, 0, 'currentProject'),
(13, 9, 'year', 'year', 20, 0, 'currentYear'),
(14, 9, 'idTicketType', 'ticketType', 30, 0, NULL),
(15, 9, 'issuer', 'userList', 40, 0, NULL),
(16, 9, 'responsible', 'resourceList', 50, 0, NULL),
(17, 10, 'idProject', 'projectList', 10, 0, 'currentProject'),
(18, 10, 'year', 'year', 20, 0, 'currentYear'),
(19, 10, 'issuer', 'userList', 40, 0, NULL),
(20, 10, 'responsible', 'resourceList', 50, 0, NULL),
(21, 11, 'idProject', 'projectList', 10, 0, 'currentProject'),
(22, 11, 'week', 'week', 20, 0, 'currentWeek'),
(23, 11, 'issuer', 'userList', 30, 0, NULL),
(24, 11, 'responsible', 'resourceList', 40, 0, NULL),
(25, 12, 'idProject', 'projectList', 10, 0, 'currentProject'),
(26, 12, 'month', 'month', 20, 0, 'currentMonth'),
(27, 12, 'issuer', 'userList', 30, 0, NULL),
(28, 12, 'responsible', 'resourceList', 40, 0, NULL),
(29, 13, 'idProject', 'projectList', 10, 0, 'currentProject'),
(30, 13, 'year', 'year', 20, 0, 'currentYear'),
(31, 13, 'issuer', 'userList', 30, 0, NULL),
(32, 13, 'responsible', 'resourceList', 40, 0, NULL),
(33, 14, 'idProject', 'projectList', 10, 0, 'currentProject'),
(34, 14, 'week', 'week', 20, 0, 'currentWeek'),
(35, 14, 'issuer', 'userList', 30, 0, NULL),
(36, 14, 'responsible', 'resourceList', 40, 0, NULL),
(37, 15, 'idProject', 'projectList', 10, 0, 'currentProject'),
(38, 15, 'month', 'month', 20, 0, 'currentMonth'),
(39, 15, 'issuer', 'userList', 30, 0, NULL),
(40, 15, 'responsible', 'resourceList', 40, 0, NULL),
(41, 16, 'idProject', 'projectList', 10, 0, 'currentProject'),
(42, 16, 'year', 'year', 20, 0, 'currentYear'),
(43, 16, 'issuer', 'userList', 30, 0, NULL),
(44, 16, 'responsible', 'resourceList', 40, 0, NULL),
(45, 17, 'idProject', 'projectList', 10, 0, 'currentProject'),
(46, 17, 'issuer', 'userList', 20, 0, NULL),
(47, 17, 'responsible', 'resourceList', 30, 0, NULL),
(48, 18, 'idProject', 'projectList', 10, 0, 'currentProject'),
(49, 18, 'issuer', 'userList', 20, 0, NULL),
(50, 18, 'responsible', 'resourceList', 30, 0, NULL),
(51, 19, 'idProject', 'projectList', 10, 0, 'currentProject'),
(52, 20, 'idProject', 'projectList', 10, 0, 'currentProject'),
(53, 21, 'idProject', 'projectList', 10, 0, 'currentProject'),
(54, 21, 'issuer', 'userList', 20, 0, NULL),
(55, 21, 'responsible', 'resourceList', 30, 0, NULL),
(56, 22, 'idProject', 'projectList', 10, 0, 'currentProject'),
(57, 22, 'issuer', 'userList', 20, 0, NULL),
(58, 22, 'responsible', 'resourceList', 30, 0, NULL),
(59, 23, 'idProject', 'projectList', 10, 0, 'currentProject'),
(61, 25, 'refType', 'objectList', 10, 0, NULL),
(62, 25, 'refId', 'id', 20, 0, NULL),
(63, 26, 'idProject', 'projectList', 10, 0, 'currentProject'),
(64, 27, 'idProject', 'projectList', 10, 0, 'currentProject'),
(65, 28, 'week', 'week', 10, 0, 'currentWeek'),
(66, 29, 'month', 'month', 10, 0, 'currentMonth'),
(67, 30, 'year', 'year', 10, 0, 'currentYear'),
(68, 31, 'idProject', 'projectList', 10, 0, 'currentProject'),
(69, 31, 'month', 'month', 20, 0, 'currentMonth'),
(70, 32, 'month', 'month', 10, 0, 'currentMonth'),
(71, 33, 'idProject', 'projectList', 10, 0, 'currentProject'),
(72, 34, 'idProject', 'projectList', 10, 0, 'currentProject'),
(73, 35, 'idProject', 'projectList', 10, 0, 'currentProject'),
(74, 36, 'idProject', 'projectList', 10, 0, 'currentProject'),
(75, 34, 'idResource', 'resourceList', 20, 0, NULL),
(76, 9, 'requestor', 'requestorList', 35, 0, NULL),
(77, 10, 'requestor', 'requestorList', 35, 0, NULL),
(78, 11, 'requestor', 'requestorList', 25, 0, NULL),
(79, 12, 'requestor', 'requestorList', 25, 0, NULL),
(80, 13, 'requestor', 'requestorList', 25, 0, NULL),
(81, 14, 'requestor', 'requestorList', 25, 0, NULL),
(82, 15, 'requestor', 'requestorList', 25, 0, NULL),
(83, 16, 'requestor', 'requestorList', 25, 0, NULL),
(84, 17, 'requestor', 'requestorList', 15, 0, NULL),
(85, 18, 'requestor', 'requestorList', 15, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `resourcecost`
--

CREATE TABLE IF NOT EXISTS `resourcecost` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idRole` int(12) unsigned DEFAULT NULL,
  `cost` decimal(11,2) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `resourcecostResource` (`idResource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `resourcecost`
--

INSERT INTO `resourcecost` (`id`, `idResource`, `idRole`, `cost`, `startDate`, `endDate`, `idle`) VALUES
(1, 3, 1, 500.00, NULL, NULL, 0),
(2, 4, 2, 300.00, NULL, NULL, 0),
(3, 8, 2, 300.00, NULL, NULL, 0),
(4, 9, 2, 300.00, NULL, NULL, 0),
(5, 10, 3, 220.00, NULL, NULL, 0),
(6, 11, 3, 230.00, NULL, NULL, 0),
(7, 12, 3, 250.00, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `risk`
--

CREATE TABLE IF NOT EXISTS `risk` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idRiskType` int(12) unsigned DEFAULT NULL,
  `cause` varchar(4000) DEFAULT NULL,
  `impact` varchar(4000) DEFAULT NULL,
  `idSeverity` int(12) unsigned DEFAULT NULL,
  `idLikelihood` int(12) unsigned DEFAULT NULL,
  `idCriticality` int(12) unsigned DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `initialEndDate` date DEFAULT NULL,
  `actualEndDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `riskProject` (`idProject`),
  KEY `riskUser` (`idUser`),
  KEY `riskResource` (`idResource`),
  KEY `riskStatus` (`idStatus`),
  KEY `riskType` (`idRiskType`),
  KEY `riskSeverity` (`idSeverity`),
  KEY `riskLikelihood` (`idLikelihood`),
  KEY `riskCriticality` (`idCriticality`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `risk`
--


-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `sortOrder`, `idle`) VALUES
(1, 'Manager', 'Leader/Manager of the project', 10, 0),
(2, 'Analyst', 'Responsible of specifications', 20, 0),
(3, 'Developer', 'Sowftware developer', 30, 0),
(4, 'Expert', 'Technical expert', 40, 0),
(5, 'Machine', 'Non human resource', 50, 0);

-- --------------------------------------------------------

--
-- Structure de la table `severity`
--

CREATE TABLE IF NOT EXISTS `severity` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) unsigned DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `severity`
--

INSERT INTO `severity` (`id`, `name`, `value`, `color`, `sortOrder`, `idle`) VALUES
(1, 'Low', 1, '#32cd32', 10, 0),
(2, 'Medium', 2, '#ffd700', 20, 0),
(3, 'High', 4, '#ff0000', 30, 0);

-- --------------------------------------------------------

--
-- Structure de la table `sla`
--

CREATE TABLE IF NOT EXISTS `sla` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idTicketType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `durationSla` double DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `sla`
--


-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `setDoneStatus` int(1) unsigned DEFAULT '0',
  `setIdleStatus` int(1) unsigned DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `setHandledStatus` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`id`, `name`, `setDoneStatus`, `setIdleStatus`, `color`, `sortOrder`, `idle`, `setHandledStatus`) VALUES
(1, 'recorded', 0, 0, '#ffa500', 100, 0, 0),
(2, 'qualified', 0, 0, '#87ceeb', 200, 0, 0),
(3, 'in progress', 0, 0, '#d2691e', 300, 0, 1),
(4, 'done', 1, 0, '#afeeee', 400, 0, 1),
(5, 'verified', 1, 0, '#32cd32', 500, 0, 1),
(6, 'delivered', 1, 0, '#4169e1', 600, 0, 1),
(7, 'closed', 1, 1, '#c0c0c0', 700, 0, 1),
(8, 're-opened', 0, 0, '#ff0000', 250, 0, 0),
(9, 'cancelled', 1, 1, '#c0c0c0', 999, 0, 1),
(10, 'assigned', 0, 0, '#8b4513', 275, 0, 1),
(11, 'accepted', 0, 0, '#a52a2a', 220, 0, 0),
(12, 'validated', 1, 0, '#98fb98', 650, 0, 1),
(13, 'prepared', 0, 0, '#d2691e', 290, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `statusmail`
--

CREATE TABLE IF NOT EXISTS `statusmail` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idMailable` int(12) unsigned DEFAULT NULL,
  `mailToUser` int(1) unsigned DEFAULT '0',
  `mailToResource` int(1) unsigned DEFAULT '0',
  `mailToProject` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `mailToContact` int(1) unsigned DEFAULT '0',
  `mailToLeader` int(1) unsigned DEFAULT '0',
  `mailToOther` int(1) unsigned DEFAULT '0',
  `otherMail` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statusmailStatus` (`idStatus`),
  KEY `statusmailMailable` (`idMailable`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Contenu de la table `statusmail`
--

INSERT INTO `statusmail` (`id`, `idStatus`, `idMailable`, `mailToUser`, `mailToResource`, `mailToProject`, `idle`, `mailToContact`, `mailToLeader`, `mailToOther`, `otherMail`) VALUES
(1, 1, 1, 1, 1, 1, 0, 0, 0, 0, NULL),
(2, 2, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(3, 11, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(4, 8, 1, 1, 1, 1, 0, 0, 0, 0, NULL),
(5, 10, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(6, 3, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(7, 4, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(8, 5, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(9, 6, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(10, 12, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(11, 7, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(12, 9, 1, 1, 1, 0, 0, 0, 0, 0, NULL),
(13, 8, 2, 1, 1, 0, 0, 0, 0, 0, NULL),
(14, 10, 2, 0, 1, 0, 0, 0, 0, 0, NULL),
(15, 3, 2, 1, 0, 0, 0, 0, 0, 0, NULL),
(16, 4, 2, 1, 1, 0, 0, 0, 0, 0, NULL),
(17, 12, 2, 1, 1, 0, 0, 0, 0, 0, NULL),
(18, 7, 2, 1, 1, 0, 0, 0, 0, 0, NULL),
(19, 9, 2, 1, 1, 0, 0, 0, 0, 0, NULL),
(20, 8, 3, 1, 1, 0, 0, 0, 0, 0, NULL),
(21, 10, 3, 0, 1, 0, 0, 0, 0, 0, NULL),
(22, 3, 3, 1, 0, 0, 0, 0, 0, 0, NULL),
(23, 4, 3, 1, 1, 0, 0, 0, 0, 0, NULL),
(24, 12, 3, 1, 1, 0, 0, 0, 0, 0, NULL),
(25, 7, 3, 1, 1, 0, 0, 0, 0, 0, NULL),
(26, 9, 3, 1, 1, 0, 0, 0, 0, 0, NULL),
(27, 8, 4, 1, 1, 0, 0, 0, 0, 0, NULL),
(28, 10, 4, 0, 1, 0, 0, 0, 0, 0, NULL),
(29, 3, 4, 1, 0, 0, 0, 0, 0, 0, NULL),
(30, 4, 4, 1, 1, 0, 0, 0, 0, 0, NULL),
(31, 12, 4, 1, 1, 0, 0, 0, 0, 0, NULL),
(32, 7, 4, 1, 1, 0, 0, 0, 0, 0, NULL),
(33, 9, 4, 1, 1, 0, 0, 0, 0, 0, NULL),
(34, 8, 5, 1, 1, 0, 0, 0, 0, 0, NULL),
(35, 10, 5, 0, 1, 0, 0, 0, 0, 0, NULL),
(36, 3, 5, 1, 0, 0, 0, 0, 0, 0, NULL),
(37, 4, 5, 1, 1, 0, 0, 0, 0, 0, NULL),
(38, 12, 5, 1, 1, 0, 0, 0, 0, 0, NULL),
(39, 7, 5, 1, 1, 0, 0, 0, 0, 0, NULL),
(40, 9, 5, 1, 1, 0, 0, 0, 0, 0, NULL),
(41, 8, 6, 1, 1, 0, 0, 0, 0, 0, NULL),
(42, 10, 6, 0, 1, 0, 0, 0, 0, 0, NULL),
(43, 3, 6, 1, 0, 0, 0, 0, 0, 0, NULL),
(44, 4, 6, 1, 1, 0, 0, 0, 0, 0, NULL),
(45, 12, 6, 1, 1, 0, 0, 0, 0, 0, NULL),
(46, 7, 6, 1, 1, 0, 0, 0, 0, 0, NULL),
(47, 9, 6, 1, 1, 0, 0, 0, 0, 0, NULL),
(48, 13, 7, 0, 0, 1, 0, 0, 0, 0, NULL),
(49, 6, 7, 0, 0, 1, 0, 0, 0, 0, NULL),
(50, 12, 8, 0, 0, 1, 0, 0, 0, 0, NULL),
(51, 9, 8, 0, 0, 1, 0, 0, 0, 0, NULL),
(52, 1, 9, 1, 1, 1, 0, 0, 0, 0, NULL),
(53, 2, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(54, 11, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(55, 8, 9, 1, 1, 1, 0, 0, 0, 0, NULL),
(56, 10, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(57, 3, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(58, 4, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(59, 5, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(60, 6, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(61, 12, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(62, 7, 9, 1, 1, 0, 0, 0, 0, 0, NULL),
(63, 9, 9, 1, 1, 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `team`
--

INSERT INTO `team` (`id`, `name`, `description`, `idle`) VALUES
(1, 'web team', NULL, 0),
(2, 'swing team', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idTicketType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `initialDueDateTime` datetime DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `actualDueDateTime` datetime DEFAULT NULL,
  `idleDateTime` datetime DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idActivity` int(12) unsigned DEFAULT NULL,
  `idCriticality` int(12) unsigned DEFAULT NULL,
  `idUrgency` int(12) unsigned DEFAULT NULL,
  `idPriority` int(12) unsigned DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDateTime` datetime DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDateTime` datetime DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `idOriginalVersion` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticketProject` (`idProject`),
  KEY `ticketUser` (`idUser`),
  KEY `ticketResource` (`idResource`),
  KEY `ticketStatus` (`idStatus`),
  KEY `ticketType` (`idTicketType`),
  KEY `ticketActivity` (`idActivity`),
  KEY `ticketUrgency` (`idUrgency`),
  KEY `ticketPriority` (`idPriority`),
  KEY `ticketCriticality` (`idCriticality`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ticket`
--

INSERT INTO `ticket` (`id`, `idProject`, `idTicketType`, `name`, `description`, `creationDateTime`, `idUser`, `initialDueDateTime`, `idStatus`, `idResource`, `actualDueDateTime`, `idleDateTime`, `result`, `comment`, `idle`, `idActivity`, `idCriticality`, `idUrgency`, `idPriority`, `done`, `doneDateTime`, `handled`, `handledDateTime`, `idContact`, `idVersion`, `idOriginalVersion`) VALUES
(1, 1, 16, 'bug: it does not work', NULL, '2011-09-01 12:00:00', 1, '2011-09-02 18:00:00', 3, 3, '2011-09-09 18:30:00', NULL, NULL, NULL, 0, NULL, 1, 2, 1, 0, NULL, 1, '2011-09-02 01:54:00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `color` varchar(7) DEFAULT NULL,
  `idWorkflow` int(12) unsigned DEFAULT NULL,
  `mandatoryDescription` int(1) unsigned DEFAULT '0',
  `mandatoryResultOnDone` int(1) unsigned DEFAULT '0',
  `mandatoryResourceOnHandled` int(1) unsigned DEFAULT '0',
  `lockHandled` int(1) unsigned DEFAULT '0',
  `lockDone` int(1) unsigned DEFAULT '0',
  `lockIdle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `typeScope` (`scope`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id`, `scope`, `name`, `sortOrder`, `idle`, `color`, `idWorkflow`, `mandatoryDescription`, `mandatoryResultOnDone`, `mandatoryResourceOnHandled`, `lockHandled`, `lockDone`, `lockIdle`) VALUES
(1, 'Risk', 'Contractual', 10, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(2, 'Risk', 'Operational', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(3, 'Risk', 'Technical', 30, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(4, 'Issue', 'Technical issue', 10, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(5, 'Issue', 'Process non conformity', 30, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(6, 'Issue', 'Quality non conformity', 40, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(7, 'Issue', 'Process non appliability', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(8, 'Issue', 'Customer complaint', 90, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(9, 'Issue', 'Delay non respect', 50, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(10, 'Issue', 'Resource management issue', 70, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(12, 'Issue', 'Financial loss', 80, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(13, 'Message', 'ALERT', 10, 0, '#ff0000', 1, 0, 1, 1, 1, 1, 1),
(14, 'Message', 'WARNING', 10, 0, '#ffa500', 1, 0, 1, 1, 1, 1, 1),
(15, 'Message', 'INFO', 30, 0, '#0000ff', 1, 0, 1, 1, 1, 1, 1),
(16, 'Ticket', 'Incident', 10, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(17, 'Ticket', 'Support / Assistance', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(18, 'Ticket', 'Anomaly / Bug', 30, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(19, 'Activity', 'Development', 10, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(20, 'Activity', 'Evolution', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(21, 'Activity', 'Management', 30, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(22, 'Activity', 'Phase', 40, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(23, 'Milestone', 'Deliverable', 10, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(24, 'Milestone', 'Incoming', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(25, 'Milestone', 'Key date', 30, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(26, 'Activity', 'Task', 1, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(27, 'Action', 'Project', 10, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(28, 'Action', 'Internal', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(29, 'Action', 'Customer', 20, 0, NULL, 1, 0, 1, 1, 1, 1, 1),
(30, 'Meeting', 'Steering Committee', 10, 0, NULL, 7, 0, 1, 1, 1, 1, 1),
(31, 'Meeting', 'Progress Metting', 20, 0, NULL, 7, 0, 1, 1, 1, 1, 1),
(32, 'Meeting', 'Team meeting', 30, 0, NULL, 7, 0, 1, 1, 1, 1, 1),
(33, 'Decision', 'Functional', 10, 0, NULL, 6, 0, 1, 1, 1, 1, 1),
(34, 'Decision', 'Operational', 20, 0, NULL, 6, 0, 1, 1, 1, 1, 1),
(35, 'Decision', 'Contractual', 30, 0, NULL, 6, 0, 1, 1, 1, 1, 1),
(36, 'Decision', 'Strategic', 40, 0, NULL, 6, 0, 1, 1, 1, 1, 1),
(37, 'Question', 'Functional', 10, 0, NULL, 5, 0, 1, 1, 1, 1, 1),
(38, 'Question', 'Technical', 20, 0, NULL, 5, 0, 1, 1, 1, 1, 1),
(39, 'IndividualExpense', 'Expense report', 10, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(40, 'ProjectExpense', 'Machine expense', 10, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(41, 'ProjectExpense', 'Office expense', 20, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(42, 'Invoice', 'event invoice', 10, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(43, 'Invoice', 'partial invoice', 20, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(44, 'Invoice', 'final invoice', 30, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(45, 'Payment', 'event payment', 10, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(46, 'Payment', 'partial payment', 20, 0, NULL, 8, 0, 0, 0, 0, 0, 0),
(47, 'Payment', 'final payment', 30, 0, NULL, 8, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `urgency`
--

CREATE TABLE IF NOT EXISTS `urgency` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) unsigned DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `urgency`
--

INSERT INTO `urgency` (`id`, `name`, `value`, `color`, `sortOrder`, `idle`) VALUES
(1, 'Blocking', 4, '#ff0000', 30, 0),
(2, 'Urgent', 2, '#ffd700', 20, 0),
(3, 'Not urgent', 1, '#32cd32', 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `idProfile` int(12) DEFAULT NULL,
  `isResource` int(1) unsigned DEFAULT '0',
  `isUser` int(1) unsigned DEFAULT '0',
  `locked` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `idTeam` int(12) unsigned DEFAULT NULL,
  `capacity` decimal(5,2) unsigned DEFAULT '1.00',
  `address` varchar(4000) DEFAULT NULL,
  `isContact` int(1) unsigned DEFAULT '0',
  `idClient` int(12) unsigned DEFAULT NULL,
  `idRole` int(12) unsigned DEFAULT NULL,
  `isLdap` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userProfile` (`idProfile`),
  KEY `userTeam` (`idTeam`),
  KEY `userIsResource` (`isResource`),
  KEY `userIsUser` (`isUser`),
  KEY `userIsContact` (`isContact`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `name`, `fullName`, `email`, `description`, `password`, `idProfile`, `isResource`, `isUser`, `locked`, `idle`, `phone`, `mobile`, `fax`, `idTeam`, `capacity`, `address`, `isContact`, `idClient`, `idRole`, `isLdap`) VALUES
(1, 'admin', NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, 1.00, NULL, 0, NULL, NULL, 0),
(2, 'guest', NULL, NULL, NULL, '084e0343a0486ff05530df6c705c8bb4', 5, 0, 1, 0, 0, NULL, NULL, NULL, NULL, 1.00, NULL, 0, NULL, NULL, 0),
(3, 'manager1', 'project manager', 'project.manager@toolware.fr', NULL, '6d361b76b20af1a3ebbf75a00b501766', 3, 1, 1, 0, 0, NULL, NULL, NULL, 1, 1.00, NULL, 0, NULL, 1, 0),
(4, 'member1', 'analyst A', NULL, NULL, NULL, 4, 1, 1, 0, 0, NULL, NULL, NULL, 1, 1.00, NULL, 0, NULL, 2, 0),
(5, 'external1', 'external project leader one', NULL, NULL, NULL, 6, 0, 1, 0, 0, NULL, NULL, NULL, NULL, 1.00, NULL, 1, 1, NULL, 0),
(6, 'external2', 'external project leader two', NULL, NULL, NULL, 6, 0, 1, 0, 0, NULL, NULL, NULL, NULL, 1.00, NULL, 1, 2, NULL, 0),
(7, NULL, 'external business leader one', NULL, NULL, NULL, 5, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1.00, NULL, 1, 1, NULL, 0),
(8, 'member2', 'analyst B', NULL, NULL, NULL, 4, 1, 1, 0, 0, NULL, NULL, NULL, 1, 1.00, NULL, 0, NULL, 2, 0),
(9, 'member3', 'analyst C', NULL, NULL, NULL, 4, 1, 1, 0, 0, NULL, NULL, NULL, 2, 1.00, NULL, 0, NULL, 2, 0),
(10, NULL, 'web developer', NULL, NULL, NULL, 4, 1, 0, 0, 0, NULL, NULL, NULL, 1, 5.00, NULL, 0, NULL, 3, 0),
(11, NULL, 'swing developer', NULL, NULL, NULL, 4, 1, 0, 0, 0, NULL, NULL, NULL, 2, 5.00, NULL, 0, NULL, 3, 0),
(12, NULL, 'multi developer', NULL, NULL, NULL, 4, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 5.00, NULL, 0, NULL, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `version`
--

CREATE TABLE IF NOT EXISTS `version` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `versionProduct` (`idProduct`),
  KEY `versionContact` (`idContact`),
  KEY `versionResource` (`idResource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `version`
--

INSERT INTO `version` (`id`, `idProduct`, `idContact`, `idResource`, `name`, `description`, `creationDate`, `idle`) VALUES
(1, 1, 5, 3, 'wa V1.0', NULL, '2011-09-01', 0),
(2, 1, 5, 3, 'wa V2.0', NULL, '2011-09-01', 0),
(3, 2, 6, 3, 'sa V1.0', NULL, '2011-09-01', 0);

-- --------------------------------------------------------

--
-- Structure de la table `versionproject`
--

CREATE TABLE IF NOT EXISTS `versionproject` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `versionprojectProject` (`idProject`),
  KEY `versionprojectVersion` (`idVersion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `versionproject`
--

INSERT INTO `versionproject` (`id`, `idProject`, `idVersion`, `startDate`, `endDate`, `idle`) VALUES
(1, 1, 1, NULL, NULL, 0),
(2, 2, 1, NULL, NULL, 0),
(3, 1, 2, NULL, NULL, 0),
(4, 3, 2, NULL, NULL, 0),
(5, 4, 3, '2011-09-01', '2011-12-31', 0);

-- --------------------------------------------------------

--
-- Structure de la table `visibilityscope`
--

CREATE TABLE IF NOT EXISTS `visibilityscope` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `accessCode` varchar(3) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `visibilityscope`
--

INSERT INTO `visibilityscope` (`id`, `name`, `accessCode`, `sortOrder`, `idle`) VALUES
(1, 'visibilityScopeNo', 'NO', 100, 0),
(2, 'visibilityScopeValid', 'VAL', 200, 0),
(4, 'visibilityScopeAll', 'ALL', 400, 0);

-- --------------------------------------------------------

--
-- Structure de la table `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idAssignment` int(12) unsigned DEFAULT NULL,
  `work` decimal(8,5) unsigned DEFAULT NULL,
  `workDate` date DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `dailyCost` decimal(7,2) DEFAULT NULL,
  `cost` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workDay` (`day`),
  KEY `workWeek` (`week`),
  KEY `workMonth` (`month`),
  KEY `workYear` (`year`),
  KEY `workRef` (`refType`,`refId`),
  KEY `workResource` (`idResource`),
  KEY `workAssignment` (`idAssignment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `work`
--

INSERT INTO `work` (`id`, `idResource`, `idProject`, `refType`, `refId`, `idAssignment`, `work`, `workDate`, `day`, `week`, `month`, `year`, `dailyCost`, `cost`) VALUES
(1, 8, 3, 'Activity', 3, 3, 1.00000, '2011-09-05', '20110905', '201136', '201109', '2011', 300.00, 300.00),
(2, 8, 3, 'Activity', 3, 3, 1.00000, '2011-09-06', '20110906', '201136', '201109', '2011', 300.00, 300.00),
(3, 8, 3, 'Activity', 3, 3, 0.50000, '2011-09-07', '20110907', '201136', '201109', '2011', 300.00, 150.00),
(4, 8, 3, 'Activity', 3, 3, 1.00000, '2011-10-10', '20111010', '201141', '201110', '2011', 300.00, 300.00),
(5, 8, 3, 'Activity', 3, 3, 1.00000, '2011-10-11', '20111011', '201141', '201110', '2011', 300.00, 300.00),
(6, 8, 3, 'Activity', 3, 3, 1.00000, '2011-10-12', '20111012', '201141', '201110', '2011', 300.00, 300.00),
(7, 8, 3, 'Activity', 3, 3, 0.20000, '2011-10-13', '20111013', '201141', '201110', '2011', 300.00, 60.00);

-- --------------------------------------------------------

--
-- Structure de la table `workflow`
--

CREATE TABLE IF NOT EXISTS `workflow` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `workflowUpdate` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `workflow`
--

INSERT INTO `workflow` (`id`, `name`, `description`, `idle`, `workflowUpdate`, `sortOrder`) VALUES
(1, 'Default', 'Default workflow with just logic constraints.\nAnyone can change status.', 0, '[     ]', NULL),
(2, 'Simple', 'Simple workflow with limited status.\nAnyone can change status.', 0, '[     ]', NULL),
(3, 'External validation', 'Elaborated workflow with internal team treatment and external validation.', 0, '[      ]', NULL),
(4, 'External acceptation & validation', 'Elaborated workflow with external acceptation, internal team treatment and external validation.', 0, '[     ]', NULL),
(5, 'Simple with validation', 'Simple workflow with limited status, including validation.\nAnyone can change status.', 0, '[     ]', NULL),
(6, 'Validation', 'Short workflow with only validation or cancel possibility.\nRestricted validation rights.', 0, '[      ]', NULL),
(7, 'Simple with preparation', 'Simple workflow with limited status, including preparation.\nAnyone can change status.', 0, '[     ]', NULL),
(8, 'Simple with Project Leader validation', 'Simple workflow with limited status, including Project Leader validation.\nAnyone can change status, except validation : only Project Leader.', 0, '[     ]', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `workflowstatus`
--

CREATE TABLE IF NOT EXISTS `workflowstatus` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idWorkflow` int(12) unsigned NOT NULL,
  `idStatusFrom` int(12) unsigned NOT NULL,
  `idStatusTo` int(12) unsigned NOT NULL,
  `idProfile` int(12) unsigned NOT NULL,
  `allowed` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `workflowstatusProfile` (`idProfile`),
  KEY `workflowstatusWorkflow` (`idWorkflow`),
  KEY `workflowstatusStatusFrom` (`idStatusFrom`),
  KEY `workflowstatusStatusTo` (`idStatusTo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=672 ;

--
-- Contenu de la table `workflowstatus`
--

INSERT INTO `workflowstatus` (`id`, `idWorkflow`, `idStatusFrom`, `idStatusTo`, `idProfile`, `allowed`) VALUES
(1, 0, 1, 8, 1, 1),
(2, 0, 1, 8, 2, 1),
(3, 0, 1, 8, 3, 1),
(4, 3, 1, 2, 4, 1),
(5, 1, 1, 11, 3, 1),
(6, 1, 1, 11, 4, 1),
(7, 1, 1, 11, 6, 1),
(8, 1, 1, 11, 7, 1),
(9, 1, 1, 11, 5, 1),
(10, 1, 1, 10, 1, 1),
(11, 1, 1, 10, 2, 1),
(12, 1, 1, 10, 3, 1),
(13, 1, 1, 10, 4, 1),
(14, 1, 1, 10, 6, 1),
(15, 1, 1, 10, 7, 1),
(16, 1, 1, 10, 5, 1),
(17, 1, 1, 11, 1, 1),
(18, 1, 1, 11, 2, 1),
(19, 1, 2, 10, 1, 1),
(20, 1, 2, 3, 1, 1),
(21, 1, 2, 3, 2, 1),
(22, 1, 2, 3, 3, 1),
(23, 1, 2, 3, 4, 1),
(24, 1, 2, 3, 6, 1),
(25, 1, 2, 3, 7, 1),
(26, 1, 2, 3, 5, 1),
(27, 2, 1, 10, 1, 1),
(28, 2, 1, 10, 2, 1),
(29, 2, 1, 10, 3, 1),
(30, 2, 1, 10, 4, 1),
(31, 2, 1, 10, 6, 1),
(32, 2, 1, 10, 7, 1),
(33, 2, 1, 10, 5, 1),
(34, 1, 1, 3, 1, 1),
(35, 1, 1, 3, 4, 1),
(36, 1, 1, 4, 3, 1),
(37, 1, 1, 2, 3, 1),
(38, 1, 1, 2, 7, 1),
(39, 1, 1, 4, 2, 1),
(40, 1, 1, 3, 2, 1),
(41, 1, 1, 3, 7, 1),
(42, 1, 1, 3, 3, 1),
(43, 1, 1, 4, 4, 1),
(44, 1, 1, 4, 1, 1),
(45, 1, 1, 4, 7, 1),
(46, 3, 1, 10, 3, 1),
(47, 3, 1, 10, 4, 1),
(48, 3, 1, 3, 3, 1),
(49, 3, 1, 3, 4, 1),
(71, 1, 4, 5, 2, 1),
(72, 1, 4, 5, 3, 1),
(73, 1, 4, 5, 4, 1),
(74, 1, 4, 5, 6, 1),
(75, 1, 4, 5, 7, 1),
(76, 1, 4, 5, 5, 1),
(77, 1, 1, 2, 1, 1),
(78, 1, 1, 2, 2, 1),
(79, 1, 1, 2, 4, 1),
(80, 1, 1, 2, 6, 1),
(81, 1, 1, 2, 5, 1),
(82, 1, 1, 3, 6, 1),
(83, 1, 1, 3, 5, 1),
(84, 1, 1, 4, 6, 1),
(85, 1, 1, 4, 5, 1),
(86, 1, 1, 9, 1, 1),
(87, 1, 1, 9, 2, 1),
(88, 1, 1, 9, 3, 1),
(89, 1, 1, 9, 4, 1),
(90, 1, 1, 9, 6, 1),
(91, 1, 1, 9, 7, 1),
(92, 1, 1, 9, 5, 1),
(93, 1, 2, 11, 1, 1),
(94, 1, 2, 11, 2, 1),
(95, 1, 2, 11, 3, 1),
(96, 1, 2, 11, 4, 1),
(97, 1, 2, 11, 6, 1),
(98, 1, 2, 11, 7, 1),
(99, 1, 2, 11, 5, 1),
(100, 1, 2, 10, 2, 1),
(101, 1, 2, 10, 3, 1),
(102, 1, 2, 10, 4, 1),
(103, 1, 2, 10, 6, 1),
(104, 1, 2, 10, 7, 1),
(105, 1, 2, 10, 5, 1),
(106, 1, 2, 4, 1, 1),
(107, 1, 2, 4, 2, 1),
(108, 1, 2, 4, 3, 1),
(109, 1, 2, 4, 4, 1),
(110, 1, 2, 4, 6, 1),
(111, 1, 2, 4, 7, 1),
(112, 1, 2, 4, 5, 1),
(113, 1, 2, 9, 1, 1),
(114, 1, 2, 9, 2, 1),
(115, 1, 2, 9, 3, 1),
(116, 1, 2, 9, 4, 1),
(117, 1, 2, 9, 6, 1),
(118, 1, 2, 9, 7, 1),
(119, 1, 2, 9, 5, 1),
(120, 1, 11, 10, 1, 1),
(121, 1, 11, 10, 2, 1),
(122, 1, 11, 10, 3, 1),
(123, 1, 11, 10, 4, 1),
(124, 1, 11, 10, 6, 1),
(125, 1, 11, 10, 7, 1),
(126, 1, 11, 10, 5, 1),
(127, 1, 11, 3, 1, 1),
(128, 1, 11, 3, 2, 1),
(129, 1, 11, 3, 3, 1),
(130, 1, 11, 3, 4, 1),
(131, 1, 11, 3, 6, 1),
(132, 1, 11, 3, 7, 1),
(133, 1, 11, 3, 5, 1),
(134, 1, 11, 4, 1, 1),
(135, 1, 11, 4, 2, 1),
(136, 1, 11, 4, 3, 1),
(137, 1, 11, 4, 4, 1),
(138, 1, 11, 4, 6, 1),
(139, 1, 11, 4, 7, 1),
(140, 1, 11, 4, 5, 1),
(141, 1, 11, 9, 1, 1),
(142, 1, 11, 9, 2, 1),
(143, 1, 11, 9, 3, 1),
(144, 1, 11, 9, 4, 1),
(145, 1, 11, 9, 6, 1),
(146, 1, 11, 9, 7, 1),
(147, 1, 11, 9, 5, 1),
(148, 1, 8, 10, 1, 1),
(149, 1, 8, 10, 2, 1),
(150, 1, 8, 10, 3, 1),
(151, 1, 8, 10, 4, 1),
(152, 1, 8, 10, 6, 1),
(153, 1, 8, 10, 7, 1),
(154, 1, 8, 10, 5, 1),
(155, 1, 8, 3, 1, 1),
(156, 1, 8, 3, 2, 1),
(157, 1, 8, 3, 3, 1),
(158, 1, 8, 3, 4, 1),
(159, 1, 8, 3, 6, 1),
(160, 1, 8, 3, 7, 1),
(161, 1, 8, 3, 5, 1),
(162, 1, 8, 4, 1, 1),
(163, 1, 8, 4, 2, 1),
(164, 1, 8, 4, 3, 1),
(165, 1, 8, 4, 4, 1),
(166, 1, 8, 4, 6, 1),
(167, 1, 8, 4, 7, 1),
(168, 1, 8, 4, 5, 1),
(169, 1, 8, 5, 1, 1),
(170, 1, 8, 5, 2, 1),
(171, 1, 8, 5, 3, 1),
(172, 1, 8, 5, 4, 1),
(173, 1, 8, 5, 6, 1),
(174, 1, 8, 5, 7, 1),
(175, 1, 8, 5, 5, 1),
(176, 1, 8, 6, 1, 1),
(177, 1, 8, 6, 2, 1),
(178, 1, 8, 6, 3, 1),
(179, 1, 8, 6, 4, 1),
(180, 1, 8, 6, 6, 1),
(181, 1, 8, 6, 7, 1),
(182, 1, 8, 6, 5, 1),
(183, 1, 8, 12, 1, 1),
(184, 1, 8, 12, 2, 1),
(185, 1, 8, 12, 3, 1),
(186, 1, 8, 12, 4, 1),
(187, 1, 8, 12, 6, 1),
(188, 1, 8, 12, 7, 1),
(189, 1, 8, 12, 5, 1),
(190, 1, 8, 7, 1, 1),
(191, 1, 8, 7, 2, 1),
(192, 1, 8, 7, 3, 1),
(193, 1, 8, 7, 4, 1),
(194, 1, 8, 7, 6, 1),
(195, 1, 8, 7, 7, 1),
(196, 1, 8, 7, 5, 1),
(197, 1, 8, 9, 1, 1),
(198, 1, 8, 9, 2, 1),
(199, 1, 8, 9, 3, 1),
(200, 1, 8, 9, 4, 1),
(201, 1, 8, 9, 6, 1),
(202, 1, 8, 9, 7, 1),
(203, 1, 8, 9, 5, 1),
(204, 1, 10, 3, 1, 1),
(205, 1, 10, 3, 2, 1),
(206, 1, 10, 3, 3, 1),
(207, 1, 10, 3, 4, 1),
(208, 1, 10, 3, 6, 1),
(209, 1, 10, 3, 7, 1),
(210, 1, 10, 3, 5, 1),
(211, 1, 10, 4, 1, 1),
(212, 1, 10, 4, 2, 1),
(213, 1, 10, 4, 3, 1),
(214, 1, 10, 4, 4, 1),
(215, 1, 10, 4, 6, 1),
(216, 1, 10, 4, 7, 1),
(217, 1, 10, 4, 5, 1),
(218, 1, 10, 9, 1, 1),
(219, 1, 10, 9, 2, 1),
(220, 1, 10, 9, 3, 1),
(221, 1, 10, 9, 4, 1),
(222, 1, 10, 9, 6, 1),
(223, 1, 10, 9, 7, 1),
(224, 1, 10, 9, 5, 1),
(225, 1, 3, 4, 1, 1),
(226, 1, 3, 4, 2, 1),
(227, 1, 3, 4, 3, 1),
(228, 1, 3, 4, 4, 1),
(229, 1, 3, 4, 6, 1),
(230, 1, 3, 4, 7, 1),
(231, 1, 3, 4, 5, 1),
(232, 1, 3, 9, 1, 1),
(233, 1, 3, 9, 2, 1),
(234, 1, 3, 9, 3, 1),
(235, 1, 3, 9, 4, 1),
(236, 1, 3, 9, 6, 1),
(237, 1, 3, 9, 7, 1),
(238, 1, 3, 9, 5, 1),
(239, 1, 4, 8, 1, 1),
(240, 1, 4, 8, 2, 1),
(241, 1, 4, 8, 3, 1),
(242, 1, 4, 8, 4, 1),
(243, 1, 4, 8, 6, 1),
(244, 1, 4, 8, 7, 1),
(245, 1, 4, 8, 5, 1),
(246, 1, 4, 5, 1, 1),
(247, 1, 4, 6, 1, 1),
(248, 1, 4, 6, 2, 1),
(249, 1, 4, 6, 3, 1),
(250, 1, 4, 6, 4, 1),
(251, 1, 4, 6, 6, 1),
(252, 1, 4, 6, 7, 1),
(253, 1, 4, 6, 5, 1),
(254, 1, 4, 12, 1, 1),
(255, 1, 4, 12, 2, 1),
(256, 1, 4, 12, 3, 1),
(257, 1, 4, 12, 4, 1),
(258, 1, 4, 12, 6, 1),
(259, 1, 4, 12, 7, 1),
(260, 1, 4, 12, 5, 1),
(261, 1, 4, 7, 1, 1),
(262, 1, 4, 7, 2, 1),
(263, 1, 4, 7, 3, 1),
(264, 1, 4, 7, 4, 1),
(265, 1, 4, 7, 6, 1),
(266, 1, 4, 7, 7, 1),
(267, 1, 4, 7, 5, 1),
(268, 1, 5, 8, 1, 1),
(269, 1, 5, 8, 2, 1),
(270, 1, 5, 8, 3, 1),
(271, 1, 5, 8, 4, 1),
(272, 1, 5, 8, 6, 1),
(273, 1, 5, 8, 7, 1),
(274, 1, 5, 8, 5, 1),
(275, 1, 5, 6, 1, 1),
(276, 1, 5, 6, 2, 1),
(277, 1, 5, 6, 3, 1),
(278, 1, 5, 6, 4, 1),
(279, 1, 5, 6, 6, 1),
(280, 1, 5, 6, 7, 1),
(281, 1, 5, 6, 5, 1),
(282, 1, 5, 12, 1, 1),
(283, 1, 5, 12, 2, 1),
(284, 1, 5, 12, 3, 1),
(285, 1, 5, 12, 4, 1),
(286, 1, 5, 12, 6, 1),
(287, 1, 5, 12, 7, 1),
(288, 1, 5, 12, 5, 1),
(289, 1, 5, 7, 1, 1),
(290, 1, 5, 7, 2, 1),
(291, 1, 5, 7, 3, 1),
(292, 1, 5, 7, 4, 1),
(293, 1, 5, 7, 6, 1),
(294, 1, 5, 7, 7, 1),
(295, 1, 5, 7, 5, 1),
(296, 1, 6, 8, 1, 1),
(297, 1, 6, 8, 2, 1),
(298, 1, 6, 8, 3, 1),
(299, 1, 6, 8, 4, 1),
(300, 1, 6, 8, 6, 1),
(301, 1, 6, 8, 7, 1),
(302, 1, 6, 8, 5, 1),
(303, 1, 6, 12, 1, 1),
(304, 1, 6, 12, 2, 1),
(305, 1, 6, 12, 3, 1),
(306, 1, 6, 12, 4, 1),
(307, 1, 6, 12, 6, 1),
(308, 1, 6, 12, 7, 1),
(309, 1, 6, 12, 5, 1),
(310, 1, 6, 7, 1, 1),
(311, 1, 6, 7, 2, 1),
(312, 1, 6, 7, 3, 1),
(313, 1, 6, 7, 4, 1),
(314, 1, 6, 7, 6, 1),
(315, 1, 6, 7, 7, 1),
(316, 1, 6, 7, 5, 1),
(317, 1, 12, 8, 1, 1),
(318, 1, 12, 8, 2, 1),
(319, 1, 12, 8, 3, 1),
(320, 1, 12, 8, 4, 1),
(321, 1, 12, 8, 6, 1),
(322, 1, 12, 8, 7, 1),
(323, 1, 12, 8, 5, 1),
(324, 1, 12, 7, 1, 1),
(325, 1, 12, 7, 2, 1),
(326, 1, 12, 7, 3, 1),
(327, 1, 12, 7, 4, 1),
(328, 1, 12, 7, 6, 1),
(329, 1, 12, 7, 7, 1),
(330, 1, 12, 7, 5, 1),
(331, 1, 7, 8, 1, 1),
(332, 1, 7, 8, 2, 1),
(333, 1, 7, 8, 3, 1),
(334, 1, 7, 8, 4, 1),
(335, 1, 7, 8, 6, 1),
(336, 1, 7, 8, 7, 1),
(337, 1, 7, 8, 5, 1),
(338, 1, 9, 8, 1, 1),
(339, 1, 9, 8, 2, 1),
(340, 1, 9, 8, 3, 1),
(341, 1, 9, 8, 4, 1),
(342, 1, 9, 8, 6, 1),
(343, 1, 9, 8, 7, 1),
(344, 1, 9, 8, 5, 1),
(345, 2, 1, 9, 1, 1),
(346, 2, 1, 9, 2, 1),
(347, 2, 1, 9, 3, 1),
(348, 2, 1, 9, 4, 1),
(349, 2, 1, 9, 6, 1),
(350, 2, 1, 9, 7, 1),
(351, 2, 1, 9, 5, 1),
(352, 2, 8, 10, 1, 1),
(353, 2, 8, 10, 2, 1),
(354, 2, 8, 10, 3, 1),
(355, 2, 8, 10, 4, 1),
(356, 2, 8, 10, 6, 1),
(357, 2, 8, 10, 7, 1),
(358, 2, 8, 10, 5, 1),
(359, 2, 8, 9, 1, 1),
(360, 2, 8, 9, 2, 1),
(361, 2, 8, 9, 3, 1),
(362, 2, 8, 9, 4, 1),
(363, 2, 8, 9, 6, 1),
(364, 2, 8, 9, 7, 1),
(365, 2, 8, 9, 5, 1),
(366, 2, 10, 3, 1, 1),
(367, 2, 10, 3, 2, 1),
(368, 2, 10, 3, 3, 1),
(369, 2, 10, 3, 4, 1),
(370, 2, 10, 3, 6, 1),
(371, 2, 10, 3, 7, 1),
(372, 2, 10, 3, 5, 1),
(373, 2, 10, 9, 1, 1),
(374, 2, 10, 9, 2, 1),
(375, 2, 10, 9, 3, 1),
(376, 2, 10, 9, 4, 1),
(377, 2, 10, 9, 6, 1),
(378, 2, 10, 9, 7, 1),
(379, 2, 10, 9, 5, 1),
(380, 2, 3, 4, 1, 1),
(381, 2, 3, 4, 2, 1),
(382, 2, 3, 4, 3, 1),
(383, 2, 3, 4, 4, 1),
(384, 2, 3, 4, 6, 1),
(385, 2, 3, 4, 7, 1),
(386, 2, 3, 4, 5, 1),
(387, 2, 3, 9, 1, 1),
(388, 2, 3, 9, 2, 1),
(389, 2, 3, 9, 3, 1),
(390, 2, 3, 9, 4, 1),
(391, 2, 3, 9, 6, 1),
(392, 2, 3, 9, 7, 1),
(393, 2, 3, 9, 5, 1),
(394, 2, 4, 8, 1, 1),
(395, 2, 4, 8, 2, 1),
(396, 2, 4, 8, 3, 1),
(397, 2, 4, 8, 4, 1),
(398, 2, 4, 8, 6, 1),
(399, 2, 4, 8, 7, 1),
(400, 2, 4, 8, 5, 1),
(401, 2, 4, 7, 1, 1),
(402, 2, 4, 7, 2, 1),
(403, 2, 4, 7, 3, 1),
(404, 2, 4, 7, 4, 1),
(405, 2, 4, 7, 6, 1),
(406, 2, 4, 7, 7, 1),
(407, 2, 4, 7, 5, 1),
(408, 2, 7, 8, 1, 1),
(409, 2, 7, 8, 2, 1),
(410, 2, 7, 8, 3, 1),
(411, 2, 7, 8, 4, 1),
(412, 2, 7, 8, 6, 1),
(413, 2, 7, 8, 7, 1),
(414, 2, 7, 8, 5, 1),
(415, 2, 9, 8, 1, 1),
(416, 2, 9, 8, 2, 1),
(417, 2, 9, 8, 3, 1),
(418, 2, 9, 8, 4, 1),
(419, 2, 9, 8, 6, 1),
(420, 2, 9, 8, 7, 1),
(421, 2, 9, 8, 5, 1),
(422, 3, 1, 2, 3, 1),
(423, 3, 1, 9, 3, 1),
(424, 3, 1, 9, 4, 1),
(425, 3, 2, 10, 3, 1),
(426, 3, 2, 10, 4, 1),
(427, 3, 2, 3, 3, 1),
(428, 3, 2, 3, 4, 1),
(429, 3, 2, 9, 3, 1),
(430, 3, 2, 9, 4, 1),
(431, 3, 8, 10, 3, 1),
(432, 3, 8, 10, 4, 1),
(433, 3, 8, 3, 3, 1),
(434, 3, 8, 3, 4, 1),
(435, 3, 8, 9, 3, 1),
(436, 3, 8, 9, 4, 1),
(437, 3, 10, 3, 3, 1),
(438, 3, 10, 3, 4, 1),
(439, 3, 10, 9, 3, 1),
(440, 3, 10, 9, 4, 1),
(441, 3, 3, 4, 3, 1),
(442, 3, 3, 4, 4, 1),
(443, 3, 3, 9, 3, 1),
(444, 3, 3, 9, 4, 1),
(445, 3, 4, 3, 3, 1),
(446, 3, 4, 3, 4, 1),
(447, 3, 4, 5, 3, 1),
(448, 3, 4, 5, 4, 1),
(449, 3, 4, 6, 3, 1),
(450, 3, 5, 6, 3, 1),
(451, 3, 6, 8, 6, 1),
(452, 3, 6, 8, 7, 1),
(453, 3, 6, 12, 6, 1),
(454, 3, 6, 12, 7, 1),
(455, 3, 12, 7, 3, 1),
(456, 3, 12, 7, 4, 1),
(457, 3, 12, 7, 6, 1),
(458, 3, 12, 7, 7, 1),
(459, 3, 7, 8, 3, 1),
(460, 3, 7, 8, 4, 1),
(461, 3, 7, 8, 6, 1),
(462, 3, 7, 8, 7, 1),
(463, 3, 9, 8, 3, 1),
(464, 3, 9, 8, 4, 1),
(465, 3, 9, 8, 6, 1),
(466, 3, 9, 8, 7, 1),
(467, 4, 1, 2, 3, 1),
(468, 4, 1, 2, 4, 1),
(469, 4, 2, 11, 6, 1),
(470, 4, 2, 11, 7, 1),
(471, 4, 2, 9, 6, 1),
(472, 4, 2, 9, 7, 1),
(473, 4, 11, 10, 3, 1),
(474, 4, 11, 10, 4, 1),
(475, 4, 11, 3, 3, 1),
(476, 4, 11, 3, 4, 1),
(477, 4, 8, 10, 3, 1),
(478, 4, 8, 10, 4, 1),
(479, 4, 8, 3, 3, 1),
(480, 4, 8, 3, 4, 1),
(481, 4, 10, 3, 3, 1),
(482, 4, 10, 3, 4, 1),
(483, 4, 3, 4, 3, 1),
(484, 4, 3, 4, 4, 1),
(485, 4, 11, 2, 3, 1),
(486, 4, 4, 5, 3, 1),
(487, 4, 4, 5, 4, 1),
(488, 4, 5, 6, 3, 1),
(489, 4, 4, 10, 3, 1),
(490, 4, 4, 10, 4, 1),
(491, 4, 4, 3, 3, 1),
(492, 4, 4, 3, 4, 1),
(493, 4, 6, 8, 6, 1),
(494, 4, 6, 8, 7, 1),
(495, 4, 6, 12, 6, 1),
(496, 4, 6, 12, 7, 1),
(497, 4, 12, 7, 3, 1),
(498, 4, 12, 7, 4, 1),
(499, 4, 12, 7, 6, 1),
(500, 4, 12, 7, 7, 1),
(501, 4, 7, 8, 3, 1),
(502, 4, 7, 8, 6, 1),
(503, 4, 9, 8, 6, 1),
(504, 5, 1, 10, 1, 1),
(505, 5, 1, 10, 2, 1),
(506, 5, 1, 10, 3, 1),
(507, 5, 1, 10, 4, 1),
(508, 5, 1, 10, 6, 1),
(509, 5, 1, 10, 7, 1),
(510, 5, 1, 10, 5, 1),
(511, 5, 1, 9, 1, 1),
(512, 5, 1, 9, 2, 1),
(513, 5, 1, 9, 3, 1),
(514, 5, 1, 9, 4, 1),
(515, 5, 1, 9, 6, 1),
(516, 5, 1, 9, 7, 1),
(517, 5, 1, 9, 5, 1),
(518, 5, 8, 10, 1, 1),
(519, 5, 8, 10, 2, 1),
(520, 5, 8, 10, 3, 1),
(521, 5, 8, 10, 4, 1),
(522, 5, 8, 10, 6, 1),
(523, 5, 8, 10, 7, 1),
(524, 5, 8, 10, 5, 1),
(525, 5, 8, 9, 1, 1),
(526, 5, 8, 9, 2, 1),
(527, 5, 8, 9, 3, 1),
(528, 5, 8, 9, 4, 1),
(529, 5, 8, 9, 6, 1),
(530, 5, 8, 9, 7, 1),
(531, 5, 8, 9, 5, 1),
(532, 5, 10, 3, 1, 1),
(533, 5, 10, 3, 2, 1),
(534, 5, 10, 3, 3, 1),
(535, 5, 10, 3, 4, 1),
(536, 5, 10, 3, 6, 1),
(537, 5, 10, 3, 7, 1),
(538, 5, 10, 3, 5, 1),
(539, 5, 10, 9, 1, 1),
(540, 5, 10, 9, 2, 1),
(541, 5, 10, 9, 3, 1),
(542, 5, 10, 9, 4, 1),
(543, 5, 10, 9, 6, 1),
(544, 5, 10, 9, 7, 1),
(545, 5, 10, 9, 5, 1),
(546, 5, 3, 4, 1, 1),
(547, 5, 3, 4, 2, 1),
(548, 5, 3, 4, 3, 1),
(549, 5, 3, 4, 4, 1),
(550, 5, 3, 4, 6, 1),
(551, 5, 3, 4, 7, 1),
(552, 5, 3, 4, 5, 1),
(553, 5, 3, 9, 1, 1),
(554, 5, 3, 9, 2, 1),
(555, 5, 3, 9, 3, 1),
(556, 5, 3, 9, 4, 1),
(557, 5, 3, 9, 6, 1),
(558, 5, 3, 9, 7, 1),
(559, 5, 3, 9, 5, 1),
(560, 5, 4, 8, 1, 1),
(561, 5, 4, 8, 2, 1),
(562, 5, 4, 8, 3, 1),
(563, 5, 4, 8, 4, 1),
(564, 5, 4, 8, 6, 1),
(565, 5, 4, 8, 7, 1),
(566, 5, 4, 8, 5, 1),
(567, 5, 4, 12, 1, 1),
(568, 5, 4, 12, 2, 1),
(569, 5, 4, 12, 3, 1),
(570, 5, 4, 12, 4, 1),
(571, 5, 4, 12, 6, 1),
(572, 5, 4, 12, 7, 1),
(573, 5, 4, 12, 5, 1),
(574, 5, 12, 8, 1, 1),
(575, 5, 12, 8, 2, 1),
(576, 5, 12, 8, 3, 1),
(577, 5, 12, 8, 4, 1),
(578, 5, 12, 8, 6, 1),
(579, 5, 12, 8, 7, 1),
(580, 5, 12, 8, 5, 1),
(581, 5, 12, 7, 1, 1),
(582, 5, 12, 7, 2, 1),
(583, 5, 12, 7, 3, 1),
(584, 5, 12, 7, 4, 1),
(585, 5, 12, 7, 6, 1),
(586, 5, 12, 7, 7, 1),
(587, 5, 12, 7, 5, 1),
(588, 5, 7, 8, 1, 1),
(589, 5, 7, 8, 2, 1),
(590, 5, 7, 8, 3, 1),
(591, 5, 7, 8, 4, 1),
(592, 5, 7, 8, 6, 1),
(593, 5, 7, 8, 7, 1),
(594, 5, 7, 8, 5, 1),
(595, 5, 9, 8, 1, 1),
(596, 5, 9, 8, 2, 1),
(597, 5, 9, 8, 3, 1),
(598, 5, 9, 8, 4, 1),
(599, 5, 9, 8, 6, 1),
(600, 5, 9, 8, 7, 1),
(601, 5, 9, 8, 5, 1),
(602, 7, 1, 13, 1, 1),
(603, 7, 1, 13, 2, 1),
(604, 7, 1, 13, 3, 1),
(605, 7, 1, 13, 4, 1),
(606, 7, 1, 13, 6, 1),
(607, 7, 1, 13, 7, 1),
(608, 7, 1, 13, 5, 1),
(609, 7, 1, 9, 1, 1),
(610, 7, 1, 9, 2, 1),
(611, 7, 1, 9, 3, 1),
(612, 7, 1, 9, 4, 1),
(613, 7, 1, 9, 6, 1),
(614, 7, 1, 9, 7, 1),
(615, 7, 1, 9, 5, 1),
(616, 7, 13, 9, 1, 1),
(617, 7, 13, 9, 2, 1),
(618, 7, 13, 9, 3, 1),
(619, 7, 13, 9, 4, 1),
(620, 7, 13, 9, 6, 1),
(621, 7, 13, 9, 7, 1),
(622, 7, 13, 9, 5, 1),
(623, 7, 13, 4, 1, 1),
(624, 7, 13, 4, 2, 1),
(625, 7, 13, 4, 3, 1),
(626, 7, 13, 4, 4, 1),
(627, 7, 13, 4, 6, 1),
(628, 7, 13, 4, 7, 1),
(629, 7, 13, 4, 5, 1),
(630, 7, 4, 6, 1, 1),
(631, 7, 4, 6, 2, 1),
(632, 7, 4, 6, 3, 1),
(633, 7, 4, 6, 4, 1),
(634, 7, 4, 6, 6, 1),
(635, 7, 4, 6, 7, 1),
(636, 7, 4, 6, 5, 1),
(637, 7, 6, 12, 1, 1),
(638, 7, 6, 12, 2, 1),
(639, 7, 6, 12, 3, 1),
(640, 7, 6, 12, 6, 1),
(641, 7, 6, 12, 6, 1),
(642, 7, 6, 12, 7, 1),
(643, 7, 6, 12, 5, 1),
(644, 6, 1, 12, 1, 1),
(645, 6, 1, 12, 3, 1),
(646, 6, 1, 9, 1, 1),
(647, 6, 1, 9, 3, 1),
(648, 8, 1, 3, 1, 1),
(649, 8, 1, 3, 2, 1),
(650, 8, 1, 3, 3, 1),
(651, 8, 1, 3, 4, 1),
(652, 8, 1, 3, 6, 1),
(653, 8, 1, 3, 7, 1),
(654, 8, 1, 3, 5, 1),
(655, 8, 3, 4, 1, 1),
(656, 8, 3, 4, 2, 1),
(657, 8, 3, 4, 3, 1),
(658, 8, 3, 4, 4, 1),
(659, 8, 3, 4, 6, 1),
(660, 8, 3, 4, 7, 1),
(661, 8, 3, 4, 5, 1),
(662, 8, 4, 3, 3, 1),
(663, 8, 4, 12, 3, 1),
(664, 8, 12, 7, 3, 1),
(665, 2, 1, 4, 1, 1),
(666, 2, 1, 4, 2, 1),
(667, 2, 1, 4, 3, 1),
(668, 2, 1, 4, 4, 1),
(669, 2, 1, 4, 6, 1),
(670, 2, 1, 4, 7, 1),
(671, 2, 1, 4, 5, 1);
