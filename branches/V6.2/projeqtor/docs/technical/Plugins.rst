.. raw:: latex

.. title:: Plugins

Développement de Plugins
----------------------------
.. rubric:: Déploiement et structure d'un plugin

Les plug-ins doivent être compressés sous forme de fichier zip incluant le nom du plugin et sa version.
      
Par exemple : myPlugin_V1.0.zip
      
Le fichier zip doit inclure le dossier racine avec le nom du plug-in.
      
Pour être intégré, le fichier zip doit être placé dans le dossier / plugin manuellement ou via la fonctionnalité "télécharger le plug-in". 

.. rubric:: Structure de l'archive de déploiement d'un plug-in

===============================================    ===================================================================      
| **Repertoire du fichier**                        | **Utilité**                                                          
               
| plugin                                           | Répertoire racine du plug-in
                                                                                   
                       
   | __nls                                         | Répertoire racine pour les fichiers de traduction spécifiques
                                                   | utilisés par le plug-in "customizedTranslations"
                                                                 

   | __loadPlugin.php                              | Le script de gestion du plug-in               
          
                    
   | __myPlugin                                    | Répertoire racine du plug-in "MyPlugin"                
   | ____nls                                       | Répertoire racine pour les fichiers de traduction spécifiques
                                                   | utilisés par le plug-in "myPlugin" 
                                                                                                                                                         
      | ____*.php                                  | Script utilisable par le plug-in                                                       

      | ____myPlugin.css                           | Fichier CSS utilisé par myPlugin (sera chargé automatiquement)

      | ____myPlugin.js                            | Fonction Javascript utilisé par myPlugin 
                                                   | (sera chargé automatiquement)
      
      | ____pluginDescriptor.xml                   | Le fichier descripteur xml du plug-in.
                                                   | Obligatoire. Contient des informations de déploiement                                                                                                                                                                                                                                                                                              
===============================================    ===================================================================   

.. rubric:: pluginDescriptor.xml

=======================================================    ===================================================================      
| **Structure du descripteur XML**                         | **Utilité**                                                          
               
| plugin                                                   | Répertoire racine des plug-ins.
                                                           | L'attribut "nom" doit être égal au répertoire contenant le 
                                                           | plug-in et doit correspondre au nom du fichier zip.                                                                                   
                       
| __property name="description"                            | Une courte description du plug-in
                                                  
| __property name="comment"                                | Une description poussée du plug-in            
          
| __property name="uniqueCode"                             | Code unique du plug-in.             
                                                           | Les codes de 100000 à 199999 sont réservés aux plug-ins ProjeQtor
                                                           | Des codes de 200000 à 899999 peuvent être demandés à ProjeQtOr 
                                                           | pour vos plug-ins déployables.
                                                           | Si vous créez vos propres plug-ins, vous pouvez utiliser en 
                                                           | toute sécurité des valeurs >900000.
                                                           | L'id inséré (par exemple pour le menu) doit commencer par ce
                                                           | code +3 chiffres.
                                                                                                                                                         
| __property name="version"                                | Version du plug-in (doit correspondre à la version sur le nom
                                                           | du fichier zip)                                                       

| __property name="compatibility"                          | Première version de ProjeQtOr compatible avec le plug-in

| __property name="sql" version="x.y"                      | Le script SQL qui sera exécuté pendant le déploiement du plug-in
                                                           | pour modifier la base de données.
                                                           | La version spécifie la version du plugin qui exécutera le script
                                                           | de sorte que l'installation de la nouvelle version n'exécutera
                                                           | pas un script déjà exécuté lors de l'installation de la version
                                                           | précédente.
                                                   
| __property name="reload"                                 | Définie sur "1" pour forcer la recharge de l'application après
                                                           | l'installation du plug-in (par exemple si un nouveau menu est
                                                           | créé).
                                                    
| __property name="postInstall"                            | Fichier qui va être exécuté aprés l'installation du plug-in

| __files

| ____file name="x.y" target="z" action="act"              | Un noeud par fichier à copier ou à déplacer.
                                                           | "x.y": nom du fichier (doit exister dans le répertoire racine
                                                           | du plugin.
                                                           | "z": répertoire cible pour copier ou déplacer le fichier
                                                           | "act": action à faire : peut-être copié ou déplacé
                                                  
| __triggers

| ____trigger event="evt" class="cls" script="script"      | Un noeud par événement déclenché.
                                                           | "evt": événement à déclencher
                                                           | "cls": classe d'objets pour laquelle l'événement sera déclenché
                                                           | "script": nom du script (fichier php) à exécuter                    
                                                                                                                                                                                                                                                              
=======================================================    ===================================================================   


**Exemple : **

.. figure:: /images/GUI/exemplecustomization.png


.. rubric:: Exigences

* Si vous souhaitez créer des plug-ins qui peuvent être partagés avec la communauté sans interaction avec d'autres plug-ins, demandez à ProjeQtOr pour un code unique ou une zone de code unique.

* Si vous ajoutez un nouveau champ sur une table de base de données existante, commencez le nom de la colonne avec plgXXXXXX où XXXXX est le code unique du plugin.
        
* Si vous ajoutez une nouvelle table dans la base de données, commencez son nom avec plgXXXXXX où XXXXXX est le code unique du plugin.
        
* Si vous copiez ou déplacez des fichiers dans la structure de ProjeQtOr, le nom des fichiers devrait commencer par plgXXXXXX.
        
* Il est conseillé (mais pas obligatoire), d'ajouter un trait de soulignement (_) après le code unique lors du nom des fichiers, des tables et des colonnes.
        
.. rubric:: Comment ajouter un nouveau menu

* Insérer une nouvelle ligne dans le menu du tableau, avec type='item'. Vous devez également ajouter l'accès par défaut dans l'habilitation de table. L'accès sera gérable via des écrans de gestions des droits d'accès par défaut.
  Exemple: insérez les mises à jour de base de données dans myPlugin.sql et définissez ce fichier comme "sql" dans pluginDescriptor.xml, nous attendons que le nom du menu soit 'myPlugin'.   
    
* Définir trois images, une pour chaque taille (32px, 22px et 16px) et ajoutez leur description dans pluginDescription pour les déplacer vers le dossier /view/css/images.
    
* Définir le style css pour les icônes dans le css pour les plugins. Exemple : dans myPlugin.css, ajouter iconMyPlugin32, iconMyPlugin22 et iconMyPlugin16 pour pointer vers une nouvelle image d'écran.
    
* Ajouter une entrée javascript pour l'écran de plugin dans pluginMenuPage (cette variable est un tableau). Exemple : dans myPlugin.js, ajouter pluginMenuPage['menuMyPlugin']='../plugin/myPlugin/myPlugin.php'.
    
* Définissez la propriété reload à "1" dans pluginDescriptor (pour l'actualisation de l'écran après l'installation pour que le nouvel écran s'affiche).
    
.. rubric:: Conseils de codage

* Toujours inclure (require_once) le fichier /tool/projeqtor.php au début des scripts. Cela garantira que toutes les contraintes de sécurité sont prises en compte, y compris le fait que l'utilisateur doit être connecté. 
  Ceci est également obligatoire si vous souhaitez utiliser les fonctionnalités de Framework (objets, persistance).
      
* Toujours vérifier que l'utilisateur connecté a le droit d'exécuter l'action demandée.
    
* Ne jamais encoder les légendes dans votre code, même si vous ne préparez pas l'internationalisation de votre plug-in. Utilisez la fonction i18n(), qui utilisera également vos propres traductions dans la partie nls du plug-in.
    
* Ne jamais accéder directement à la base de données : utilisez toujours les fonctions proposées par le framework.
    
* Si vous avez besoin d'inclure des fonctions JavaScript ou des feuilles de style CSS, il suffit de les inclure dans le fichier correspondant avec le nom du plugin et l'extension attendue (.js ou .css).
  Exemple : myPlugin.css et myPlugin.js. Ces fichiers seront automatiquement chargés dans la page principale.
      
.. rubric:: Conseils de codage pour les événements déclenchés

* Pour les déclencheurs, les événements (evt) peuvent être :
        
  * beforeSave => avant que l'élément ne soit enregistré dans la base de données 
        
  * afterSave => après que l'élément est enregistré dans la base de données (vous pouvez alors utiliser $this->id)
        
  * beforeDelete => avant que l'élément ne soit supprimé de la base de données
        
  * afterDelete => après que l'élément est supprimé de la base de données
        
  * control => contrôles supplémentaires à ajouter après les contrôles génériques avant d'enregistrer
        
  * deleteControle => contrôles supplémentaires pour ajouter des contrôles génériques avant la suppression
        
  * connect => avant que la connexion soit contrôlée, disponible uniquement pour la classe 'User'
        
  * query => avant la requête, pour ajouter des restrictions supplémentaires
        
  * liste => avant liste de requêtes, pour ajouter des restrictions supplémentaires
  
        
* Les scripts définis seront directement inclus dans l'événement correspondant à l'objet. Donc, vous pouvez utiliser $this pour faire référence à l'objet courant et parent pour faire référence à la classe héritée.  
    
  * Pour un événement "control", pour retourner et erroner un contrôle, compléter le message dans la variable $result (considérer qu'il est initialisé et non vide, donc utiliser $result.="<br/>...")
    
  * Dans les scripts déclenchés, si vous devez comparer des valeurs dans la base de données aux valeurs qui seront ou ont été stockées, utilisez dans l'événement "beforeSave" : $old=$this->getOld(); (ceci va récupérer des valeurs dans la base de données pour l'élément courant).
    Ensuite, vous pourrez comparer les valeurs de $old et $this
    
  * Dans les après événements (afterSave ou afterDelete), la variable $result contient le résultat de l'opération correspondante (save ou delete)