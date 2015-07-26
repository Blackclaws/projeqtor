.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents:: Tickets
   :depth: 1
   :backlinks: top
   :local:

.. title:: Ticket

.. index:: ! Ticket 

Ticket
------

A ticket is a kind of task that can not be unitarily planned. 

It is generally a short time activity for a single ticket, that is interesting to follow unitarily to give a feedback to the issuer or to keep trace of result. 

It can be globally planned as a general activity, but not unitarily.

For instance, bugs should be managed through tickets : 

* you can not plan bugs before they are registered,
* you must be able to give a feedback on each bug,
* you can (or at least should) globally plan bug fixing activity. 

.. sidebar:: Other sections

   * :ref:`gui-LinkElement-section-label`
   * :ref:`gui-attachment-section-label`
   * :ref:`gui-note-section-label`
   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the ticket.
   * - **Name**
     - Short description of the ticket.
   * - **Ticket type**
     - Type of ticket.
   * - **Project**
     - The project concerned by the ticket.
   * - :term:`External reference`
     - External reference of the ticket.
   * - Urgency
     - Urgency for treatment of the ticket, as requested by the issuer.
   * - Requestor
     - Contact at the origin of the ticket.
   * - :term:`Origin`
     - Element which is the origin of the ticket.
   * - Duplicate ticket
     - Link to another ticket, to link duplicate tickets.
   * - Context
     - List of 3 items describing the context of the ticket.
   * - Product
     - The product where ticket has been identified.
   * - Original version
     - Version of product where ticket has been identified. 
   * - Description
     - Complete description of the ticket.

**\* Required field**

.. topic :: Field: Context

   * Contexts are initialized for IT Projects as “Environment”, “OS” and “Browser”. 
   * This can be easily changed in the “Contexts” definition screen.  

.. topic:: Field: Original version

   * Click on |buttonAdd| to add a other version, see :ref:`ticket-add-version-label`


.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Planning activity
     - Activity where global work for this kind of ticket is planned. 
   * - **Status**
     - Actual :term:`status` of the ticket.
   * - Responsible
     - Resource who is responsible for the ticket.
   * - Criticality
     - Importance of impact on the system, as determined after analysis.
   * - Priority
     - Priority of treatment.
   * - Initial due date
     - Initial target date for solving the ticket.
   * - Actual due date
     - Actual target date for solving the ticket.
   * - Planned work
     - Estimated workload needed to treat the ticket.
   * - Real work
     - Real workload spent to treat the ticket.
   * - Left work
     - Left workload needed to finish the ticket.
   * - :term:`Handled`
     - Flag to indicate that ticket is taken into account.
   * - :term:`Done`
     - Flag to indicate that ticket has been treated.
   * - :term:`Closed`
     - Flag to indicate that ticket is archived.
   * - Cancelled
     - Flag to indicate that ticket is cancelled.
   * - Target version
     - The target version of the product that will deliver the object of the ticket.
   * - Result
     - Complete description of the resolution of the ticket. 
 
**\* Required field**


.. topic:: Field: Planning activity

   * Work on the ticket will be included on this activity.

.. topic:: Field: Priority

   * Automatically calculated from Urgency and Criticality. 
   * Can be changed manually.

.. topic:: Field: Initial due date

   * Initial due date may be automatically calculated depending on definition of ticket delay, for given ticket type and urgency.

.. topic:: Field: Actual due date

   * Automatically initialized to Initial due date.

.. topic:: Field: Left work

   * Automatically calculated as Planned – Real, and set to zero when Ticket is done.

.. topic:: Field: Target version

   * Click on |buttonAdd| to add a other version, see :ref:`ticket-add-version-label`

.. topic:: Button: Dispatch

   * This button allows to dispatch ticket 

.. index:: ! Simple ticket 

Simple ticket
-------------

Simple Ticket is just a restricted view of Ticket, with limited write access to “Description” section, and limited view on “treatment” section.

This view is dedicated to provide access to Ticket to users who should not be able to change treatment of Tickets, such an External Team members, but can possibly create new ones. 

.. sidebar:: Other sections

   * :ref:`gui-attachment-section-label`
   * :ref:`gui-note-section-label`
   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the ticket.
   * - **Name**
     - Short description of the ticket.
   * - **Ticket type**
     - Type of ticket.
   * - **Project**
     - The project concerned by the ticket.
   * - Urgency
     - Urgency for treatment of the ticket, as requested by the issuer.
   * - Context
     - List of 3 items describing the context of the ticket.
   * - Version
     - Version of product where ticket has been identified.
   * - Description
     - Complete description of the ticket.

**\* Required field**

.. topic :: Field: Context

   * Contexts are initialized for IT Projects as “Environment”, “OS” and “Browser”. 
   * This can be easily changed in the “Contexts” definition screen.  

.. topic:: Field: Version

   * Click on |buttonAdd| to add a other version, see :ref:`ticket-add-version-label`



.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the ticket.
   * - Responsible
     - Resource who is responsible for the ticket.
   * - Initial due date
     - Initial target date for solving the ticket.
   * - Due date
     - Actual target date for solving the ticket.
   * - :term:`Handled`
     - Flag to indicate that ticket is taken into account.
   * - :term:`Done`
     - Flag to indicate that ticket has been treated.
   * - :term:`Closed`
     - Flag to indicate that ticket is archived.
   * - Cancelled
     - Flag to indicate that ticket is cancelled.
   * - Target version
     - The target version of the product that will deliver the object of the ticket.	
   * - Result
     - Complete description of the resolution of the ticket. 
 
**\* Required field**

.. note::

   * Except for status, all these fields are “readonly” and can only be updated through the Ticket view.

.. _ticket-add-version-label:

Add a other version
"""""""""""""""""""

For version fields, it possible to set multi version of product.

.. topic:: Main and other version

   * The version with smaller id will appear in the select list and is considered as the main version.
   * Other versions are listed above. 
   * It is possible to set an ‘other’ version as the main version using the button |iconSwitch|.


Click |buttonAdd| on to add a other version. A “Add other versions” pop up will be displayed. 

Click on |buttonRemove| to delete the other version.

.. figure:: /images/GUI/addOtherVersion.png
   :scale: 60 %
   :alt: GUI Add other versions Popup
   :align: center

   Add other versions Popup

.. topic:: Popup: Add other versions

   * Click on |buttonIconSearch| to show element detail.
   * Depends on whether the element is selected or not a different pop up is displayed.
   * Detail about pop up, see :ref:`gui-combo-list-fields-label`








