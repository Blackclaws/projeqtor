.. raw:: latex

.. title:: Internationalization

.. index:: ! Internationalization

.. _internationalization :

Internationalisation
--------------------------
**L'internationalisation** aussi appelé **i18n** [#f1]_ dans ProjeQtOr comprend plusieurs fonctionnalités :

    - i18n est utilisé pour ne pas écrire en dur dans le code de ProjeQtOr. Par exemple, dès qu'un titre doit être écrit on va utiliser la fonction i18n().
    
    - i18n est aussi utilisé pour, comme son nom l'indique, l'internationalisation. C'est à dire la traduction en plusieurs langues de l'application.
    
.. warning::
 
    - i18n est défini en PHP mais aussi en JavaScript !
             
    - Ne jamais écrire de libellé en dur, toujours utiliser i18n !

Voici la structure du dossier i18n :

    .. figure:: /images/GUI/internationalisation.png

Comme on peut le remarquer, dans la structure de i18n il y a un lang.xls, c'est dans ce fichier que l'on va définir les traductions des codes utilisés dans les différentes langues !

Voici un exemple du contenu de lang.xls ouvert à partir de Excel :

    .. figure:: /images/GUI/internationalisationexel.png

Voici un exemple d'ajout d'un nouveau profil :

    - Ajouter le nouveau profil et définir son nom sur une valeur significative, sans espaces ni caractères spéciaux, et idéalement à partir de "profil" (pour être facilement identifié dans la table de traduction).
      Par exemple, on va l'appeler "profileNewValue".
     
    - Entrez toutes les autres valeurs et enregistrez. 
    
    - Après l'enregistrement, vous pouvez voir la valeur affichée [profileNewValue], ce qui signifie que cette valeur ne se trouve pas dans la table de traduction.
    
    - Vous devez donc ajouter une nouvelle ligne de la fichier lang.xls. Commencez par le télécharger à partir du menu "Téléchargement".
    
    - Après l'avoir téléchargé, ouvrez le avec Excel et autorisez les Macros.
    
    - Ajoutez une nouvelle ligne dans lang.xls avec une chaîne = "profileNewValue" (exemple) et remplir les champs default, en, fr et la légende que vous souhaitez afficher.
    
    - Ensuite, "enregistrez sous"(pour positionner le répertoire par défaut dans Excel n'utilisez pas directement "enregistrer") et cliquez sur "Générer".
    
    - Positionnez-vous dans le dossier "nls" pour générer.
    
    - Cela génèrera un fichier lang.js dans le répertoire courant et dans les sous-répertoires (en, fr, ...).
    
    - Maintenant vous pouvez copier ces fichiers pour remplacer ceux existants dans le répertoire /tool/i18n/nls de votre serveur.
    
    - Le nom est maintenant traduit.
    
.. warning:: n'oubliez pas de sauvegarder votre fichier lang.xls et d'identifier vos modifications car vous devrez les rappliquer après chaque nouvelle version.

.. [#f1] i18n = Internationalisation = i + 18 caractères + n