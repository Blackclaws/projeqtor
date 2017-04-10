.. raw:: latex

.. title:: Import


Import
--------------
.. rubric:: Import

Les importations fonctionnent à partir de fichiers CSV ou XLSX.

La première ligne du fichier doit contenir le nom des champs : regardez dans la classe Model : les noms sont identiques. Il suffit de cliquer sur le bouton d'aide spécifique pour avoir de l'aide sur les champs.
Vous pouvez ou non ajouter une colonne "id" au fichier :
 - si la colonne "id" existe et que "id" est défini pour une ligne, l'importation essaiera de mettre à jour l'élément correspondant et échouera si elle n'existe pas
 - si la colonne "id" n'existe pas ou si "id" n'est pas définie pour une ligne, l'importation créera un nouvel élément à partir des données.

Dans tous les cas, les colonnes sans données ne seront pas mises à jour : vous ne pouvez mettre à jour qu'un seul champ d'un élément. Pour effacer une donnée, entrez la valeur "NULL" (non sensible à la casse).

Pour les colonnes correspondant aux tables liées ("idXxxx"), vous pouvez indiquer comme nom de colonne soit "idXxxx", soit "Xxxx" (sans "id") ou la légende de la colonne (comme affichée sur les écrans). Si la valeur de la colonne est numérique, elle est considérée comme le code de l'élément. Si la valeur de la colonne contient une valeur non numérique, elle est considérée comme le nom de l'élément et le code sera recherché à partir du nom.

Les noms des colonnes peuvent contenir des espaces (pour avoir une meilleure lisibilité) : les espaces seront supprimés pour obtenir le nom de la colonne.

Les dates sont attendues au format «AAAA-MM-JJ».

Insertion dans les éléments "Planification" (activité, projet), insère automatiquement un élément dans la table "PlanningElement": les données de ce tableau peuvent être insérées dans le fichier d'importation (à partir de la version V1.3.0).


Sélectionnez le type d'élément dans la liste. Le contenu du fichier importé doit correspondre à la description du type d'élément.
Pour connaître les données qui peuvent être importées, cliquez sur le bouton.  

.. figure:: /images/GUI/import.png

Après avoir sélectionné le format de fichier (CSV ou XLSX) et le fichier à importer, vous pouvez importer des données.
Vous aurez alors un rapport complet de l'importation :

.. figure:: /images/GUI/import2.png

Des données ne sont pas importées parce qu'elles ne sont pas reconnues comme un champ apparaissent en texte gris dans la table des résultats.
Les données qui ne sont pas importées volontairement (parce qu'elles doivent être calculées) apparaissent en bleu dans la table des résultats.

.. figure:: /images/GUI/import3.png