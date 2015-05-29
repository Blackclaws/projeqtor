-- ///////////////////////////////////////////////////////////////////////////////////////
-- // PROJECTOR SITE CONFIGURATION PLUGIN                                               //
-- // Conversion of some parameters related to the geographic location of the users.    //
-- // To execute ONCE after a fresh install of database.                                //
-- // Example for French users in the community.                                        //
-- // Good start for translation in other languages.                                    //
-- ///////////////////////////////////////////////////////////////////////////////////////


-- parameter (Parametres/Administration/Gestion des connexions)
-- (message fermeture)
UPDATE `${prefix}parameter` SET parameterValue='L''application est fermée.
Seul l''administrateur peut se connecter.
SVP Revenez plus tard.' WHERE parameterCode='msgClosedApplication';


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


-- Autres messages de l'application
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Vous êtes l''approbateur de <a href="${url}" > Document #${id}</a> : "${name}".<br/>Veuillez accéder <a href="${url}" >ce document</a> et suivre le processus d''approbation.' WHERE parameterCode='paramMailBodyApprover';
UPDATE `${prefix}parameter` SET parameterValue='Bienvenue dans ${dbName} à <a href="${url}">${url}</a>.<br/>Votre code utilisateur est <b>${login}</b>.<br/>Votre mot de passe est initialisé à <b>${password}</b><br/>Vous devrez le modifier à la première connexion.<br/><br/>En cas de problème, contactez votre administrateur à <b>${adminMail}</b>.' WHERE parameterCode='paramMailBodyUser';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${item} #${id} a été modifié : "${name}"' WHERE parameterCode='paramMailTitleAnyChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] message from ${sender} : Vous devez approuver un document' WHERE parameterCode='paramMailTitleApprover';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une nouvelle affectation a été ajoutée à ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAssignment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une affectation a été modifiée à ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAssignmentChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une nouvelle pièce a été transmise à ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAttachment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] La description a été modifiée à ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleDescription';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] le message de ${sender} : ${item} #${id}' WHERE parameterCode='paramMailTitleDirect';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${item} #${id} a été créé : "${name}"' WHERE parameterCode='paramMailTitleNew';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une nouvelle note a été transmise à ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNote';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une note a été modifiée pour ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNoteChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${responsible} est maintenant responsable de ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleResponsible';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Le résultat a été modifié pour ${item} #${id} : "${name}' WHERE parameterCode='paramMailTitleResult';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${item} #${id} modifié au statut ${status} : ${name}' WHERE parameterCode='paramMailTitleStatus';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] message de ${sender} : L''information de votre compte' WHERE parameterCode='paramMailTitleUser';

