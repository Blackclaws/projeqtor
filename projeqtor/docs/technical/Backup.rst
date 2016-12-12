.. raw:: latex

.. title:: Backup

Backup / Restore
-------------------
.. rubric:: Backup / Restore

La sauvegarde est une bonne pratique.
Vous devez régulièrement sauvegarder vos données pour être en mesure de le récupérer en cas d'accident.
À quelle fréquence ?
Tout dépend de votre besoin ...
Il suffit de se demander: ce qui est acceptable à perdre en cas d'accident? 1 jour, 1 semaine?

Vous devez toujours sauvegarder vos données avant toute mise à niveau d'application ... en cas de ...

Alors, comment sauvegarder?
La manière la plus simple est d'utiliser la capacité d'exportation phpMyAdmin ou phpPgAdmin (en fonction du format de base de données), en utilisant le format "SQL", sauvegardant le résultat dans un fichier.
Un autre excellent outil est MySqlDumper.
Ensuite, vous serez en mesure d'importer des données à partir de ce fichier exporté.

.. seealso:: 
           *Indices* : 
           
               - Assurez-vous d'utiliser le jeu de caractères UTF-8 lors de l'exportation / importation
                
               - Vous ne pouvez pas importer dans une base de données complète (avec les données existantes):
               
                  - Soit vous trunquez les tables avant l'importation (vous devez ensuite vous assurer d'importer des données dans une structure de la même version de l'application!)
                  
                  - Ou vous déposez les tables avant l'importation
                  
                  - Ou vous exportez des données, y compris "Drop tables"
                  
               - Tester régulièrement vos fichiers de back-up, en essayant de le restaurer sur une base de données vide (souvent les sauvegardes ne sont jamais testées et ne peuvent pas être importées si nécessaire ...)
               
.. warning:: Les pièces jointes et les documents ne sont pas stockés dans la base de données.
             Ils peuvent être sauvegardés séparément si nécessaire.