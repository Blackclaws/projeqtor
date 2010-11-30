
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.5.0                           //
-- // Date : 2010-11-29                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}affectation` ADD `dailyCost` number(7,2) DEFAULT null,
ADD `startDate` date DEFAULT null,
ADD `endDate` date DEFAULT null;

ALTER TABLE `${prefix}assignement` ADD `assignedCost` number(11,2) DEFAULT null,
ADD `realCost` number(11,2) DEFAULT null,
ADD `leftCost` number(11,2) DEFAULT null,
ADD `plannedCost` number(11,2) DEFAULT null;

ALTER TABLE `${prefix}work` ADD  `dailyCost` number(7,2) DEFAULT null,
`cost` number(11,2) DEFAULT null;

ALTER TABLE `${prefix}plannedwork` ADD  `dailyCost` number(7,2) DEFAULT null,
`cost` number(11,2) DEFAULT null;

ALTER TABLE `${prefix}planningelement` ADD `InitialCost` number(11,2) DEFAULT null,
ADD `validatedCost` number(11,2) DEFAULT null,
ADD `assignedCost` number(11,2) DEFAULT null,
ADD `realCost` number(11,2) DEFAULT null,
ADD `leftCost` number(11,2) DEFAULT null,
ADD `plannedCost` number(11,2) DEFAULT null;