-- ///////////////////////////////////////////////////////////////////////////////////////
-- // PROJECTOR SITE CONFIGURATION PLUGIN                                               //
-- // Conversion of some parameters related to the geographic location of the users.    //
-- // To execute ONCE after a fresh install of database.                                //
-- // Example for French users in the community.                                        //
-- // Good start for translation in other languages.                                    //
-- ///////////////////////////////////////////////////////////////////////////////////////

-- parameter (Parametres/Parametres globaux)
-- (Horaire de travail quotidien/heure de début - Matin, heure de fin - Matin, heure de début - Après-midi, heure de fin - Après-midi
-- UPDATE `${prefix}parameter` SET parameterValue='08:00' WHERE parameterCode='startAM';
-- UPDATE `${prefix}parameter` SET parameterValue='12:00' WHERE parameterCode='endAM';
UPDATE `${prefix}parameter` SET parameterValue='13:00' WHERE parameterCode='startPM';
UPDATE `${prefix}parameter` SET parameterValue='16:00' WHERE parameterCode='endPM';
UPDATE `${prefix}parameter` SET parameterValue='7' WHERE parameterCode='dayTime';
-- (Internationalisation/langue par défaut)
UPDATE `${prefix}parameter` SET parameterValue='fr-ca' WHERE parameterCode='paramDefaultLocale';
-- (Internationalisation/zone de fuseau horaire)
UPDATE `${prefix}parameter` SET parameterValue='America/Montreal' WHERE parameterCode='paramDefaultTimezone';
-- (Internationalisation/symbole monétaire)
UPDATE `${prefix}parameter` SET parameterValue='$' WHERE parameterCode='currency';
-- (Internationalisation/position du symbole monétaire)
-- UPDATE `${prefix}parameter` SET parameterValue='after' WHERE parameterCode='currencyPosition';

-- (Unité pour les charges/unité pour les imputations)
-- (Creeted in Class : GeneralWork.php into Methods : setImputationUnit, setWorkUnit)         
-- (Unité pour les charges/unité pour les charges)
UPDATE `${prefix}parameter` SET parameterValue = 'hours' WHERE parameterCode='imputationUnit';
-- (Unité pour les charges/nombre d'heures par jour)
UPDATE `${prefix}parameter` SET parameterValue = 'days' WHERE parameterCode='workUnit';
