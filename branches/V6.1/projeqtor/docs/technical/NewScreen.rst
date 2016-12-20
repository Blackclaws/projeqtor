.. raw:: latex

.. title:: NewScreen


Créer un nouvel écran dans ProjeQtOr
-------------------------------------

.. rubric:: Etape pour créer un nouvel écran

- Commencer par créer une table. Il est fortement recommandé de créer la requête SQL dans le script SQL ( par exemple "projeqtor_V6.1.0") avant de l'exécuter dans votre Système de Gestion de Base de Données.

.. warning:: Le nom d'une table s'écrit "xxx" sans majuscule. Le nom d'une table s'écrit impérativement en minuscules pour garantir la compatibilité avec PostgreSQL.

- Dans la table "menu" , créer le menu pour votre écran.

.. warning:: Le nom d'un menu s'écrit "menuXxx".

- Initialiser l'accés . Pour ce faire , vous devez ajouter une ligne dans la table 'Habilitation' .

Exemple de requête à faire pour ajouter dans la table Habilitation :
 
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES (1,162,1);

Ce qui donne en table : 

.. figure:: /images/GUI/bdd.png

- Maintenant , créer la classe , par exemple : Categorie.php

.. warning:: Le nom d'une classe s'écrit "Xxx".

- Créer l'icône associée.

.. seealso:: Reporter vous à la rubrique :ref:`createicon`

- Créer les libellés.

.. seealso:: Reporter vous à la rubrique :ref:`internationalization`





