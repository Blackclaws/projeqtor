.. raw:: latex

.. title:: Habilitations

Habilitations
-----------------
.. index:: Généralités

.. rubric:: Généralités

Affichage des menus
      
Affichage des listes
      
Affichage des détails et accés à chaque éléments
      

.. index:: getVisibleProjectsList()
     
.. rubric:: getVisibleProjectsList()
    
.. figure:: /images/GUI/getvisibleprojet.png
   
$project= si $idProject est renseigné, on prend cette valeur , sinon on prend $_SESSION['project'] c'est à dire le projet selectionné dans le sélécteur.
      
Stocke les données en cache : $_SESSION ['visibleProjectsList'] [$keyVPL]
      
================ ================  ================  
$keyVPL           $limitToActiveProjects          
---------------- ---------------------------------- 
$project          True              False  
================ ================  ================  
Renseigné         True $project     False $project           
Non renseigné     True_*            False_*    
================ ================  ================
          
Si $project == "*" ou $project == '' , on retourne la transformation en liste de
User->getVisibleProject (limitToActiveProjects)

.. index:: User->getVisibleProjects()
              
.. rubric:: User->getVisibleProjects()

.. figure:: /images/GUI/usergetvisibleprojet.png
  
Si securityGetAccessRight('menuProject','read')="ALL" ( droits de voir tous les projets),retourne tous les projets.
Sinon , retourne tous les projets affectés ( et leurs sous projets).

Le résultat est mise en cache dans

    *$this->_visibleProjects*
         
    *$this->_visibleProjectsIncludingClosed*

.. index:: getHierarchicalViewOfVisibleProjects()
      
.. rubric:: getHierarchicalViewOfVisibleProjects()

.. figure:: /images/GUI/getHierarchicalViewOfVisibleProjects.png

Présente les projetcs visibles avec la structure WBS
  
Utilisé dans Today et Project->drawSubProjects()
 
.. index:: getHierarchicalViewOfVisibleProjectsWithTop()
 
.. rubric:: getHierarchicalViewOfVisibleProjectsWithTop()

Non utilisée

.. index:: User->getAccessControlRights()
  
.. rubric:: User->getAccessControlRights()

.. figure:: /images/GUI/getAccessControlRights.png
  
Pour chaque écran,retourne un élément de table de type
  
menuXxxxx=>Array(
      
"read"=>"ALL",
           
"create"=>"ALL",
           
"update"=>"ALL",
           
"delete"=>"ALL")
           
Les droits possibles sont : 
  
* ALL : tous les éléments
  
* PRO : tous les éléments des projets affectés
  
* RES : les éléements dont il est le responsables (c'est à dire tels que idResource=User->id)
  
* OWN : ses propres éléments ( dont il est le créateur,c'est à dire idUser=User->id)
  
* NO  : aucun accès
  
Le résultat est mise en cache dans
 
*$this->_accessControlRights*

La fonction alimente aussi

*$this->_accessControlVisibility*

Les valeurs possibles sont "PRO" (par défaut) et "ALL"(si un des accès aux écrans est ALL)
  
  
===============================================    ===================================================================    =================================================    
--                                                  --                                                                    profil par projet    
               
Affichage menu                                     | Profil principal
                                                                                    
Affichage liste d'éléments                                               
                                                                    
Affichage détail d'un éléments                                
          
Droits CRUD sur un élément                                        

Droits spécifique                                                                                                

Accés aux états                          
                                                   
Affichage contenu des états                 
                                                                                                                                                                                  
===============================================    ===================================================================    ================================================= 