.. raw:: latex

.. title:: Development

Developpement Objet
-----------------------
.. rubric:: Classes de persistance

.. figure:: /images/GUI/classepersistance.png

.. rubric:: Méthodes génériques de persistance

Il existe plusieurs méthodes génériques de persistance , les plus utiles et les plus utilisés sont :

  - La méthode Save : Utilisé pour sauvegarder des données en base de donnée . Peut-être réutilisé dans d'autres classe en faisant un : 
    *$result=parent::save();* 
  
  - La méthode Control : 
  
  - La methode Delete : Utilisé pour supprimer des données en base de donnée . Peut-être réutilisé dans d'autres classe en faisant un : 
    *$result=parent::delete();*

.. warning :: Ces trois méthodes sont définis dans SqlElement.php en privée , il faut donc les étendres avec la notions d'héritage si ont veux les réutiliser dans d'autres classes. 

.. rubric:: Description générique des objets

.. rubric:: Régles de base de développement

* Toujours inclure (require_once) le fichier /tool/projeqtor.php au début des scripts.Cela garantira que toutes les contraintes de sécurité sont prises en compte, y compris le fait que l'utilisateur doit être connecté. Ceci est également obligatoire si vous souhaitez utiliser les fonctionnalités de Framework(objects , persistance).
* Toujours vérifier que l'utilisateur connecté à le droit d'éxécuter l'action demandée.
* Aucun libellé en dur : utiliser i18n(codeMessage)(existe en PHP et en Javascript).
* Ne jamais encoder les légendes dans votre code,même si vous ne préparez pas l'internationalisation de votre plug-in. Utiliser la fonction i18n() qui utilisera également vos propres traductions dans la partie nls du plug-in.
* Aucun accès direct à la base de données : utiliser le mappage objet. Ne jamais accéder directement à la base de données : utilisez toujours les fonctions proposées par le framework.
* Si vous devez inclure des fonctions JavaScript ou des styles CSS, il suffit de les inclure dans le fichier correspondant avec le nom du plugin et l'extension attendue (.js ou .css). Exemple: myPlugin.css et myPlugin.js. Ces fichiers seront automatiquement chargés dans la page principale.