.. raw:: latex

    \newpage

.. title:: Technical

Principes Techniques
--------------------
.. rubric:: ProjeQtOr a été conçue dans le but d'apporter une utilisabilité maximale

- ProjeQtOr est une application web dotée d'une interface graphique riche. 

- ProjeQtOr propose une interface conviviale centrée sur l'utilisabilité au quotidien.

- ProjeQtOr s'exécute comme un client léger, dans un navigateur web. Une fois que ProjeQtOr est installée sur le serveur, les utilisateurs peuvent y accéder via leur navigateur sans rien avoir à installer sur leur poste de travail. 

- ProjeQtOr est compatible avec de multiples navigateurs et est validée sur les principaux :
   - Internet Explorer (version 9 et supérieure)
   - Edge
   - Firefox
   - Chrome

- Aucun module complémentaire n'est à installer sur le poste client.

- L'interface utilise la technologie Ajax. De ce fait, l'actualisation de la page est toujours limitée à la zone cible, évitant les pages blanches et le scintillement.
  
- L'interface utilisateur est conçue pour se conformer à ce que les utilisateurs on l'habitude de manipuler sur leurs outils bureautiques (comme par exemple un client de messagerie) :
    - Menu supérieur ou à gauche
    - Données à droite, avec l'écran divisé en haut par une liste d'éléments et en bas par le détail de  l'élément sélectionné dans la liste.
    - La sélection d'un élément dans la liste affiche directement son détail.
- ProjeQtOr propose la possibilité d'accéder à l'historique des mises à jour sur chaque élément : toutes les modifications sont historisées.
- ProjeQtOr propose sur chaque élément une gestion de notes qui permet d'ajouter des commentaires.
- ProjeQtOr propose sur chaque élément une gestion de fichiers attachés qui permet d'ajouter des pièces jointe.
- ProjeQtOr est Multi-Langue : chaque utilisateur peut affiche l'interface dans sa langue.


.. rubric:: Installation

- L'installation de ProjeQtOr requiert sur le serveur uniquement la trilogie largement utilisée : 
  - Apache, 
  - MySQL (PostgreSql ou MariaDB peuvent aussi être utilisés)
  - PHP.

- Pour installer ces briques logicielles vous pouvez utiliser votre paquet préféré: XAMPP, LAMP, WAMP, EasyPhP, Serveur ZEND... ou installer ces composants un a un (ce qui est généralement le cas sous Linux)

- Les versions requises des composants sot :
  - Apache : V2 ou supérieure
  - MySql : V5 ou supérieure
  -  PostgreSql : V8.4 ou supérieure. V9.1 ou supérieure recommandée.
  - PHP : V5.2 ou supérieure. V7.1 recommandée
 
- La gestion automatique des versions déclenche la mise à jour de la structure de la base de données lors de la première exécution pour toute nouvelle version.
- L'écran de configuration lors de la première exécution pour définir les paramètres internes (accès à la base de données, paramètres par défaut,...).
- La plupart des paramètres peuvent être mis à jour via un écran dédié.

.. rubric:: Facile à paramétrer

- Chaque paramètre utilisateur, chaque liste de valeurs peut-être changée à travers un écran dédié.

- Des paramètres par défaut sont proposés, correspondant aux besoins les plus courants.

- Sélection de la langue proposée sur la valeur locale, éditable par l'utilisateur (16 langues sur la version actuelle 6.0 = 
  - Chinois
  - Croate
  - Néerlandais
  - Anglais
  - Perse (Iranien)
  - Français Canadien
  - Français
  - Allemand
  - Italien
  - Japonais
  - Portugais (Brésil)
  - Portugais
  - Russe
  - Espagnol
  - Ukranien
  - Grec
 
.. rubric:: Facile à personnaliser

- Comme ProjeQtOr est proposé sous licences AGPL open source, vous pouvez l'adapter à vos besoins.

- ProjeQtOr à été développé en tant que Framework, il est donc très facile d'ajouter un élément, d'ajouter des données ou de modifier l'affichage d'un élément.

.. rubric:: Facile à surveiller

- Gestion des connexions : lites des sessions ouvertes, possibilité de fermer une session ou toutes les sessions.

- Ouverture/Fermeture de l'application pour les opérations de maintenance.