-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.5.0                                       //
-- // Date : 2019-01-25                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}ImputationValidation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(204, 'menuImputationValidation', 7, 'item', 118, Null, 0, 'Work');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 204, 1),
(2, 204, 1),
(3, 204, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,204,8);