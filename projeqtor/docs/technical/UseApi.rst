.. raw:: latex

.. title:: UseApi

Utilisation de l'API
------------------------
    ProjeQtor fournit une API pour interagir avec ses éléments. Il est fourni en tant que service web REST.
    
    Il est possible de lire les éléments (méthode GET), de créer ( méthodes PUT, POST), de modifier (méthodes PUT,POST) et de supprimer (méthode DELETE). 
    
    .. warning:: Dans projeQtOr, les méthodes PUT et POST sont équivalentes, c'est la présence de l'id qui va déterminer quelle méthode utiliser.
    
    Tout d'abord, l'API doit être activée : pour des raisons de sécurité, elle n'est pas activée par défaut.
    
    - Générer un fichier .htpasswd (voir les sujets connexes sur le net sur la façon de faire).
    
    Un modèle est fourni dans /api/.htpasswd, en référence à projeqtor utilisateur, mot de passe projeqtor. Il est fourni uniquement à des fins d'essai. Ne l'utilisez pas sur un environnement de production car il exposerait toutes vos données.

    - Mettre à jour le fichier .htaccess pour spécifier l'emplacement de votre fichier .htpasswd : AuthUserFile "/pathToFile/.htpasswd"
    
    L'emplacement par défaut est le répertoire Apache.
    
    Utilisation de l'API :
    
    - Depuis V4.4, l'utilisateur utilisé (défini dans .htpassword) doit exister en tant qu'utilisateur dans la base de données.
    
      Il faut aussi que les droits d'accès (lire, créer, mettre à jour, supprimer) soit définis pour cet utilisateur, comme dans l'application.
      
      Cela vous permet de fournir un certain accès aux utilisateurs externes et de contrôler la visibilité qu'ils obtiennent sur vos données.
      
    - Les méthodes disponibles sont GET (lecture), PUT (création, mise à jour), POST (création, mise à jour) et DELETE (suppression).
    
    - Pour les méthodes PUT, PUSH et DELETE, les données doivent être cryptées avec l'algorithme AES-256, avec la clé comme clé API définie pour l'utilisation. L'administrateur doit fournir cette clé d'API au consommateur de l'API.
    
      Vous pouvez utiliser la bibliothèque AESCRT fournie dans le répertoire /external pour le cryptage.
      
    - Les méthodes PUT et PUSH sont similaires et peuvent être utilisées pour créer ou mettre à jour des éléments.
    
      La différence est seulement dans la façon d'envoyer des données: comme un tableau Post pour POST, comme un fichier pour PUT.
      
    - La méthode DELETE requiert des données, formatées comme pour un PUT, mais seul "id" est requis.
    
    - Pour PUT, POST, DELETE, vous pouvez fournir : 
              - Un seul élément : {"id": "1", ...}
              - Une liste d'articles : {"identifié" : "id", "articles" : [{"id" : "1", ...}, {"id" : "2", ...}]}
              - Le format JSON extrait de GET peut être utilisé pour PUT, POST et DELETE. 


===============================================    =========================================================================    ====================================================    
**Method**                                         | **Url**                                                                    **Result**     
               
GET                                                | http://myserver/api/{object class}/{object id}                             La description complète, au format JSON, de
                                                   | Ex: http://myserver/api/Project/1                                          l'objet de la classe donnée avec l'id donné
                                                                                     
                       
GET                                                | http://myserver/api/{object class}/all                                     La description complète, au format JSON , de
                                                   | Ex: http://myserver/api/Project/all                                        tous les objets de la classe donnée
                                                                    

GET                                                | http://myserver/api/{object class}/filter/{filterid}                       La description complète, au format JSON, de tous        
                                                   | Ex: http://myserver/api/Project/filter/1                                   les objets de la classe donnée correspondant au
                                                                                                                                filtre mémorisé donné
                                                                                                                                -id du filtre peut être récupéré lors de 
                                                                                                                                l'enregistrement du filtre.
                                                                                                                                -L'utilisation d'un filtre d'une classe différente
                                                                                                                                peut entraîner des résultats inattendus.                                                                                                                            
                                                                                                                              
GET                                                | http://myserver/api/{objectclass}/search/{critN}                           La description complète, au format JSON, de tous les 
                                                   | Ex:                                                                        objets de la classe donnée correspondant aux 
                                                   http://myserver/api/Activity/search/idProject=1/name like '%error%'          critères donnés. Vous pouvez fournir autant de
                                                                                                                                critères que vous le souhaitez, ils seront inclus 
                                                                                                                                dans la clause where avec l'opérateur ET.
                                                                                                                                Contrairement à l'exemple, les critères doivent
                                                                                                                                être "url encoded"(utilisez la fonction urlencode()
                                                                                                                                PHP par exemple.
                                                   
                                                   
GET                                                | http://myserver/api/{objectclass}/updated/{start date}/{end date}          La description complète, au format JSON, de tous 
                                                   | Ex: http://myserver/api/Project/updated/20130101000000/20131231235959      les objets mis à jour entre la date de début et la                                             
                                                                                                                                date de fin. Le format de date est YYYYMMDDHHMNSS
                                                                                                                                Date >="start date" et Date < "end date"
                                                                                                                            
POST                                               | http://myserver/api/{object class}                                         La description complète, au format JSON, des objets
                                                   | Données fournies au format JSON en tant que valeur POST                    mis à jour ou créés, avec deux champs
                                                                                                                                supplémentaires :
                                                                                                                                
                                                                                                                                * ApiResult: état de la mise à jour
                                                                                                                                * ApiResultatMessahe: Message détaillé

PUT                                                | http://myserver/api/{object class}                                         La description complète, au format JSON, des objets
                                                   | Données fournies au format JSON en tant que fichier                        mis à jour ou créés, avec deux champs 
                                                                                                                                supplémentaires :
                                                                                                                                
                                                                                                                                * ApiResult: état de la mise à jour
                                                                                                                                * ApiResultMessage: Message détaillé
                                                                                                                                
DELETE                                             | http://myserver/api/{object class}                                         La description complète, au format JSON, des objets
                                                   | Données fournies au format JSON en tant que fichier                        mis à jour ou créés, avec deux champs
                                                                                                                                supplémentaires :
                                                                                                                                
                                                                                                                                * ApiResult: état de la mise à jour
                                                                                                                                * ApiResultMessage: Message détaillé                                                                                                                                      
===============================================    =========================================================================    ==================================================== 

    Voici un exemple de code PHP appelant l'API pour la requête GET (lire):   
        .. figure:: /images/GUI/getapi.png
        
                Cette requête liste tous les tickets
                
    Voici un exemple de code PHP appelant l'API pour la requête DELETE (create, update):
        .. figure:: /images/GUI/deleteapi.png
        
                Cette requête supprime le ticket #1
                
    Voici un exemple de code PHP appelant l'API pour les requêtes PUT et POST (create, update):
        .. figure:: /images/GUI/getapi.png
        
        .. figure:: /images/GUI/getapi.png

                Ces requêtes mettent à jour le nom du billet n°1                        