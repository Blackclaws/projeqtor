
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.7.0                                      //
-- // Date : 2010-07-25                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}expense` ADD INDEX expenseProject (idProject),
ADD INDEX expenseType (idExpenseType),
ADD INDEX expenseUser (idUser),
ADD INDEX expenseResource (idResource),
ADD INDEX expenseStatus (idStatus),
ADD INDEX expenseDay (day),
ADD INDEX expenseWeek (week),
ADD INDEX expenseMonth (month),
ADD INDEX expenseYear (year);

ALTER TABLE `${prefix}expensedetail` ADD INDEX expensedetailProject (idProject),
ADD INDEX expensedetailType (idExpenseDetailType),
ADD INDEX expensedetailExpense (idExpense);

ALTER TABLE `${prefix}habilitationother` ADD INDEX habilitationotherProfile (idProfile);

ALTER TABLE `${prefix}list` ADD INDEX listList (list);

ALTER TABLE `${prefix}planningmode` ADD INDEX planningmodeApplyTo (applyTo);

ALTER TABLE `${prefix}resourcecost` ADD INDEX resourcecostResource (idResource);

ALTER TABLE `${prefix}user` ADD INDEX userIsResource (isResource),
ADD INDEX userIsUser (isUser),
ADD INDEX userIsContact (isContact);

CREATE TABLE `${prefix}calendar` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `isOffDay` int(1) unsigned DEFAULT '0',
  `calendarDate` date DEFAULT NULL,
  `day`  varchar(8),
  `week` varchar(6),
  `month` varchar(6),
  `year` varchar(4),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}calendar` ADD INDEX calendarDay (day),
ADD INDEX calendarWeek (week),
ADD INDEX calendarMonth (month),
ADD INDEX calendarYear (year);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(85, 'menuCalendar', 14, 'object', 685, Null, 1);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 85, 1),
(2, 85, 1),
(3, 85, 1);