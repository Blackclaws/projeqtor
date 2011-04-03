
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.6.0                                      //
-- // Date : 2010-02-21                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}work` CHANGE `work` `work` DECIMAL( 5, 2 ) UNSIGNED NULL DEFAULT NULL;

CREATE TABLE `${prefix}list` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `list` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}list` (`id`, `list`, `name`, `code`, `sortOrder`, `idle`) VALUES
(1, 'yesNo', 'displayYes', 'YES', 20, 0),
(2, 'yesNo', 'displayNo', 'NO', 10, 0);

INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'combo', 1),
(2, 'combo', 2),
(3, 'combo', 1),
(4, 'combo', 2),
(6, 'combo', 2),
(7, 'combo', 2),
(5, 'combo', 2);

CREATE TABLE `${prefix}expense` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT null, 
  `idResource` int(12) unsigned DEFAULT null, 
  `idExpenseType` int(12) unsigned DEFAULT null,  
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `expensePlannedDate` date DEFAULT null,
  `expenseRealDate` date DEFAULT null,
  `plannedAmount` NUMERIC(11,2) DEFAULT null,
  `realAmount` NUMERIC(11,2) DEFAULT null,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}expenseDetail` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT null, 
  `idExpense` int(12) unsigned DEFAULT null, 
  `expenseDate` date DEFAULT null, 
  `idExpenseDetailType` int(12) unsigned DEFAULT null, 
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `expenseDate` date DEFAULT null, 
  `amount` NUMERIC(11,2) DEFAULT null,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

UPDATE MENU SET sortOrder=600 where id=13;
UPDATE MENU SET sortOrder=610 where id=14;
UPDATE MENU SET sortOrder=620 where id=15;
UPDATE MENU SET sortOrder=630 where id=72;
UPDATE MENU SET sortOrder=640 where id=16;
UPDATE MENU SET sortOrder=650 where id=17;
UPDATE MENU SET sortOrder=660 where id=57;
UPDATE MENU SET sortOrder=670 where id=44;
UPDATE MENU SET sortOrder=680 where id=50;
UPDATE MENU SET sortOrder=690 where id=36;
UPDATE MENU SET sortOrder=700 where id=73;
UPDATE MENU SET sortOrder=710 where id=34;
UPDATE MENU SET sortOrder=720 where id=38;
UPDATE MENU SET sortOrder=730 where id=40;
UPDATE MENU SET sortOrder=740 where id=38;
UPDATE MENU SET sortOrder=750 where id=42;
UPDATE MENU SET sortOrder=760 where id=41;
UPDATE MENU SET sortOrder=770 where id=59;
UPDATE MENU SET sortOrder=780 where id=68;
UPDATE MENU SET sortOrder=810, idMenu=79 where id=53;
UPDATE MENU SET sortOrder=820, idMenu=79 where id=55;
UPDATE MENU SET sortOrder=830, idMenu=79 where id=56;
UPDATE MENU SET sortOrder=880, idMenu=79 where id=45;
UPDATE MENU SET sortOrder=890, idMenu=79 where id=60;
UPDATE MENU SET sortOrder=900, idMenu=79 where id=46;
UPDATE MENU SET sortOrder=910, idMenu=79 where id=65;
UPDATE MENU SET sortOrder=920, idMenu=79 where id=66;
UPDATE MENU SET sortOrder=930, idMenu=79 where id=67;
UPDATE MENU SET sortOrder=940, idMenu=79 where id=52;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(74, 'menuFinancial', 0, 'menu', 250, Null, 0),
(75, 'menuIndividualExpense', 74, 'object', 255, 'project', 0),
(76, 'menuProjectExpense', 74, 'object', 260, 'project', 0),
(77, 'menuInvoice', 74, 'object', 265, 'project', 0),
(78, 'menuPayment', 74, 'object', 270, 'project', 0),
(79, 'menuType', 14, 'object', 800, null, 0),
(80, 'menuIndividualExpenseType', 79, 'object', 840, 'project', 0),
(81, 'menuProjectExpenseType', 79, 'object', 850, null, 0),
(82, 'menuInvoiceType', 79, 'object', 860, null, 0),
(83, 'menuPaymentType', 79, 'object', 870, null, 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 74, 1),
(2, 74, 1),
(3, 74, 1),
(1, 75, 1),
(2, 75, 1),
(3, 75, 1),
(4, 75, 1),
(1, 76, 1),
(2, 76, 1),
(3, 76, 1),
(1, 77, 1),
(2, 77, 1),
(3, 77, 1),
(1, 78, 1),
(2, 78, 1),
(3, 78, 1),
(1, 80, 1),
(2, 80, 1),
(1, 81, 1),
(2, 81, 1),
(1, 82, 1),
(2, 82, 1),
(1, 83, 1),
(2, 83, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1, 75, 8),
(2, 75, 2),
(3, 75, 7),
(4, 75, 5),
(6, 75, 9),
(7, 75, 9),
(5, 75, 9),
(1, 76, 8),
(2, 76, 2),
(3, 76, 7),
(4, 76, 9),
(6, 76, 9),
(7, 76, 9),
(5, 76, 9),
(1, 77, 8),
(2, 77, 2),
(3, 77, 7),
(4, 77, 9),
(6, 77, 9),
(7, 77, 9),
(5, 77, 9),
(1, 78, 8),
(2, 78, 2),
(3, 78, 7),
(4, 78, 9),
(6, 78, 9),
(7, 78, 9),
(5, 78, 9);

