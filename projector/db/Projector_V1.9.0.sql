
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.9.0                                      //
-- // Date : 2010-10-25                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'csvSeparator',';');

INSERT INTO TYPE (`scope`, `name`, `sortOrder`) VALUES
('Project', 'Operational', '10'),
('Project', 'Administrative', '20'),
('Project', 'Template', '30');

ALTER TABLE `${prefix}project` ADD idProjectType int(12) unsigned;
