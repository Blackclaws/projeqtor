.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Bill
   :depth: 2
   :backlinks: top
   :local:

.. title:: Bill

.. index:: ! Bill 

Bill
----

A bill is a request for payment for delivered work.

Billing will depend on billing type defined for the bill.

Each bill is linked to project, a project has a project type, and a project type is linked to a billing type.

So billing type is automatically defined from selected project. 

.. sidebar:: Other sections

   * :ref:`gui-LinkElement-section-label`
   
   * :ref:`gui-attachment-section-label`
   
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
     - Unique Id for the bill.
   * - **Name**
     - Short description of the bill.
   * - **Bill type**
     - Type of bill.
   * - **Project**
     - The project concerned by the bill.
   * - Customer
     - Customer who will pay for the bill.
   * - Bill contact
     - Contact who will receive the bill.
   * - Recipient
     - Recipient who will receive the payment for the bill.
   * - :term:`Origin`
     - Element which is the origin of the bill.
   * - Billing type
     - Type of billing **(Read only)**.

**\* Required field**

.. topic:: Field: Bill type

   * Default types of bill are :
     
     * Partial  
     * Final
     * Complete

.. topic:: Field: Customer  
     
   * Automatically updated from project customer.

.. topic:: Field: Billing type  
     
   * Calculated from project, project type, billing type.
   * Will influence bill lines format.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Bill id
     - Id of bill.
   * - **Status**
     - Actual :term:`status` of the bill.
   * - :term:`Done`
     - Flag to indicate that bill has been treated.
   * - :term:`Closed`
     - Flag to indicate that bill is archived.
   * - Cancelled
     - Flag to indicate that bill is cancelled.
   * - Untaxed amount
     - Amount for the bill, without taxes.
   * - Tax
     - Tax rate.
   * - Full amount
     - Amount for the bill, including taxes.
   * - Comments
     - Comments for the bill.

**\* Required field**

.. topic:: Field: Bill id

   * Calculated when status of bill is “done”, taking into account “start number for bill” defined in :ref:`administration-global-parameters-label`.

**\* Required field**

.. raw:: latex

    \newpage

Bill lines
^^^^^^^^^^

.. rubric:: Section: Bill lines

Input for each bill line depends on billing type.

Click on |buttonAdd| the corresponding section to add a bill line. A “Bill line” pop up will be displayed depends on billing type. 

Click on |buttonEdit| to modify an existing bill line.

Click on |buttonRemove| to delete the bill line.

.. rubric:: Fields of bill line

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - N°
     - Number of the line for the bill.
   * - Quantity
     - Quantity of billed element.
   * - Description
     - Description of the line.
   * - Detail
     - Detail of the line.
   * - Price
     - Unitary price of billed element.
   * - Sum
     - Total price for the line = Price x Quantity.
   * - Term
     - Billed term for “At terms” bill.
   * - Resource
     - Resource whose work is billed.
   * - Activity price
     - Activity price defining the billed activity type.
   * - Start date
     - Start date of the period to take into account work to be billed.
   * - End date
     - End date of the period to take into account work to be billed.

.. topic:: Fields: Description & Detail

   * Automatically created depending on billing type.
   * Can be modified on update.

.. topic:: Fields: Resource, Activity price, Start date et End date

   * Available only on produced work and capped produced work bill.



.. raw:: latex

    \newpage

.. index:: ! Billing type 

.. _bill-billing-type-label:

Billing type
^^^^^^^^^^^^

.. rubric:: At terms

* A term must be defined to generate the bill, generally following a billing calendar.
* Used for instance for: **Fixed price projects**.

.. rubric:: On produced work

* No term is needed, the billing will be calculated based on produced work for resources on selected activities, on a selected period.
* Used for instance for: **Time & Materials projects**.

.. rubric:: On capped produced work

* No term is needed, the billing will be calculated based on produced work for resources on selected activities, on a selected period, taking into account validated work so that total billing cannot be more than validated work.
* Used for instance for: **Capped Time & Materials projects**.

.. rubric:: Manual billing
 
* Billing is defined manually, with no link to the project activity.
* Used for instance for: **Any kind of project where no link to activity is needed**.

.. rubric:: Not billed

* No billing is possible for these kinds of projects.
* Used for instance for: **internal projects, administrative projects**


.. raw:: latex

    \newpage

.. index:: ! Term 

Term
----

A term is a planned trigger for billing.

You can define as many terms as you wish, to define the billing calendar.

.. rubric:: Activities as triggers

* You may insert activities as triggers.
* the activities that should be billed at this term.
* This is a help (as a reminder) as the summary for activities is displayed for validated and planned amount and end date. You can then define the term amount and date corresponding to these data.

.. note::

   Terms are mandatory to bill “Fixed price” project.

.. sidebar:: Other sections

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
     - Unique Id for the term.
   * - **Name**
     - Short description of the term.
   * - **Project**
     - The project concerned by the term.
   * - Bill
     - Bill name that uses these term.
   * - :term:`Closed`
     - Flag to indicate that term is archived

**\* Required field**

.. rubric:: Section: Fixed price for term

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Real amount
     - Defined amount for term.
   * - Real date
     - Defined date for term.
   * - Validated amount 
     - Sum of validated amounts of activities defined as triggers **(Read only)**.
   * - Validated date
     - Max of validated end dates of activities defined as triggers **(Read only)**.
   * - Planned amount
     - Sum of planned amounts of activities defined as triggers **(Read only)**.
   * - Planned date
     - Max of validated end dates of activities defined as triggers **(Read only)**.

.. topic:: Fields: Amount and Date (Planned & Validated)

   * When a trigger is entered, planned and validated values are automatically updated to sum and max of triggers amount.

.. rubric:: Section: Trigger element for the term

Click on |buttonAdd| the corresponding section to add a trigger. A pop up will be displayed. 

Click on |buttonRemove| to delete the trigger.

.. topic:: Pop up “Add an Predecessor to element”

   Linked element type  - Type of element to be selected.

   Linked element - item selected

   * Click on |buttonIconView| to search a item of element.

.. index:: ! Activity Price 

Activity Price
--------------

Activity price defines daily price for activities of a given **activity type** and a given **project**.

This is used to calculate bill amount for billing type **produced work** and **capped produced work**.

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
     - Unique Id for the activity price.
   * - Name
     - Short description of the activity price.
   * - **Project**
     - The project concerned by the activity price.
   * - **Activity type**
     - Type of activities concerned by the activity price.
   * - Price of the activity
     - Daily price of the activities of the given activity type and the given project.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that activity price is archived

**\* Required field**







