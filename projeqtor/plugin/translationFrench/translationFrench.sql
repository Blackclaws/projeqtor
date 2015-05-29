-- ///////////////////////////////////////////////////////////////////////////////
-- // PROJECTOR TRANSLATION PLUGIN                                              //
-- // Translation of some parameters related to the language used by the users. //
-- // To execute ONCE after a fresh install of database.                        //
-- // Example of French translation of values for parameters tables.            //
-- // Usefull for French users.                                                 //
-- // Good start for translation in other languages.                            //
-- ///////////////////////////////////////////////////////////////////////////////

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

-- ContextType
UPDATE `${prefix}contexttype` SET name='Environnement' WHERE name='environment';
UPDATE `${prefix}contexttype` SET name='Système d''exploitation' WHERE name='OS';
UPDATE `${prefix}contexttype` SET name='Navigateur' WHERE name='browser';

-- Criticality
UPDATE `${prefix}criticality` SET name='Basse' WHERE name='Low';
UPDATE `${prefix}criticality` SET name='Moyenne' WHERE name='Medium';
UPDATE `${prefix}criticality` SET name='Haute' WHERE name='High';
UPDATE `${prefix}criticality` SET name='Critique' WHERE name='Critical';

-- Efficiency
UPDATE `${prefix}efficiency` SET name='totalement efficace' WHERE name='fully efficient';
UPDATE `${prefix}efficiency` SET name='partiellement efficace' WHERE name='partially efficient';
UPDATE `${prefix}efficiency` SET name='innefficace' WHERE name='not efficient';

-- ExpenseDatailType
UPDATE `${prefix}expensedetailtype` SET name='Voyage en voiture' WHERE name='travel by car';
UPDATE `${prefix}expensedetailtype` SET name='Voyage réccurent en voiture', unit01='jours', unit02='km/jour' WHERE name='regular mission car travel';
UPDATE `${prefix}expensedetailtype` SET name='Frais de repas', unit01='invités', unit02='€ par invité' WHERE name='lunch for guests';
UPDATE `${prefix}expensedetailtype` SET name='Frais sur justificatif' WHERE name='justified expense';
UPDATE `${prefix}expensedetailtype` SET name='Autres', unit01='unités', unit02='€ par unité' WHERE name='detail';

-- Feasibility
UPDATE `${prefix}feasibility` SET name='Faisable' WHERE name='Yes';
UPDATE `${prefix}feasibility` SET name='A analyser' WHERE name='Investigate';
UPDATE `${prefix}feasibility` SET name='Non faisable' WHERE name='No';

-- Health
UPDATE `${prefix}health` SET name='sécurisé' WHERE name='secured';
UPDATE `${prefix}health` SET name='surveillé' WHERE name='surveyed';
UPDATE `${prefix}health` SET name='en danger' WHERE name='in danger';
UPDATE `${prefix}health` SET name='en échec' WHERE name='crashed';
UPDATE `${prefix}health` SET name='en pause' WHERE name='paused';

-- Likelihood
UPDATE `${prefix}likelihood` SET name='Basse (10%)' WHERE name='Low (10%)';
UPDATE `${prefix}likelihood` SET name='Moyenne (50%)' WHERE name='Medium (50%)';
UPDATE `${prefix}likelihood` SET name='Haute (90%)' WHERE name='High (90%)';

-- Message 
UPDATE `${prefix}message` SET description='Bienvenue dans l''application ProjeQtOr' WHERE description='Welcome to ProjectOr web application';

-- Priority
UPDATE `${prefix}priority` SET name='Basse' WHERE name='Low priority';
UPDATE `${prefix}priority` SET name='Moyenne' WHERE name='Medium priority';
UPDATE `${prefix}priority` SET name='Haute' WHERE name='High priority';
UPDATE `${prefix}priority` SET name='Critique' WHERE name='Critical priority';

-- Profile
UPDATE `${prefix}profile` SET description='Peut voir et modifier tous les projets' WHERE name='profileAdministrator' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Peut voir tous les projets mais fait peu de mises à jour' WHERE name='profileSupervisor' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Gère ses propres projets' WHERE name='profileProjectLeader' AND description='Leads his owns project';
UPDATE `${prefix}profile` SET description='Travaille sur les projets auxquels il est affecté' WHERE name='profileTeamMember' AND description='Works for a project';
UPDATE `${prefix}profile` SET description='A une visibilité limitée sur les projets auxquels il est affecté' WHERE name='profileGuest' AND description ='Has limited visibility to a project';
UPDATE `${prefix}profile` SET description='A une visibilité limitée sur les projets auxquels il est affecté. Peut valider certaines étapes.' WHERE name='profileExternalProjectLeader' AND description is null;
UPDATE `${prefix}profile` SET description='A une visibilité limitée sur les projets auxquels il est affecté. Peut créer des tickets.' WHERE name='profileExternalTeamMember' AND description is null;

-- Quality
UPDATE `${prefix}quality` SET name='conforme' WHERE name='conform';
UPDATE `${prefix}quality` SET name='avec commentaires' WHERE name='some remarks';
UPDATE `${prefix}quality` SET name='non conforme' WHERE name='not conform';

-- Risklevel
UPDATE `${prefix}risklevel` SET name='Très bas' WHERE name='Very Low';
UPDATE `${prefix}risklevel` SET name='Bas' WHERE name='Low';
UPDATE `${prefix}risklevel` SET name='Moyen' WHERE name='Average';
UPDATE `${prefix}risklevel` SET name='Haut' WHERE name='High';
UPDATE `${prefix}risklevel` SET name='Très haut' WHERE name='Very High';

-- Role
UPDATE `${prefix}role` SET name='Chef de projet', description='Responsable du projet (PMO)', sortOrder='80' WHERE name='Manager';
UPDATE `${prefix}role` SET name='Analyste', description='', sortOrder='20' WHERE name='Analyst';
UPDATE `${prefix}role` SET name='Développeur', description='', sortOrder='110' WHERE name='Developer';
UPDATE `${prefix}role` SET name='Expert', description='', sortOrder='130' WHERE name='Expert';
UPDATE `${prefix}role` SET name='Matériel', description='Ressource matérielle ex: serveur', sortOrder='140' WHERE name='Machine';

-- Severity
UPDATE `${prefix}severity` SET name='Basse' WHERE name='Low';
UPDATE `${prefix}severity` SET name='Moyenne' WHERE name='Medium';
UPDATE `${prefix}severity` SET name='Haute' WHERE name='High';

-- Status
UPDATE `${prefix}status` SET name='enregistré' WHERE name='recorded';
UPDATE `${prefix}status` SET name='qualifié' WHERE name='qualified';
UPDATE `${prefix}status` SET name='accepté' WHERE name='accepted';
UPDATE `${prefix}status` SET name='ré-ouvert' WHERE name='re-opened';
UPDATE `${prefix}status` SET name='assigné' WHERE name='assigned';
UPDATE `${prefix}status` SET name='préparé' WHERE name='prepared';
UPDATE `${prefix}status` SET name='en cours' WHERE name='in progress';
UPDATE `${prefix}status` SET name='terminé' WHERE name='done';
UPDATE `${prefix}status` SET name='vérifié' WHERE name='verified';
UPDATE `${prefix}status` SET name='livré' WHERE name='delivered';
UPDATE `${prefix}status` SET name='validé' WHERE name='validated';
UPDATE `${prefix}status` SET name='fermé' WHERE name='closed';
UPDATE `${prefix}status` SET name='annulé' WHERE name='cancelled';

-- Trend
UPDATE `${prefix}trend` SET name='en augmentation' WHERE name='increasing';
UPDATE `${prefix}trend` SET name='stable' WHERE name='even';
UPDATE `${prefix}trend` SET name='en diminution' WHERE name='decreasing';


-- Type
UPDATE `${prefix}type` SET name='Forfait' WHERE scope='Project' AND name='Fixed Price';
UPDATE `${prefix}type` SET name='Régie' WHERE scope='Project' AND name='Time & Materials';
UPDATE `${prefix}type` SET name='Régie forfaitisée' WHERE scope='Project' AND name='Capped Time & Materials';
UPDATE `${prefix}type` SET name='Interne' WHERE scope='Project' AND name='Internal';
UPDATE `${prefix}type` SET name='Administratif' WHERE scope='Project' AND name='Administrative';
UPDATE `${prefix}type` SET name='Modèle' WHERE scope='Project' AND name='Template';
UPDATE `${prefix}type` SET name='Incident' WHERE name='Incident';
UPDATE `${prefix}type` SET name='Support' WHERE name='Support / Assistance';
UPDATE `${prefix}type` SET name='Anomalie' WHERE name='Anomaly / Bug';
UPDATE `${prefix}type` SET name='Développement' WHERE scope='Activity' AND name='Development';
UPDATE `${prefix}type` SET name='Évolution' WHERE scope='Activity' AND name='Evolution';
UPDATE `${prefix}type` SET name='Gestion' WHERE scope='Activity' AND name='Management';
UPDATE `${prefix}type` SET name='Phase' WHERE scope='Activity' AND name='Phase';
UPDATE `${prefix}type` SET name='Tâche' WHERE scope='Activity' AND name='Task';
UPDATE `${prefix}type` SET name='Livrable' WHERE scope='Milestone' AND name='Deliverable';
UPDATE `${prefix}type` SET name='Entrant' WHERE scope='Milestone' AND name='Incoming';
UPDATE `${prefix}type` SET name='Date clé' WHERE scope='Milestone' AND name='Key date';
UPDATE `${prefix}type` SET name='Forfait' WHERE scope='Quotation' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='A la journée' WHERE scope='Quotation' AND name='Per day';
UPDATE `${prefix}type` SET name='Contrat mensuel' WHERE scope='Quotation' AND name='Per month';
UPDATE `${prefix}type` SET name='Contrat Annuel' WHERE scope='Quotation' AND name='Per year';
UPDATE `${prefix}type` SET name='Forfait' WHERE scope='Command' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='A la journée' WHERE scope='Command' AND name='Per day';
UPDATE `${prefix}type` SET name='Contrat mensuel' WHERE scope='Command' AND name='Per month';
UPDATE `${prefix}type` SET name='Contrat Annuel' WHERE scope='Command' AND name='Per year';
UPDATE `${prefix}type` SET name='Notes de frais' WHERE scope='IndividualExpense' AND name='Expense report';
UPDATE `${prefix}type` SET name='Frais d''équipement' WHERE scope='ProjectExpense' AND name='Machine expense';
UPDATE `${prefix}type` SET name='Frais de bureau' WHERE scope='ProjectExpense' AND name='Office expense';
UPDATE `${prefix}type` SET name='Facture intermédiaire' WHERE scope='Bill' AND name='Partial bill';
UPDATE `${prefix}type` SET name='Facture finale' WHERE scope='Bill' AND name='Final bill';
UPDATE `${prefix}type` SET name='Facture complète' WHERE scope='Bill' AND name='Complete bill';
UPDATE `${prefix}type` SET name='Contractuel' WHERE scope='Risk' AND name='Contractual';
UPDATE `${prefix}type` SET name='Opérationnel' WHERE scope='Risk' AND name='Operational';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Risk' AND name='Technical';
UPDATE `${prefix}type` SET name='Contractuelle' WHERE scope='Opportunity' AND name='Contractual';
UPDATE `${prefix}type` SET name='Opérationnelle' WHERE scope='Opportunity' AND name='Operational';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Opportunity' AND name='Technical';
UPDATE `${prefix}type` SET name='Projet' WHERE scope='Action' AND name='Project';
UPDATE `${prefix}type` SET name='Interne' WHERE scope='Action' AND name='Internal';
UPDATE `${prefix}type` SET name='Client' WHERE scope='Action' AND name='Customer';
UPDATE `${prefix}type` SET name='Problème technique' WHERE scope='Issue' AND name='Technical issue';
UPDATE `${prefix}type` SET name='Non conformité sur un Processus' WHERE scope='Issue' AND name='Process non conformity';
UPDATE `${prefix}type` SET name='Non conformité sur la Qualité' WHERE scope='Issue' AND name='Quality non conformity';
UPDATE `${prefix}type` SET name='Processus non applicable' WHERE scope='Issue' AND name='Process non appliability';
UPDATE `${prefix}type` SET name='Plainte du client' WHERE scope='Issue' AND name='Customer complaint';
UPDATE `${prefix}type` SET name='Délai non respecté' WHERE scope='Issue' AND name='Delay non respect';
UPDATE `${prefix}type` SET name='Problème de gestion de ressources' WHERE scope='Issue' AND name='Resource management issue';
UPDATE `${prefix}type` SET name='Perte financière' WHERE scope='Issue' AND name='Financial loss';
UPDATE `${prefix}type` SET name='Comité de direction' WHERE scope='Meeting' AND name='Steering Committee';
UPDATE `${prefix}type` SET name='Réunion d''avancement' WHERE scope='Meeting' AND name='Progress Metting';
UPDATE `${prefix}type` SET name='Point d''équipe' WHERE scope='Meeting' AND name='Team Meeting';
UPDATE `${prefix}type` SET name='Fonctionnelle' WHERE scope='Decision' AND name='Functional';
UPDATE `${prefix}type` SET name='Opérationnelle' WHERE scope='Decision' AND name='Operational';
UPDATE `${prefix}type` SET name='Contractuelle' WHERE scope='Decision' AND name='Contractual';
UPDATE `${prefix}type` SET name='Stratégique' WHERE scope='Decision' AND name='Strategic';
UPDATE `${prefix}type` SET name='Fonctionnelle' WHERE scope='Question' AND name='Functional';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Question' AND name='Technical';
UPDATE `${prefix}type` SET name='ALERTE' WHERE scope='Message' AND name='ALERT';
UPDATE `${prefix}type` SET name='AVERTISSEMENT' WHERE scope='Message' AND name='WARNING';
UPDATE `${prefix}type` SET name='INFORMATION' WHERE scope='Message' AND name='INFO';
UPDATE `${prefix}type` SET name='Cahier des charges' WHERE scope='Document' AND name='Need expression';
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
UPDATE `${prefix}type` SET name='Compte rendu de réunion' WHERE scope='Document' AND name='Meeting Review';
UPDATE `${prefix}type` SET name='Suivi' WHERE scope='Document' AND name='Follow-up';
UPDATE `${prefix}type` SET name='Financier' WHERE scope='Document' AND name='Financial';
UPDATE `${prefix}type` SET name='Fonctionnelle' WHERE scope='Requirement' AND name='Functional';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Requirement' AND name='Technical';
UPDATE `${prefix}type` SET name='Sécurité' WHERE scope='Requirement' AND name='Security';
UPDATE `${prefix}type` SET name='Réglementation' WHERE scope='Requirement' AND name='Regulatory';
UPDATE `${prefix}type` SET name='Test d''implémentation d''exigence' WHERE scope='TestCase' AND name='Requirement test';
UPDATE `${prefix}type` SET name='Test unitaire' WHERE scope='TestCase' AND name='Unit test';
UPDATE `${prefix}type` SET name='Test de non régression' WHERE scope='TestCase' AND name='Non regression';
UPDATE `${prefix}type` SET name='Session de tests d''évolutions' WHERE scope='TestSession' AND name='Evolution test session';
UPDATE `${prefix}type` SET name='Session de tests de développement' WHERE scope='TestSession' AND name='Development test session';
UPDATE `${prefix}type` SET name='Session de tests de non régression' WHERE scope='TestSession' AND name='Non regression test session';
UPDATE `${prefix}type` SET name='Session de tests unitaires' WHERE scope='TestSession' AND name='Unitary case test session';
UPDATE `${prefix}type` SET name='Prospect', sortOrder='50', description='Client potentiel' WHERE scope='Client' AND name='business prospect';
UPDATE `${prefix}type` SET name='Client', sortOrder='30', description='Client actuel' WHERE scope='Client' AND name='customer';

-- Urgency
UPDATE `${prefix}urgency` SET name='Bloquant' WHERE name='Blocking';
UPDATE `${prefix}urgency` SET name='Urgent' WHERE name='Urgent';
UPDATE `${prefix}urgency` SET name='Non urgent' WHERE name='Not urgent';

-- Workflow
UPDATE `${prefix}workflow` SET name='Défaut', description='Flux de travail par défaut avec seulement des contraintes logiques.
Tout le monde peut modifier le statut.' WHERE name='Default';
UPDATE `${prefix}workflow` SET name='Simple', description='Flux de travail simple avec statuts limités.
Tout le monde peut modifier le statut.' WHERE name='Simple';
UPDATE `${prefix}workflow` SET name='Validation externe', description='Flux de travail élaboré avec traitement interne de l''équipe et validation externe.'
  WHERE name='External validation';
UPDATE `${prefix}workflow` SET name='Acceptation & validation externe', description='Flux de travail élaboré avec acceptation externe, traitement interne de l''équipe et validation externe.'
  WHERE name='External acceptation & validation';
UPDATE `${prefix}workflow` SET name='Simple avec validation', description='Flux de travail simple avec statuts limités, incluant une validation.'
  WHERE name='Simple with validation';
UPDATE `${prefix}workflow` SET name='Validation', description='Flux de travail court avec seulement une validation ou une possibilité d''annulation.
Privilèges de validation restreints.' WHERE name='Validation';
UPDATE `${prefix}workflow` SET name='Simple avec préparation', description='Flux de travail simple avec statuts limités, incluant la préparation.
Tout le monde peut modifier le statut.' WHERE name='Simple with preparation';
UPDATE `${prefix}workflow` SET name='Simple avec validation du chef de projet', description='Flux de travail simple avec statuts limités, incluant la validation du chef de projet.
Tout le monde peut modifier le statut, exepté pour la vidation qui est réservée au chef de projet.' WHERE name='Simple with Project Leader validation';

-- Configuration / Parameters
UPDATE `${prefix}parameter` SET parameterValue='L''application est fermée.
Seul l''administrateur peut se connecter.
Merci de revenir plus tard.' WHERE parameterCode='msgClosedApplication';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Vous êtes l''approbateur du <a href="${url}" >Document #${id}</a> : "${name}".<br/>Veuillez accéder à <a href="${url}" >ce document</a> et suivre le processus d''approbation.' WHERE parameterCode='paramMailBodyApprover';
UPDATE `${prefix}parameter` SET parameterValue='Bienvenue sur l''instance de ProjeQtOr ${dbName}, accessible à l''adresse <a href="${url}">${url}</a>.<br/>Votre nom d''utilisateur est <b>${login}</b>.<br/>Votre mot de passe est initialisé à <b>${password}</b><br/>Vous devrez le modifier à la première connexion.<br/><br/>En cas de problème, contactez votre administrateur à l'adresse <b>${adminMail}</b>.' WHERE parameterCode='paramMailBodyUser';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] L''élément ${item} #${id} a été modifié : "${name}"' WHERE parameterCode='paramMailTitleAnyChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Message envoyé par ${sender} : Vous devez approuver un document' WHERE parameterCode='paramMailTitleApprover';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une nouvelle affectation a été ajoutée pour l''élément ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAssignment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une affectation a été modifiée pour l''élément ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAssignmentChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Un nouveau fichier a été attaché à l''élément ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAttachment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] La description de l'élément ${item} #${id} a été modifiée : "${name}"' WHERE parameterCode='paramMailTitleDescription';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Message envoyé par ${sender} : ${item} #${id}' WHERE parameterCode='paramMailTitleDirect';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] L''élément ${item} #${id} a été créé : "${name}"' WHERE parameterCode='paramMailTitleNew';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une nouvelle note a été ajoutée à l''élément ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNote';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Une note a été modifiée sur l''élément ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNoteChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${responsible} est maintenant responsable de l''élément ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleResponsible';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Le résultat a été modifié pour l''élément ${item} #${id} : "${name}' WHERE parameterCode='paramMailTitleResult';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${item} #${id} vient de passé à l''état ${status} : ${name}' WHERE parameterCode='paramMailTitleStatus';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Message envoyé par ${sender} : information sur votre compte ProjeQtOr pour l''instance ${dbName}' WHERE parameterCode='paramMailTitleUser';
