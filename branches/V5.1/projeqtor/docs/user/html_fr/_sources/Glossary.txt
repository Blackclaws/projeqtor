.. include:: ImageReplacement.txt

Glossary
--------

.. glossary::
  
   closed

* Flag to indicate that item is archived.

* Item will not appear in lists any more, unless “show closed” is checked.

.. glossary::
  
   done

* Flag to indicate that item has been done.

* Date of done is saved.


.. glossary::
  
   external reference

* This field allows fill free input.
* It uses to refer information from an external source.
* External reference value can be put in email message with **externalReference** special field.

  * More detail, see: **Administration guide**. 

.. glossary::
  
   handled

* Flag to indicate that item has been taken into account.

* Date of handling is saved.

* This generally means that Responsible has been named.

.. glossary::

   id

* Every item has a unique Id, automatically generated on creation.

* Id is chronologically affected, for all kind of items (Activity, Ticket).

* Id is shared for all projects and all types (i.e. incident) of the same kind items (i.e. Ticket).

* **Reference** is displayed after id, automatically generated on creation. 

* Reference depends on defined format, see under "Format for reference numbering" section in :ref:`administration-global-parameters-label`.




* Default format defines an numbering specific for each project and each type of items.

.. glossary::

   origin

* Determines the element of origin.

* The origin is used to keep track of events (ex.: order from quote, action from meeting).

* The origin may be selected manually or automatically inserted on copy. 

* Click on |buttonAdd| to add a orgin element. A “Add an orgin element” pop up will be displayed. 

* Click on |buttonRemove| to delete the link.

.. topic:: Pop up “Add an orgin element”

   Type of the orign  - Type of element to be selected.

   Origin element - item selected

   * Click on |buttonIconView| to search a item of element.


.. glossary::

   status

* The status determines the life cycle of items.

* It defines the progress of the treatment of the element. 

.. glossary::
   
   planning priority

* This priority allows to define planned order among planning element.

* The smaller priority element is planned first.

* The default priority is 500 (medium). 

* If projects have different priorities, all elements of project with smaller value priority are planned first.

.. glossary::

   PPD

* Price Per Day.

* It represent the cost of one work day.

.. glossary::

   WBS

* Work Breakdown Structure. 

* Hierarchical position of the element in the global planning.    
       

