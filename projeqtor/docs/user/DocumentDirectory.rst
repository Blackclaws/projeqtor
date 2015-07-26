.. raw:: latex

    \newpage

.. title:: Document Directory

.. index:: ! Document Directory 

Document Directory
------------------

The document directories define a structure for document storage.

The document files (defined on document version) will be stored in the folder defined as “location” in the “document root” place.

“Document root” is defined in the global parameters file. 

.. sidebar:: Other sections
   
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the directory.
   * - **Name**
     - Name of the directory.
   * - Parent directory
     - Name of the parent directory to define hierarchic structure.
   * - Location
     - Folder where files will be stored.
   * - Project
     - Project the directory is dedicated to.
   * - Product
     - Product the directory is dedicated to.
   * - Default type
     - Type of document the directory is dedicated to.
   * - :term:`Closed`
     - Flag to indicate that directory is archived.
 
**\* Required field**

.. topic:: Field: Name

   * Location will automatically be “parent location” / “name”. 

.. topic:: Field: Parent directory

   * The current directory is then a sub-directory of parent.

.. topic:: Field: Location

   * Location is automatically defined as “parent location” / “name”.
   * Location is defined relatively to “document root”, defined in global parameters.

.. topic:: Field: Project

   * New document in this directory will have default project positioned to this value.

.. topic:: Field: Product

   * New document in this directory will have default product positioned to this value.

.. topic:: Field: Default type

   * New document in this directory will have default document type positioned to this value.
