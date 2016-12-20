.. raw:: latex

.. title:: ImportAutomatic

Automatique Import
---------------------------
.. rubric:: Automatique Import


Les importations peuvent être automatisées: les fichiers placés sur un répertoire défini seront automatiquement importés.

Les fichiers doivent respecter certaines règles de base : 

 - Le nom du fichier est: "Class" _ "Timestamp". "ext" .
  
    - "Timestanp" est le type d'élément à importer(billet,activité,question...).
  
    - "Timestamp" est un timestamp défini pour pouvoir stocker plusieurs fichiers dans le répertoire; Le format est gratuit; Le format recommandé est "YYYYMMDD_HHMMSS".
  
    - "ext" est l'extension de fichier, représentant son format: les extensions valides sont "csv" et "xlsx".
  
    - Exemple de nom de fichier d'importation: Ticket_20131231_235959.csv .
  
  - Les fichiers sont au format ProjeQtOr standard pour l'importation (CSV ou XLSX) .
  
  - Les fichiers doivent être complets et cohérents: si la tâche de création peut prendre un certain temps, les fichiers ne doivent pas être créés directement dans le dossier cible; Ils doivent être créés dans un dossier temporaire et déplacés ensuite.
  
- Il vous suffit de définir les paramètres "Cron" dans l'écran Paramètres globaux.

.. figure:: /images/GUI/automaticimport.png 


Le processus d'importation automatique d'un fichier respecte la fonctionnalité d'importation standard. Reportez-vous à lui pour avoir plus d'informations concernant le format de fichier.

Les fichiers correctement importés sont déplacés vers un sous-dossier "done" du dossier d'importation.

Si une erreur se produit lors de l'importation d'un fichier, le fichier complet est déplacé dans le sous-dossier "error" du dossier d'importation, même s'il n'y a qu'une erreur sur plusieurs autres éléments correctement intégrés.

Vous pouvez obtenir le résultat sous forme de fichier journal et / ou de résumé par courrier électronique