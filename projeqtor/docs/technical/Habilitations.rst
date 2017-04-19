.. raw:: latex

.. title:: Habilitations

Habilitations
-------------
.. index:: Généralités

.. rubric:: Généralités

Affichage des menus
      
Affichage des listes
      
Affichage des détails et accès à chaque élément
      

.. index:: getVisibleProjectsList()
     
.. rubric:: getVisibleProjectsList()
    
.. figure:: /images/GUI/getvisibleprojet.png
   
$project= si $idProject est renseigné, on prend cette valeur, sinon on prend $_SESSION['project'] c'est à dire le projet sélectionné dans le sélecteur.
      
Stocke les données en cache : $_SESSION ['visibleProjectsList'] [$keyVPL]
      
================ ================  ================  
$keyVPL           $limitToActiveProjects          
---------------- ---------------------------------- 
$project          True              False  
================ ================  ================  
Renseigné         True $project     False $project           
Non renseigné     True_*            False_*    
================ ================  ================
          
Si $project == "*" ou $project == '', on retourne la transformation en liste de
User->getVisibleProject (limitToActiveProjects)

.. index:: User->getVisibleProjects()
              
.. rubric:: User->getVisibleProjects()

.. figure:: /images/GUI/usergetvisibleprojet.png
  
Si securityGetAccessRight('menuProject', 'read')="ALL" (droits de voir tous les projets), retourne tous les projets.
Sinon, retourne tous les projets affectés (et leurs sous-projets).

Le résultat est mis en cache dans

    *$this->_visibleProjects*
         
    *$this->_visibleProjectsIncludingClosed*

.. index:: getHierarchicalViewOfVisibleProjects()
      
.. rubric:: getHierarchicalViewOfVisibleProjects()

.. figure:: /images/GUI/getHierarchicalViewOfVisibleProjects.png

Présente les projets visibles avec la structure WBS
  
Utilisé dans Today et Project->drawSubProjects()
 
.. index:: getHierarchicalViewOfVisibleProjectsWithTop()
 
.. rubric:: getHierarchicalViewOfVisibleProjectsWithTop()

Non utilisée

.. index:: User->getAccessControlRights()
  
.. rubric:: User->getAccessControlRights()

.. figure:: /images/GUI/getAccessControlRights.png
  
Pour chaque écran, retourne un élément de table de type
  
menuXxxxx=>Array(
      
"read"=>"ALL",
           
"create"=>"ALL",
           
"update"=>"ALL",
           
"delete"=>"ALL")
           
Les droits possibles sont : 
  
* ALL : tous les éléments
  
* PRO : tous les éléments des projets affectés
  
* RES : les éléments dont il est le responsable (c'est à dire tels que idResource=User->id)
  
* OWN : ses propres éléments (dont il est le créateur, c'est à dire idUser=User->id)
  
* NO  : aucun accès
  
Le résultat est mis en cache dans
 
*$this->_accessControlRights*

La fonction alimente aussi

*$this->_accessControlVisibility*

Les valeurs possibles sont "PRO" (par défaut) et "ALL" (si un des accès aux écrans est ALL)
  
.. title:: Habilitations

Mot de passe
------------

Les mots de passe sont encodés dans la base de données de manière non bijective.
Il n'est donc pas possible de retrouver un mot de passe.
Si un utilisateur a perdu son mot de passe, il faut donc que l'administrateur lui réinitialise sont mot de passe à partir de l'écran "utilisateur"
Le mot de passe est alors réinitialisé avec la valeur indiquée sur l'écran des paramètres globaux.
Mais si c'est l'administrateur qui a perdu sont mot de passe c'est plus problématique, à moins de disposer d'un second compte administrateur qui pourra réinitialiser le mot de passe de son collègue.
Il existe cependant une manière détournée de réinitilaiser un mot de passe en agissant directment sur la base de données :

Dans la table "resource" accéder à la ligne de l'utilisateur concerné (l'administrateur créé par défaut a l'id=1), et modifier :
 * password => entrer le mot de passe en clair
 * crypto => mettre ce champ à Null (la valeur Null, pas une chaîne contenant "Null")
Le mot de passe devra alors être modifié à la première connexion pour être encodé. 
