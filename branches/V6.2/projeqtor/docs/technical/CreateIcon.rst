.. raw:: latex

.. title:: CreateIcon

.. index:: ! CreateIcon

.. _createicon :

Créer une icône
-----------------

.. rubric:: Etapes pour modifier les images

- Tout d'abord, munissez-vous de votre image. Vous aurez besoin d'une image de chaque couleur pour respecter les thèmes de ProjeQtOr (Bleu, Rouge, Vert, Gris) mais aussi d'une image à la couleur du thème Standard.

- Enregistrez vos images dans les bons dossier. Par défaut, "www/projeqtorV6.1/view/css/customIcons/" suivi de la couleur et "www/projeqtorV6.1/view/css/images" pour les icônes standard.

- Maintenant, écrire du code dans "www/projeqtorV6.1/view/css/projeqtorFlat.css". Voici un exemple :

.. figure:: /images/GUI/projeqtorflat.png

Il y a trois lignes de codes car on permet d'avoir l'image en trois taille ( 16px, 22px, 32px) tout en n'ayant qu'une seule image dans notre dossier.

Inclure donc l'image dans chaque couleur (ProjeQtOrFlatBlue, ProjeQtOrFlatGreen, ProjeQtOrFlatRed, ProjeQtOrFlatGrey) et l'inclure aussi en standard dans "www/projeqtorV6.1/view/css/projeqtorIcons.css".

.. seealso:: Si vous appelez l'icône avec le même nom que votre classe, elle sera automatiquement détectée sans utiliser de fonction. Exemple : iconAction32 sera automatiquement détecté car il existe une classe "Action".

- Dernière chose à savoir, vous pouvez utiliser trois fonctions pour afficher les images. 
  
  - formatSmallButton => Pour les petites icônes en 16px.
  
  - formatBigButton => Pour les icônes de 32 px.
  
  - formatIcon => Pour les images.
