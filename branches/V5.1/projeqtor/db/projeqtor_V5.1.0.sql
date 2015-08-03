-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.1.0                                       //
-- // Date : 2015-07-30                                     //
-- ///////////////////////////////////////////////////////////

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(136, 'menuPlugin', 13, 'item', 977, NULL, 0, 'Admin ');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 136, 1),
(2, 136, 0),
(3, 136, 0),
(4, 136, 0),
(5, 136, 0),
(6, 136, 0),
(7, 136, 0);