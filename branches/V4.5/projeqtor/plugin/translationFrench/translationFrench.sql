-- ///////////////////////////////////////////////////////////
-- // PROJECTOR TRANSLATION PLUGIN                          //
-- ///////////////////////////////////////////////////////////

-- Access Profile 
UPDATE `${prefix}accessprofile` SET description='Lecture seule sur les éléments de ses projets' WHERE name='accessProfileRestrictedReader';
UPDATE `${prefix}accessprofile` SET description='Lecture seule sur les éléments de tous les projets' WHERE name='accessProfileGlobalReader';
UPDATE `${prefix}accessprofile` SET description='Lecture et mise à jour sur les éléments de ses projets' WHERE name='accessProfileRestrictedUpdater';
UPDATE `${prefix}accessprofile` SET description='Lecture  et mise à jour sur les éléments de tous les projets' WHERE name='accessProfileGlobalUpdater';
UPDATE `${prefix}accessprofile` SET description='Lecture uniquement sur les éléments de ses projets
Creation possible
Mise à jour et suppression sur ses propres éléments' WHERE name='accessProfileRestrictedCreator';
UPDATE `${prefix}accessprofile` SET description='Lecture sur les éléments de tous les projets
Creation possible
Mise à jour et suppression sur ses propres éléments' WHERE name='accessProfileGlobalCreator';
UPDATE `${prefix}accessprofile` SET description='Lecture uniquement sur les éléments de ses projets
Creation possible
Mise à jour et suppression sur les éléments de ses projets' WHERE name='accessProfileRestrictedManager';
UPDATE `${prefix}accessprofile` SET description='Lecture sur les éléments de tous les projets
Creation possible
Mise à jour et suppression sur les éléments de ses projets' WHERE name='accessProfileGlobalManager';
UPDATE `${prefix}accessprofile` SET description='Aucun accès autorisé' WHERE name='accessProfileNoAccess';
UPDATE `${prefix}accessprofile` SET description='Lecture uniquement sur les éléments pour lesquels il est déclaré comme créateur
Creation impossible' WHERE name='accessReadOwnOnly';

-- status