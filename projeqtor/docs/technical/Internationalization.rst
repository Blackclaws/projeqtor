.. raw:: latex

.. title:: Internationalization

Internationalisation
--------------------------
**L'internationalisation** aussi appélé **i18n** [#f1]_ dans ProjeQtOr comprends plusieurs fonctionnalitées :

    - i18n est utilisé pour ne pas écrire en dur dans le code de ProjeQtOr. Par exemple , dés que un titre doit être écrit on va utilisé la fonction i18n().
    
    - i18n est aussi utilisé pour , comme son nom l'indique , l'internationalisation. C'est à dire la traduction en plusieurs langues de l'application.
    
.. warning::
 
    - i18n est défini en PHP mais aussi en JavaScript !
             
    - Ne jamais écrire de libellé en dur , toujours utiliser i18n!

Voici la structure du dossier i18n :

    .. figure:: /images/GUI/internationalisation.png

Comme ont peut le remarquer , dans la structure de i18n il y a un lang.xls , c'est dans ce fichir que l'ont va définir les traductions des codes utilisés dans les différentes langues !

Voici un exemple du contenu de lang.xls ouvert à partir de Exel :

    .. figure:: /images/GUI/internationalisationexel.png

Voici un exemple d'ajout d'un nouveau profil :

    - Ajouter le nouveau profil et définir son nom sur une valeur significative, sans espaces ni caractéres spéciaux, et idéalement à partir de "profil" ( pour être facilement identifié dans la table de traduction).
      Par exemple , on va l'appeler "profileNewValue".
     
    - Entrez toutes les autres valeurs et enregistrez. 
    
    - Aprés l'enregistrement , vous pouvez voir la valeur affichée [profileNewValue], ce qui signifie que cette valeur ne se trouve pas dans la table de traduction.
    
    - Vous devez donc ajouter une nouvelle ligne de la fichier lang.xls . Commencez par le télécharger à partir du menu "Telechargement".
    
    - Aprés l'avoir téléchargé , ouvrez le avec Excel et autorisez les Macros.
    
    - Ajoutez une nouvelle ligne dans lang.xls avec une chaîne = "profileNewValue" (exemple) et remplir les champs default,en,fr et la légende que vous souhaitez afficher.
    
    - Ensuite , "enregistrez sous"(pour positionner le répertoire par défault dans Excel n'utilisez pas directement "enregistrer") et cliquez sur "Générer".
    
    - Positionnez vous dans le dossier "nls" pour générer.
    
    - Cela générera un fichier lang.js dans le répertoire courant et dans les sous-répertoire (en,fr,...).
    
    - Maintenant vous pouvez copier ces fichiers pour remplacer ceux existants dans le répertoire /tool/i18n/nls de votre serveur.
    
    - Le nom est maintenant traduit.
    
.. warning:: n'oubliez pas de sauvegarder votre fichier lang.xls et d'identifier vos modifications . Car vous devrez les réappliquer après chaque nouvelle version.

.. [#f1] i18n = Internationalisation = i + 18 caractére + n