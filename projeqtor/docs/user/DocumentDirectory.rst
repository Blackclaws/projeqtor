.. raw:: latex

    \newpage

.. title:: Document directories

.. index:: ! Document directory 

.. _document-directory:

Document directories
--------------------

The document directories define a structure for document storage.

The document files (defined on document version) will be stored in the folder defined as “location” in the “document root” place.

“Document root” is defined in :ref:`Global parameters <document-section>` screen. 

.. sidebar:: Other sections
   
   * :ref:`Change history<chg-history-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Description section fields 
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
     - Directory is dedicated to this project.
   * - Product
     - Directory is dedicated to this product.
   * - Default type
     - Type of document the directory is dedicated to.
   * - :term:`Closed`
     - Flag to indicate that directory is archived.
 
**\* Required field**

.. topic:: Field: Parent directory

   * The current directory is then a sub-directory of parent.

.. topic:: Field: Location

   * Location is automatically defined as “Parent directory” / “Name”.

.. topic:: Field: Project

   * New document in this directory will have default project positioned to this value.

.. topic:: Field: Product

   * New document in this directory will have default product positioned to this value.

.. topic:: Field: Default type

   * New document in this directory will have default document type positioned to this value.
