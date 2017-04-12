.. raw:: latex

.. title:: ParametersManagement

Gestion des paramètres
-------------------------

===============================================    ===================================================================    =================================================    
**Caption**                                        | **Description**                                                      **Variable name**     
               
Databasetype                                       | Le type de base de données.Les valeurs
                                                   | possible sont 'mysql' et 'pgsql'                                     $paramDbType
                       
DatabaseHost                                       | Nom du serveur MySql ou PostgreSql ('localhost' par défaut).
                                                   | Si votre base de données n'écoute pas le port par défaut,
                                                   | il suffit de l'indiquer ici 'myServer:myPort'.                       $paramDbHost

Database user to connect                           | Utilisateur valide de base de données (par défaut 'root')            $paramDbUser       
          
                    
Database password for user                         | Mot de passe de base de données pour utilisateur                     $paramDbPassword

Database schema name                               | Nom de schéma de base de données                                     $paramDbName                                                                            

Name to be displayed                               | Nom qui sera affiché en bas de l'écran principal.                    $paramDbDisplayName
                                                   | Toute valeur est possible pour identifier la base de données.   

Database prefix for table names                    | Préfixe sur les noms de tables. Il est utilisé pour stocker 
                                                   | plusieurs instances sous le même schéma. Il peut être laissé vide    $paramDbName                                                                                                                                              
===============================================    ===================================================================    ================================================= 