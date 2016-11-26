.. raw:: latex

.. title:: Deployment

Déploiement / Migration
---------------------------
.. rubric:: Déploiement initial

.. rubric:: Migration vers nouvelle version

J-3:
  - Annonce par un message en page de login :"Le xx/xx/xxxx l'application sera fermée à xx heure pour une opération de maintenance"
      
H-1:
  - Fermeture de l'application
  - Envoie d'un message de rappel " fermeture dans une heure"
      
H:
  - Déconnexion des derniers utilisateurs connectés
  - Installation de la nouvelle version (repopie du code pour écraser l'existant)
  - Déconnexion/reconnexion admin
  - Vérifications (VABF)
  - Réouverture de l'application