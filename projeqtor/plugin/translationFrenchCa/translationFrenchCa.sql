-- ///////////////////////////////////////////////////////////////////////////////
-- // PROJECTOR TRANSLATION PLUGIN                                              //
-- // Translation of some parameters related to the language used by the users. //
-- // To execute ONCE after a fresh install of database.                        //
-- // Example of French translation of values for parameters tables.            //
-- // Usefull for French users in the community.                                //
-- // Good start for translation in other languages.                            //
-- ///////////////////////////////////////////////////////////////////////////////

-- ======================================
-- ==   Message table                  ==
-- ======================================

-- message
-- ProjeQtOr-Québec is an example of a use of ProjeQtOr in a local project in a French language environment. 
UPDATE `${prefix}message` SET description='Bienvenue dans l''application ProjeQtOr', name='Bienvenue' WHERE id='1' AND name='Welcome';

-- =====================================
-- ==   Controles & Automatismes      ==
-- =====================================

-- workflow (Controles & Automatismes/Workflows)
UPDATE `${prefix}workflow` SET name='Défaut', description='Flux de travail par défaut avec seulement des contraintes logiques.
Tous peuvent modifier le statut.' WHERE name='Default';
UPDATE `${prefix}workflow` SET name='Simple', description='Flux de travail simple avec statut limité.
Tous peuvent modifier le statut.' WHERE name='Simple';
UPDATE `${prefix}workflow` SET name='Validation externe', description='Flux de travail élaboré avec traitement interne de l''équipe et validation externe.'
	WHERE name='External validation';
UPDATE `${prefix}workflow` SET name='Acceptation externe & validation', description='Flux de travail élaboré avec acceptation externe, traitement interne de l''équipe et validation externe.'
	WHERE name='External acceptation & validation';
UPDATE `${prefix}workflow` SET name='Simple avec validation', description='Flux de travail simple avec statut limité, incluant une validation.'
	WHERE name='Simple with validation';
UPDATE `${prefix}workflow` SET name='Validation', description='Flux de travail court avec seulement une validation ou une possibilité d''annulation.
Privilèges de validation restreints.' WHERE name='Validation';
UPDATE `${prefix}workflow` SET name='Simple avec préparation', description='Flux de travail simple avec statut limité, incluant la préparation.
Tous peuvent modifier le statut.' WHERE name='Simple with preparation';
UPDATE `${prefix}workflow` SET name='Simple avec validation du chargé de projet', description='Flux de travail simple avec statut limité, incluant la validation du chargé de projet.
Tous peuvent modifier le statut, exepté pour la vidation : réservée au chargé de projet.' WHERE name='Simple with Project Leader validation';


-- =====================================
-- ==   Parametres/Liste de valeurs   ==
-- =====================================

-- role (Parametres/Liste des valeurs/Fonctions)
UPDATE `${prefix}role` SET name='Chargé de projet', description='Responsable du projet (PMO)', sortOrder='80' WHERE name='Manager';
UPDATE `${prefix}role` SET name='Analyste', description='', sortOrder='20' WHERE name='Analyst';
UPDATE `${prefix}role` SET name='Développeur', description='', sortOrder='110' WHERE name='Developer';
UPDATE `${prefix}role` SET name='Expert', description='', sortOrder='130' WHERE name='Expert';
UPDATE `${prefix}role` SET name='Matériel', description='Ressource matérielle ex: serveur', sortOrder='140' WHERE name='Machine';
INSERT INTO role (name, description, sortOrder) VALUES ('Chef de service', '', '90');
INSERT INTO role (name, description, sortOrder) VALUES ('Directeur/trice principal', '', '120');
INSERT INTO role (name, description, sortOrder) VALUES ('Coordonnateur/trice', '', '100');
INSERT INTO role (name, description, sortOrder) VALUES ('Administrateur de base de données (DBA)', '', '10');
INSERT INTO role (name, description, sortOrder) VALUES ('Spécialiste externe', '', '160');
INSERT INTO role (name, description, sortOrder) VALUES ('Vice-président', '', '180');
INSERT INTO role (name, description, sortOrder) VALUES ('Responsable de la sécurité de l''information', '', '150');
INSERT INTO role (name, description, sortOrder) VALUES ('Architecte d''affaires', '', '40');
INSERT INTO role (name, description, sortOrder) VALUES ('Architecte technologique', '', '70');
INSERT INTO role (name, description, sortOrder) VALUES ('Architecte de données', '', '60');
INSERT INTO role (name, description, sortOrder) VALUES ('Architecte d''entreprise', '', '50');
INSERT INTO role (name, description, sortOrder) VALUES ('Analyste en processus', '', '30');
INSERT INTO role (name, description, sortOrder) VALUES ('Technicien', '', '170');

-- status (Parametres/Liste des valeurs/Etats)
UPDATE `${prefix}status` SET name='enregistrée' WHERE name='recorded';
UPDATE `${prefix}status` SET name='qualifiée' WHERE name='qualified';
UPDATE `${prefix}status` SET name='acceptée' WHERE name='accepted';
UPDATE `${prefix}status` SET name='ré-ouverte' WHERE name='re-opened';
UPDATE `${prefix}status` SET name='assignée' WHERE name='assigned';
UPDATE `${prefix}status` SET name='préparée' WHERE name='prepared';
UPDATE `${prefix}status` SET name='en cours' WHERE name='in progress';
UPDATE `${prefix}status` SET name='terminée' WHERE name='done';
UPDATE `${prefix}status` SET name='vérifiée' WHERE name='verified';
UPDATE `${prefix}status` SET name='livrée' WHERE name='delivered';
UPDATE `${prefix}status` SET name='validée' WHERE name='validated';
UPDATE `${prefix}status` SET name='fermée' WHERE name='closed';
UPDATE `${prefix}status` SET name='annulée' WHERE name='cancelled';

-- quality (Parametres/Liste des valeurs/Niveaux de qualité)
UPDATE `${prefix}quality` SET name='conforme' WHERE name='conform';
UPDATE `${prefix}quality` SET name='avec commentaires' WHERE name='some remarks';
UPDATE `${prefix}quality` SET name='non conforme' WHERE name='not conform';

-- health (Parametres/Liste des valeurs/Situations)
UPDATE `${prefix}health` SET name='sécurisé' WHERE name='secured';
UPDATE `${prefix}health` SET name='inspecté' WHERE name='surveyed';
UPDATE `${prefix}health` SET name='en danger' WHERE name='in danger';
UPDATE `${prefix}health` SET name='en échec' WHERE name='crashed';
UPDATE `${prefix}health` SET name='en pause' WHERE name='paused';

-- overallprogress (Parametres/Liste des valeurs/Avancement global)
INSERT INTO overallprogress (name, sortOrder) VALUES ('1%', '110');

-- trend (Parametres/Liste des valeurs/Tendances)
UPDATE `${prefix}trend` SET name='en augmentation' WHERE name='increasing';
UPDATE `${prefix}trend` SET name='stable' WHERE name='even';
UPDATE `${prefix}trend` SET name='en diminution' WHERE name='decreasing';

-- likelihood (Parametres/Liste des valeurs/Probabilités)
UPDATE `${prefix}likelihood` SET name='Basse (10%)' WHERE name='Low (10%)';
UPDATE `${prefix}likelihood` SET name='Moyenne (50%)' WHERE name='Medium (50%)';
UPDATE `${prefix}likelihood` SET name='Haute (90%)' WHERE name='High (90%)';

-- criticality (Parametres/Liste des valeurs/Criticités)
UPDATE `${prefix}criticality` SET name='Basse' WHERE name='Low';
UPDATE `${prefix}criticality` SET name='Moyenne' WHERE name='Medium';
UPDATE `${prefix}criticality` SET name='Haute' WHERE name='High';
UPDATE `${prefix}criticality` SET name='Critique' WHERE name='Critical';

-- severity (Parametres/Liste des valeurs/Sévérités)
UPDATE `${prefix}severity` SET name='Basse' WHERE name='Low';
UPDATE `${prefix}severity` SET name='Moyenne' WHERE name='Medium';
UPDATE `${prefix}severity` SET name='Haute' WHERE name='High';

-- urgency (Parametres/Liste des valeurs/Urgences)
UPDATE `${prefix}urgency` SET name='Blocage' WHERE name='Blocking';
-- UPDATE `${prefix}urgency` SET name='Urgent' WHERE name='Urgent';
UPDATE `${prefix}urgency` SET name='Non urgent' WHERE name='Not urgent';

-- priority (Parametres/Liste des valeurs/Priorités)
UPDATE `${prefix}priority` SET name='Basse' WHERE name='Low priority';
UPDATE `${prefix}priority` SET name='Moyenne' WHERE name='Medium priority';
UPDATE `${prefix}priority` SET name='Haute' WHERE name='High priority';
UPDATE `${prefix}priority` SET name='Critique' WHERE name='Critical priority';

-- risklevel (Parametres/Liste des valeurs/Niveaux de risque)
UPDATE `${prefix}risklevel` SET name='Très bas' WHERE name='Very Low';
UPDATE `${prefix}risklevel` SET name='Bas' WHERE name='Low';
UPDATE `${prefix}risklevel` SET name='Moyen' WHERE name='Average';
UPDATE `${prefix}risklevel` SET name='Haut' WHERE name='High';
UPDATE `${prefix}risklevel` SET name='Très haut' WHERE name='Very High';

-- feasibility (Parametres/Liste des valeurs/Faisabilités)
UPDATE `${prefix}feasibility` SET name='Oui' WHERE name='Yes';
UPDATE `${prefix}feasibility` SET name='Examiné' WHERE name='Investigate';
UPDATE `${prefix}feasibility` SET name='Non' WHERE name='No';

-- efficiency (Parametres/Liste des valeurs/Efficacités)
UPDATE `${prefix}efficiency` SET name='pleinement' WHERE name='fully efficient';
UPDATE `${prefix}efficiency` SET name='partiellement' WHERE name='partially efficient';
UPDATE `${prefix}efficiency` SET name='efficace' WHERE name='not efficient';


-- ======================================
-- ==   Parametres/Liste des types     ==
-- ======================================

-- type (Parametres/Liste des types/Types de projets)
UPDATE `${prefix}type` SET name='Prix fixe' WHERE scope='Project' AND name='Fixed Price';
UPDATE `${prefix}type` SET name='À la livraison' WHERE scope='Project' AND name='Time & Materials';
UPDATE `${prefix}type` SET name='Forfaitaire' WHERE scope='Project' AND name='Capped Time & Materials';
UPDATE `${prefix}type` SET name='Interne' WHERE scope='Project' AND name='Internal';
UPDATE `${prefix}type` SET name='Administratif' WHERE scope='Project' AND name='Administrative';
UPDATE `${prefix}type` SET name='Gabarit' WHERE scope='Project' AND name='Template';

-- ticket (Parametres/Liste des types/Types de tickets)
UPDATE `${prefix}type` SET name='Incident' WHERE scope='Ticket' AND name='Incident';
UPDATE `${prefix}type` SET name='Soutien / Assistance' WHERE scope='Ticket' AND name='Assistance';
UPDATE `${prefix}type` SET name='Anomalie / Bogue' WHERE scope='Ticket' AND name='Anomaly / Bug';

-- type (Parametres/Liste des types/Types d'activités)
UPDATE `${prefix}type` SET name='Développement' WHERE scope='Activity' AND name='Development';
UPDATE `${prefix}type` SET name='Évolution' WHERE scope='Activity' AND name='Evolution';
UPDATE `${prefix}type` SET name='Gestion' WHERE scope='Activity' AND name='Management';
-- UPDATE `${prefix}type` SET name='Phase' WHERE scope='Activity' AND name='Phase';
UPDATE `${prefix}type` SET name='Tâche' WHERE scope='Activity' AND name='Task';

-- type (Parametres/Liste des types/Types de jalons)
UPDATE `${prefix}type` SET name='Livrable' WHERE scope='Milestone' AND name='Deliverable';
UPDATE `${prefix}type` SET name='À venir' WHERE scope='Milestone' AND name='Incoming';
UPDATE `${prefix}type` SET name='Date fixe' WHERE scope='Milestone' AND name='Key date';

-- type (Parametres/Liste des types/Types de devis)
UPDATE `${prefix}type` SET name='Prix fixe' WHERE scope='Quotation' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='Par jour' WHERE scope='Quotation' AND name='Per day';
UPDATE `${prefix}type` SET name='Par mois' WHERE scope='Quotation' AND name='Per month';
UPDATE `${prefix}type` SET name='Par année' WHERE scope='Quotation' AND name='Per year';

-- type (Parametres/Liste des types/Types de commandes)
UPDATE `${prefix}type` SET name='Prix fixe' WHERE scope='Command' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='Par jour' WHERE scope='Command' AND name='Per day';
UPDATE `${prefix}type` SET name='Par mois' WHERE scope='Command' AND name='Per month';
UPDATE `${prefix}type` SET name='Par année' WHERE scope='Command' AND name='Per year';

-- type (Parametres/Liste des types/Types de dépenses individuelles)
UPDATE `${prefix}type` SET name='Rapport de dépenses' WHERE scope='IndividualExpense' AND name='Expense report';

-- type (Parametres/Liste des types/Types de dépenses projet)
UPDATE `${prefix}type` SET name='Frais d''équipement' WHERE scope='ProjectExpense' AND name='Machine expense';
UPDATE `${prefix}type` SET name='Frais de bureau' WHERE scope='ProjectExpense' AND name='Office expense';

-- expensedetailtype (Parametres/Liste des types/Types de détails de dépenses)
UPDATE `${prefix}expensedetailtype` SET name='Voyage par auto' WHERE name='travel by car';
UPDATE `${prefix}expensedetailtype` SET name='Voyage par auto continuité' WHERE name='regular mission car travel';
UPDATE `${prefix}expensedetailtype` SET name='Frais de repas' WHERE name='lunch for guests';
UPDATE `${prefix}expensedetailtype` SET name='Frais justifié' WHERE name='justified expense';

-- type (Parametres/Liste des types/Types de factures)
UPDATE `${prefix}type` SET name='Facture partielle' WHERE scope='Bill' AND name='Partial bill';
UPDATE `${prefix}type` SET name='Facture finale' WHERE scope='Bill' AND name='Final bill';
UPDATE `${prefix}type` SET name='Facture complète' WHERE scope='Bill' AND name='Complete bill';

-- type (Parametres/Liste des types/Types de risques)
UPDATE `${prefix}type` SET name='Contractuel' WHERE scope='Risk' AND name='Contractual';
UPDATE `${prefix}type` SET name='Opérationnel' WHERE scope='Risk' AND name='Operational';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Risk' AND name='Technical';

-- type (Parametres/Liste des types/Types d'opportunités)
UPDATE `${prefix}type` SET name='Contractuel' WHERE scope='Opportunity' AND name='Contractual';
UPDATE `${prefix}type` SET name='Opérationnel' WHERE scope='Opportunity' AND name='Operational';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Opportunity' AND name='Technical';

-- type (Parametres/Liste des types/Types d'actions)
UPDATE `${prefix}type` SET name='Projet' WHERE scope='Action' AND name='Project';
UPDATE `${prefix}type` SET name='Interne' WHERE scope='Action' AND name='Internal';
UPDATE `${prefix}type` SET name='Client' WHERE scope='Action' AND name='Customer';

-- type (Parametres/Liste des types/Types de problèmes)
UPDATE `${prefix}type` SET name='Problème technique' WHERE scope='Issue' AND name='Technical issue';
UPDATE `${prefix}type` SET name='Processus non conforme' WHERE scope='Issue' AND name='Process non conformity';
UPDATE `${prefix}type` SET name='Qualité non conforme' WHERE scope='Issue' AND name='Quality non conformity';
UPDATE `${prefix}type` SET name='Processus non applicable' WHERE scope='Issue' AND name='Process non appliability';
UPDATE `${prefix}type` SET name='Plainte de la clientèle' WHERE scope='Issue' AND name='Customer complaint';
UPDATE `${prefix}type` SET name='Délai non respecté' WHERE scope='Issue' AND name='Delay non respect';
UPDATE `${prefix}type` SET name='Problème de gestion de ressources' WHERE scope='Issue' AND name='Resource management issue';
UPDATE `${prefix}type` SET name='Perte financière' WHERE scope='Issue' AND name='Financial loss';

-- type (Parametres/Liste des types/Types de réunions)
UPDATE `${prefix}type` SET name='Comité de direction' WHERE scope='Meeting' AND name='Steering Committee';
UPDATE `${prefix}type` SET name='Rencontre de suivi' WHERE scope='Meeting' AND name='Progress Metting';
UPDATE `${prefix}type` SET name='Rencontre d''équipe' WHERE scope='Meeting' AND name='Team Meeting';

-- type (Parametres/Liste des types/Types de décisions)
UPDATE `${prefix}type` SET name='Fonctionnelle' WHERE scope='Decision' AND name='Functional';
UPDATE `${prefix}type` SET name='Opérationnelle' WHERE scope='Decision' AND name='Operational';
UPDATE `${prefix}type` SET name='Contractuelle' WHERE scope='Decision' AND name='Contractual';
UPDATE `${prefix}type` SET name='Stratégique' WHERE scope='Decision' AND name='Strategic';

-- type (Parametres/Liste des types/Types de questions)
UPDATE `${prefix}type` SET name='Fonctionnelle' WHERE scope='Question' AND name='Functional';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Question' AND name='Technical';

-- type (Parametres/Liste des types/Types de messages)
UPDATE `${prefix}type` SET name='ALERTE' WHERE scope='Message' AND name='ALERT';
UPDATE `${prefix}type` SET name='AVERTISSEMENT' WHERE scope='Message' AND name='WARNING';
UPDATE `${prefix}type` SET name='INFORMATION' WHERE scope='Message' AND name='INFO';

-- type (Parametres/Liste des types/Types de documents)
UPDATE `${prefix}type` SET name='Besoin d''information' WHERE scope='Document' AND name='Need expression';
UPDATE `${prefix}type` SET name='Spécifications générales' WHERE scope='Document' AND name='General Specification';
UPDATE `${prefix}type` SET name='Spécifications détaillées' WHERE scope='Document' AND name='Detailed Specification';
UPDATE `${prefix}type` SET name='Conception générale' WHERE scope='Document' AND name='General Conception';
UPDATE `${prefix}type` SET name='Conception détaillée' WHERE scope='Document' AND name='Detail Conception';
UPDATE `${prefix}type` SET name='Plan de test' WHERE scope='Document' AND name='Test Plan';
UPDATE `${prefix}type` SET name='Manuel d''installation' WHERE scope='Document' AND name='Installaton manual';
UPDATE `${prefix}type` SET name='Manuel d''exploitation' WHERE scope='Document' AND name='Exploitation manual';
UPDATE `${prefix}type` SET name='Manuel de l''utilisateur' WHERE scope='Document' AND name='User manual';
UPDATE `${prefix}type` SET name='Contrat' WHERE scope='Document' AND name='Contract';
UPDATE `${prefix}type` SET name='Gestion' WHERE scope='Document' AND name='Management';
UPDATE `${prefix}type` SET name='Réunion de révision' WHERE scope='Document' AND name='Meeting Review';
UPDATE `${prefix}type` SET name='Suivi' WHERE scope='Document' AND name='Follow-up';
UPDATE `${prefix}type` SET name='Financier' WHERE scope='Document' AND name='Financial';

-- type (Parametres/Liste des types/Types de contextes)
UPDATE `${prefix}contexttype` SET name='Environnement' WHERE name='environment';
UPDATE `${prefix}contexttype` SET name='Système d''exploitation' WHERE name='OS';
UPDATE `${prefix}contexttype` SET name='Navigateur' WHERE name='browser';

-- type (Parametres/Liste des types/Types d'exigences)
UPDATE `${prefix}type` SET name='Fonctionnelle' WHERE scope='Requirement' AND name='Functional';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Requirement' AND name='Technical';
UPDATE `${prefix}type` SET name='Sécurité' WHERE scope='Requirement' AND name='Security';
UPDATE `${prefix}type` SET name='Réglementation' WHERE scope='Requirement' AND name='Regulatory';

-- type (Parametres/Liste des types/Types de cas de test)
UPDATE `${prefix}type` SET name='Exigence de test' WHERE scope='TestCase' AND name='Requirement test';
UPDATE `${prefix}type` SET name='Essai unitaire' WHERE scope='TestCase' AND name='Unit test';
UPDATE `${prefix}type` SET name='Non régression' WHERE scope='TestCase' AND name='Non regression';

-- type (Parametres/Liste des types/Types de sessions de test)
UPDATE `${prefix}type` SET name='Session de tests évolutifs' WHERE scope='TestSession' AND name='Evolution test session';
UPDATE `${prefix}type` SET name='Session de tests de développement' WHERE scope='TestSession' AND name='Development test session';
UPDATE `${prefix}type` SET name='Session de tests de non régression' WHERE scope='TestSession' AND name='Non regression test session';
UPDATE `${prefix}type` SET name='Session de tests d''essais unitaires' WHERE scope='TestSession' AND name='Unitary case test session';

-- type (Parametres/Liste des types/Types de clients)
UPDATE `${prefix}type` SET name='Prospect d''affaires', sortOrder='50', description='Client potentiel' WHERE scope='Client' AND name='business prospect';
UPDATE `${prefix}type` SET name='Ministère et organisme', sortOrder='30', description='MO au gouvernement du Québec' WHERE scope='Client' AND name='customer';
INSERT INTO type (name, sortOrder, description) VALUES ('Externe / expertise', '', '10');
INSERT INTO type (name, sortOrder, description) VALUES ('Externe / formation', '', '20');
INSERT INTO type (name, sortOrder, description) VALUES ('Para-public / formation', '', '40');

-- profile (Parametres/Habilitations/Profils)
UPDATE `${prefix}profile` SET description='Peut voir tous les projets' WHERE name='profileAdministrator' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Peut voir tous les projets' WHERE name='profileSupervisor' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Gère ses propres projets' WHERE name='profileProjectLeader' AND description='Leads his owns project';
UPDATE `${prefix}profile` SET description='Travaille dans un projet' WHERE name='profileTeamMember' AND description='Works for a project';
UPDATE `${prefix}profile` SET description='A une visibilité limitée dans un projet' WHERE name='profileGuest' AND description='Has limited visibility to a project';
-- UPDATE `${prefix}profile` SET description='' WHERE name='profileExternalProjectLeader' AND description='Has a visibility over all the projects';
-- UPDATE `${prefix}profile` SET description='' WHERE name='profileExternalTeamMember' AND description='Has a visibility over all the projects';

-- accessprofile (Parametres/Habilitations/Modes d'accès)
UPDATE `${prefix}accessprofile` SET description='Lecture seule sur les éléments de ses projets' WHERE name='accessProfileRestrictedReader';
UPDATE `${prefix}accessprofile` SET description='Lecture seule sur les éléments de tous les projets' WHERE name='accessProfileGlobalReader';
UPDATE `${prefix}accessprofile` SET description='Lecture et mise à jour sur les éléments de ses projets' WHERE name='accessProfileRestrictedUpdater';
UPDATE `${prefix}accessprofile` SET description='Lecture et mise à jour sur les éléments de tous les projets' WHERE name='accessProfileGlobalUpdater';
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

-- parameter (Parametres/Administration/Gestion des connexions)
-- (message fermeture)
UPDATE `${prefix}parameter` SET parameterValue='L''application est fermée.
Seul l''administrateur peut se connecter.
SVP Revenez plus tard.' WHERE parameterCode='msgClosedApplication';


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
