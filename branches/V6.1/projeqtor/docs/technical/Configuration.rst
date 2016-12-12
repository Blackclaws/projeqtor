.. raw:: latex

.. title:: Configuration

Configuration
-----------------
.. rubric:: Configuration

Lorsque vous ouvrez une session, le processus normal doit être:

    - L'écran de configuration s'affiche.
    
    - Vous remplissez les données correspondant à votre environnement.
    
    - Vous cliquez ensuite sur le bouton "OK".
    
    - Un spinner est affiché.
    
    - Le spinner disparaît : à ce moment ,vous devriez voir un message et un nouveau bouton "Continuer" sous le bouton "OK".
    
    - Vous cliquez sur le bouton "Continuez"
    
    - L'écran change en écran de connexion
    
    - Vous entrez la connexion par défault : admin/admin et cliquez sur le bouton "OK".
    
    - Un spinner est affiché: cette étape peut prendre un certain temps(environ 1 minutes) parceque toute la structure de la base de données est créé.
    
    - Le spinner disparaît et un message court indique le résultat de la création de la base de données ( le détail de cette étape est écrit dans le fichier log).
    
    - Cliquez de nouveau sur "OK" et vous êtes dans l'application ! 
    
Si tout cela ne fonctionne pas , essayez cette solution:

    - Supprimer le fichier "/tool/parametersLocation.php" pour refaire l'installation.
    
.. warning:: Si vous tentez de déplacer le fichier "tool/parameters.php assurez-vous de le stocker hors de l'accès web pour éviter d'avoir des failles dans la sécurité ! 