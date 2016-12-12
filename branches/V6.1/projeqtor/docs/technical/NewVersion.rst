.. raw:: latex

.. title:: NewVersion

Installer une nouvelle version
----------------------------------
.. rubric:: Installer une nouvelle version

ProjeQtOr évoluera constamment pour répondre aux besoins des utilisateurs.
Pour déployer une nouvelle version, décompressez le nouveau projectorVx.y.z.zip dans le répertoire du serveur Web et connectez-vous à l'application.
Les mises à jour de la base de données seront automatiquement déclenchées.
Une fois terminé, un message affiche la synthèse des mises à jour (nombre d'erreurs éventuelles).
Vous trouverez les détails des mises à jour dans le fichier journal.

Certaines nouvelles versions peuvent également ajouter de nouveaux paramètres.
Ceux-ci seront naturellement intégrés dans l'écran de configuration.
Si vous déployez une de ces versions à partir d'une version précédemment installée, de nouveaux paramètres seront automatiquement insérés à la fin de votre fichier "parameter.php" avec une valeur par défaut.
Vous pourrez alors mettre à jour cette valeur dans votre contexte, en modifiant le fichier.
Dans ce cas, un message vous informe que de nouveaux paramètres ont été ajoutés, à l'écran de connexion, juste avant le message "Mise à jour de la base de données".

.. warning:: 
   Si vous mettez à niveau une version inférieure à 1.1.0, vous devez supprimer la dernière fermeture de script (?>) Dans le fichier "parameters.php" avant la mise à niveau.

Mais aussi : 

.. warning:: Il est fortement recommandé de sauvegarder votre base de données avant de passer à la nouvelle version, pour pouvoir revenir à la version précédente.

.. seealso:: Vous pouvez mettre à jour deux fois (si nécessaire): mettre à jour la table "parameter" , réinitialiser la valeur de la ligne où parameterCode = 'dbVersion' au numéro de version précédente et se connecter à nouveau. 
             Si vous constatez alors que certains éléments de menu ont disparu, vérifiez les entrées doubles dans la table d'habilitation (dernières lignes) et supprimez-les (cela ne devrait pas se produire depuis V1.5.0).