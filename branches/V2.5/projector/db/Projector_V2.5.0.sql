
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.5.0                                      //
-- // Date : 2012-08-08                                     //
-- ///////////////////////////////////////////////////////////
--
--

UPDATE `${prefix}menu` set idle=1 WHERE id=110;

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `idle`, `defaultValue`) VALUES
(120,1,'idTeam','teamList',5,0,null),
(121,2,'idTeam','teamList',5,0,null),
(122,3,'idTeam','teamList',5,0,null);
INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `idle`, `defaultValue`) VALUES
(123,28,'idTeam','teamList',5,0,null),
(124,29,'idTeam','teamList',5,0,null),
(125,30,'idTeam','teamList',5,0,null);
