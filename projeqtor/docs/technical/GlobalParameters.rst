.. raw:: latex

.. title:: GlobalParameters

Paramètres Globaux
-------------------------
.. warning:: L'accès à l'écran des paramètres globaux doit être restreint aux administrateurs.
             Les paramètres globaux doivent être enregistrés avant de quitter l'écran

.. seealso:: Déplacer la souris sur la légende d'un paramètre affichera une info-bulle avec plus de description sur le paramètre

.. figure:: /images/GUI/globalparameters.png

.. figure:: /images/GUI/ldap.png

.. figure:: /images/GUI/filedirectory.png

.. figure:: /images/GUI/document.png

.. figure:: /images/GUI/cron.png

.. figure:: /images/GUI/email.png


Jusqu'à V3.4.4, il existe deux façons d'envoyer des mails:
    
    - Utilisation de la fonction php mail: cette fonction permet uniquement la connexion anonyme
    
    - En utilisant une connexion socket spécifique: cette méthode permet des connexions authentifiées
      Depuis V4.0.0 une nouvelle méthode a été introduite:
      
      - À l'aide de la bibliothèque PHPMailer: cette méthode avancée permet des connexions anonymes et authentifiées
      
Vous pouvez sélectionner la méthode en ajoutant simplement $ paramMailerType dans votre fichier parameters.php:

    - $paramMailerType = 'mail' utilisant la fonction php mail
    
    - $paramMailerType = 'socket' en utilisant une connexion de socket spécifique
    
    - $paramMailerType = 'phpmailer' en utilisant la bibliothèque PHPMailer