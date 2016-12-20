.. raw:: latex

.. title:: CreateIcon

.. index:: ! CreateIcon

.. _createicon :

Créer une icône
-----------------

.. rubric:: Etapes pour modifier les images

- Tout d'abord , munissez-vous de votre image. Vous aurez besoin d'une image de chaques couleurs pour respecter les thémes de ProjeQtOr (Bleu,Rouge,Vert,Gris) mais aussi d'une image au couleur du théme Standard.

- Enregistrez vos images dans les bons dossier. Par défault , "www/projeqtorV6.1/view/css/customIcons/" suivi de la couleur et "www/projeqtorV6.1/view/css/images" pour les icônes standard.

- Maintenant , on a besoin d'écrire du code dans "www/projeqtorV6.1/view/css/projeqtorFlat.css". Voici un exemple :

.. figure:: /images/GUI/projeqtorflat.png

Il y a trois lignes de codes car on permet d'avoir l'image en trois taille ( 16px,22px,32px) tout en ayant qu'une seule image dans notre dossier.

On inclus donc l'image dans chaques couleurs (ProjeQtOrFlatBlue,ProjeQtOrFlatGreen,ProjeQtOrFlatRed,ProjeQtOrFlatGrey)et on l'inclus aussi en standard dans "www/projeqtorV6.1/view/css/projeqtorIcons.css".

- Derniére choses à savoir , on utilise trois fonctions pour afficher les images. 
  
  - formatSmallButton => Pour les petites icônes en 16px.
  
  - formatBigButton => Pour les icônes de 32 px.
  
  - formatIcon => Pour les images.
