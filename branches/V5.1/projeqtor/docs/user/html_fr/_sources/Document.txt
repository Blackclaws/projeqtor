.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. title:: Document

.. index:: ! Document 

Document
--------

A document is a referential element that give description to a product or a project.

A global definition of a document refers to any kind of information.

This means that a document can be a file (text document, image, …) or any non digital item (paper mail, fax, …), or non file digital item (email, …).

In ProjeQtOr, documents will reference files item, that will be stored in the tool as versions.

So a document will always refer to a directory where the file is stored.

The Document item describes general information about the document.

The file is not stored at this level.

A document can evolve and a new file is generated at each evolution.

So files are stored at document version level.

.. raw:: latex

    \newpage

.. rubric:: Versioning type

A document can evolve following 4 ways defined as versioning type :

.. topic:: Evolutive

   * Version is a standard Vx.y format. 
   * It is the most commonly used versioning type.
   * Major updates increase x and reset y to zero. 
   * Minor updates increase y.

.. topic:: Chronological

   * Version is a date. 
   * This versioning type is commonly used for periodical documents
   * For instance : weekly boards.

.. topic:: Sequential

   * Version is a sequential number. 
   * This versioning type is commonly used for recurring documents
   * For instance : Meeting reviews.

.. topic:: Custom

   * Version is manually set. 
   * This versioning type is commonly used for external documents, when version is not managed by the tool, or when the format cannot fit any other versioning type.

.. sidebar:: Other sections

   * :ref:`gui-LinkElement-section-label`
   * :ref:`gui-note-section-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the document.
   * - **Name**
     - Short description of the document.
   * - **Type**
     - Type of document.
   * - Project
     - The project concerned by the document.
   * - Product
     - The product concerned by the document.
   * - **Directory**
     - Place where the document is stored  to organize document structure. 
   * - Document reference
     - Document reference name.
   * - :term:`External reference`
     - External reference of the document.
   * - Author
     - User or Resource or Contact who created the document. 
   * - :term:`Closed`
     - Flag to indicate that document is archived.
   * - Cancelled
     - Flag to indicate that document is cancelled.

**\* Required field**

.. note::

   * A document must be linked either to a project (for project documentation) or to a product (for product document).

.. topic:: Field: Directory
   
   * The directory also defines the place where files will be physically stored.

.. topic:: Field: Document reference

   * Document reference name is calculated from format defined in the Global Parameters screen

.. topic:: Field: Author

   * Positioned by default as the connected user.
   * Can be changed (for instance if the author is not  the current user).

.. raw:: latex

    \newpage

.. rubric:: Section: Versions

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Versioning type**
     - Type of versioning for the document.
   * - Last version
     - Caption of the last version of the document.
   * - :term:`Status`
     - Status of the last version of the document.
 
**\* Required field**


.. topic:: Field: Versioning type

   * This will impact the version number format for versions.

.. rubric:: Version management

Click |buttonAdd| on to add a new version. A “Document version” pop up will be displayed. 

Click on |buttonEdit| to modifiy the document version.

Click on |buttonRemove| to delete the version.

Click on |iconDownload| to download file at this version.

.. figure:: /images/GUI/documentVersion.png
   :scale: 60 %
   :alt: GUI document version Popup
   :align: center

   Document version Popup


.. tabularcolumns:: |l|l|

.. list-table::  Document version fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - File
     - Locale file that will be uploaded as new version.
   * - Last version
     - Caption of the last existing version.
   * - Update
     - Importance of the update concerned by the new version.
   * - New version
     - New caption for the created version.
   * - Date
     - Date of the version.
   * - Status
     - Current status of the version.
   * - Is a reference
     - Flag to set that this version is the new reference of the document.
   * - Description
     - Description of the version.

.. topic:: Field: Update

   * A version can have a draft status, that may be removed afterwards.

.. topic:: Field: Is a reference

   * Should be checked when version is validated.
   * Only one version can be the reference for a document.
   * Reference version is displayed in bold format in the versions list.

.. topic:: Field: Description
   
   * May be used to describe updates brought by the version.

.. rubric:: Section: Approvers

It is possible to define approvers of a document.

When creating an approver in the list, the approver is also automatically added to the latest version of the document.

When adding a version to the document, the approvers are automatically added to the version.

.. topic:: Approval of documents

   * When an approver looks at the document, he can see a button "approve now" in the approver list.
   * Just click on the button to approve the latest version of the document.
   * When all approvers have approved the document version, it is considered as approved and then appears with a check in the list of versions.

.. tabularcolumns:: |l|l|

.. list-table:: Approvers section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Id
     - Id of the approver.
   * - Name
     - Name of the approver.
   * - Status
     - Status of the approval of the last version of document.
 
.. rubric:: Select an approver


Click |buttonAdd| on to add a new approver. A “Select an approver” pop up will be displayed. 

Click on |buttonRemove| to delete the approver.

.. figure:: /images/GUI/selectApprover.png
   :scale: 60 %
   :alt: GUI Select an approver Popup
   :align: center

   Select an approver Popup

.. topic:: Select an approver Popup

   * Click on |buttonIconSearch| to show element detail.
   * Depends on whether the element is selected or not a different pop up is displayed.
   * Detail about pop up, see :ref:`gui-combo-list-fields-label`

.. rubric:: Button: Send a reminder email to the approvers

* This button allows to send a reminder email to all the approvers who have not yet approved the document.


.. rubric:: Section: Lock

.. topic:: Button: lock/unlock this document

   * Button to lock or unlock the document to preserve it from being editing, or new version added.
   * When document is locked it cannot be modified.
   * Only the user who locked the document, or a user with privilege to unlock any document, can unlock it.

.. topic:: Document locked

   * When document is locked the next fields are set.

   .. tabularcolumns:: |l|l|

.. list-table:: Fields when document is locked
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Locked
     - Flag to indicated that the document is locked.
   * - Locked by
     - User who locked the document.
   * - Locked since
     - Date and time when document was locked.

