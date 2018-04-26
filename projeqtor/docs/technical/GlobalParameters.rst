.. raw:: latex

.. title:: GlobalParameters

Paramètres Globaux
------------------
.. warning:: L'accès à l'écran des paramètres globaux doit être restreint aux administrateurs.
             Les paramètres globaux doivent être enregistrés avant de quitter l'écran

.. seealso:: Déplacer la souris sur la légende d'un paramètre affichera une info-bulle avec plus de description sur le paramètre

.. figure:: /images/GUI/globalparameters.png

.. figure:: /images/GUI/ldap.png
   
   Pour accéder à un serveur AD (Microsoft Active Directory), le paramétrage est un peu spécifique et surtout différent du paramétrage standard LDAP.
   user ldap : ne pas ajouter la chaîne de connexion LDAP, seul le nom d'utilisateur, avec éventuellement le nom de domaine Domaine\User
   search string : sAMAccountName=%username%  
   
   ** TODO : Exemples
   $paramLdap_user_filter = 'uid=%USERNAME%'; // Standard, marche par défaut pour Open Ldap 
   $paramLdap_user_filter = 'sAMAccountName=%USERNAME%'; // Pour AD
   $paramLdap_user_filter = 'cn=%USERNAME%'; // Peut aussi marcher pour AD
   $paramLdap_user_filter = '(&(objectCategory=person)(objectClass=user)(givenName=*)(sn=*))'; // Autre exemple

.. figure:: /images/GUI/filedirectory.png

.. figure:: /images/GUI/document.png

.. figure:: /images/GUI/cron.png

.. figure:: /images/GUI/email.png


Jusqu'à V3.4.4, il existe deux façons d'envoyer des mails :
    
    - Utilisation de la fonction php mail : cette fonction permet uniquement la connexion anonyme
    
    - En utilisant une connexion socket spécifique : cette méthode permet des connexions authentifiées.
      Depuis V4.0.0 une nouvelle méthode a été introduite :
      
      - À l'aide de la bibliothèque PHPMailer : cette méthode avancée permet des connexions anonymes et authentifiées
      
Vous pouvez sélectionner la méthode en ajoutant simplement $paramMailerType dans votre fichier parameters.php :

    - $paramMailerType = 'mail' utilisant la fonction php mail
    
    - $paramMailerType = 'socket' en utilisant une connexion de socket spécifique
    
    - $paramMailerType = 'phpmailer' en utilisant la bibliothèque PHPMailer