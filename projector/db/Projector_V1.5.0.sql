
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.5.0                                      //
-- // Date : 2010-12-08                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}affectation` ADD `idRole` int(12) unsigned DEFAULT null,
ADD `startDate` date DEFAULT null,
ADD `endDate` date DEFAULT null;

ALTER TABLE `${prefix}assignment` ADD `idRole` int(12) unsigned DEFAULT null,
ADD `dailyCost` NUMERIC(7,2) DEFAULT null,
ADD `newDailyCost` NUMERIC(7,2) DEFAULT null,
ADD `assignedCost` NUMERIC(11,2) DEFAULT null,
ADD `realCost` NUMERIC(11,2) DEFAULT null,
ADD `leftCost` NUMERIC(11,2) DEFAULT null,
ADD `plannedCost` NUMERIC(11,2) DEFAULT null;

ALTER TABLE `${prefix}work` ADD  `dailyCost` NUMERIC(7,2) DEFAULT null,
ADD `cost` NUMERIC(11,2) DEFAULT null;

ALTER TABLE `${prefix}plannedwork` ADD  `dailyCost` NUMERIC(7,2) DEFAULT null,
ADD `cost` NUMERIC(11,2) DEFAULT null;

ALTER TABLE `${prefix}user` ADD  `idRole` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}planningelement` ADD `initialCost` NUMERIC(11,2) DEFAULT null,
ADD `validatedCost` NUMERIC(11,2) DEFAULT null,
ADD `assignedCost` NUMERIC(11,2) DEFAULT null,
ADD `realCost` NUMERIC(11,2) DEFAULT null,
ADD `leftCost` NUMERIC(11,2) DEFAULT null,
ADD `plannedCost` NUMERIC(11,2) DEFAULT null;

UPDATE `${prefix}type` SET `name`='Steering Committee'
WHERE `scope`='Meeting' and `name`='Steering Comitee';

CREATE TABLE `${prefix}resourcecost` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idRole` int(12) unsigned DEFAULT NULL,
  `cost` NUMERIC(11,2) DEFAULT null,
  `startDate` date DEFAULT null,
  `endDate` date DEFAULT null,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}role` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(73, 'menuRole', 36, 'object', 931, Null, 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 73, 1);

INSERT INTO `${prefix}role` (`id`, `name`, `description`,`sortOrder`, `idle`) VALUES
(1,'Manager','Leader/Manager of the project',10,0),
(2,'Analyst','Responsible of specifications',20,0),
(3,'Developer','Sowftware developer',30,0),
(4,'Expert','Technical expert',40,0),
(5,'Machine','Non human resource',50,0);

CREATE TABLE `${prefix}visibilityscope` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `accessCode` varchar(3) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}visibilityscope` (`id`, `name`, `accessCode`, `sortOrder`, `idle`) VALUES
(1, 'visibilityScopeNo', 'NO', 100, 0),
(2, 'visibilityScopeValid', 'VAL', 200, 0),
(4, 'visibilityScopeAll', 'ALL', 400, 0);

INSERT INTO `${prefix}habilitationOther` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'work', 4),
(2, 'work', 4),
(3, 'work', 4),
(4, 'work', 4),
(6, 'work', 2),
(7, 'work', 1),
(5, 'work', 1),
(1, 'cost', 4),
(2, 'cost', 4),
(3, 'cost', 4),
(4, 'cost', 1),
(6, 'cost', 2),
(7, 'cost', 1),
(5, 'cost', 1);

ALTER TABLE `${prefix}ticket` ADD  `idContact` int(12) unsigned DEFAULT NULL;
