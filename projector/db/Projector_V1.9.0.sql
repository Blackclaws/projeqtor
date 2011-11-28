
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.9.0                                      //
-- // Date : 2010-10-25                                     //
-- ///////////////////////////////////////////////////////////
--
--

DELETE FROM `${prefix}parameter` WHERE parameterCode='csvSeparator';
INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'csvSeparator',';');

ALTER TABLE `${prefix}type` ADD `code` varchar(10);

DELETE FROM `${prefix}type` WHERE scope='Project';
INSERT INTO `${prefix}type` (`scope`, `code`, `name`, `sortOrder`) VALUES
('Project', 'OPE', 'Fixed price', '10'),
('Project', 'OPE', 'Time & Materials', '20'),
('Project', 'OPE', 'Internal', '30'),
('Project', 'OPE', 'Mixed', '40'),
('Project', 'ADM', 'Administrative', '80'),
('Project', 'TMP', 'Template', '90');

ALTER TABLE `${prefix}project` ADD idProjectType int(12) unsigned,
ADD codeType varchar(10) default 'OPE';

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(93, 'menuProjectType', 79, 'object', 805, Null, 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 93, 1),
(2, 93, 1),
(3, 93, 1);

ALTER TABLE `${prefix}user` ADD initials varchar(10);

ALTER TABLE `${prefix}ticket` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}activity` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}milestone` ADD reference varchar(100),
ADD externalReference varchar(100);


ALTER TABLE `${prefix}expense` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}risk` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}action` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}issue` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}meeting` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}decision` ADD reference varchar(100),
ADD externalReference varchar(100);

ALTER TABLE `${prefix}question` ADD reference varchar(100),
ADD externalReference varchar(100);

UPDATE `${prefix}type` set code=UPPER(SUBSTRING(name,1,3))
WHERE code is null;

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'referenceFormatPrefix','{PROJ}-{TYPE}-'),
(null, null, 'changeReferenceOnTypeChange','NO');

ALTER TABLE `${prefix}version` ADD initialEisDate date,
ADD acutalEisDate date,
ADD realEiaDate date,
ADD initialEndDate date,
ADD plannedEndDate date,
ADD isEis int(1) unsigned default 0;