.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents:: Bill
   :depth: 2
   :backlinks: top
   :local:

.. title:: Bill

.. index:: ! Bill

.. _bill:

Bills
-----

A bill is a request for payment for delivered work.

Billing will depend on billing type defined for the project.

---------------

.. glossary::

   Billing types

----------------

    Each bill is linked to project, a project has a project type, and a project type is linked to a billing type.
    
    So the billing type is automatically defined for the selected project. 
    
    Billing type will influence bill line format.

----------------

    **At terms**

    * A :ref:`term <term>` must be defined to generate the bill, generally following a billing calendar.
    * Used for instance for: **Fixed price projects**.

    **On produced work**

    * No term is needed.
    * The billing will be calculated based on produced work for resources on selected :ref:`activities <activity-price>`, on a selected period.
    * Used, for instance for: **Time & Materials projects**.

    **On capped produced work**

    * No term is needed.
    * The billing will be calculated based on produced work for resources on selected :ref:`activities <activity-price>`, on a selected period. 

    * Used, for instance for: **Capped Time & Materials projects**.

    .. note::

       * Taking into account that total billing cannot be more than project validated work.

    **Manual**
 
    * Billing is defined manually, with no link to the project activity.
    * Used, for instance for: **Any kind of project where no link to activity is needed**.

    **Not billed**

    * No billing is possible for these kinds of projects.
    * Used, for instance for: **Internal projects & Administrative projects**.

---------------

.. raw:: latex

    \newpage

.. sidebar:: Other sections

   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   
   * :ref:`Change history<chg-history-section>`

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
   * - Date
     - Date of the bill.
   * - Customer
     - Customer who will pay for the bill.
   * - Bill contact
     - Contact who will receive the bill.
   * - Recipient
     - Recipient who will receive the payment for the bill.
   * - :term:`Origin`
     - Element which is the origin of the bill.
   * - Billing type
     - Project billing type.

**\* Required field**

.. topic:: Fields: Customer & Bill contact 
     
   * Automatically updated from project fields.

.. raw:: latex

    \newpage

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the bill.
   * - :term:`Done`
     - Flag to indicate that the bill has been treated.
   * - :term:`Closed`
     - Flag to indicate that the bill is archived.
   * - Cancelled
     - Flag to indicate that the bill is cancelled.
   * - Untaxed amount
     - Amount of the bill, without taxes.
   * - Tax
     - Tax rate.
   * - Full amount
     - Amount of the bill, including taxes.
   * - :term:`Comments<Description>`
     - Comments for the bill.

**\* Required field**

.. topic:: Field: Untaxed amount
  
   * The amount is the sum of bill lines.
   * Used only for at terms and manual billing types.

.. topic:: Field: Tax

   * Automatically updated from customer field.  


.. raw:: latex

    \newpage

.. rubric:: Section: Bill lines

Input for each bill line depends on billing type.

.. tabularcolumns:: |l|l|

.. list-table:: Bill lines fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the bill line.
   * - N°
     - Number of the line for the bill.
   * - Description
     - Description of the line.
   * - Detail
     - Detail of the line.
   * - Price
     - Unitary price of billed element.
   * - Quantity
     - Quantity of billed element.
   * - Sum
     - Total price for the line (Price x Quantity).
 
.. rubric:: Bill lines management

* Click on |buttonAdd| to add a bill line. A different “Bill line” dialog box will be displayed depends on billing type. 
* Click on |buttonEdit| to modify an existing bill line.
* Click on |buttonRemove| to delete the bill line.


.. raw:: latex

    \newpage

.. rubric:: Bill line: At terms

.. figure:: /images/GUI/BOX_BillLineAtTerms.png
   :alt: Bill line dialog box - At terms 
   :align: center

   Bill line dialog box - At terms

.. tabularcolumns:: |l|l|

.. list-table:: Bill line dialog box fields - At terms
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - N°
     - Number of the line for the bill.
   * - Quantity
     - Quantity of billed element.
   * - **Term**
     - Project terms to be selected.
   * - Description
     - Description of line.
   * - Detail
     - Detail of the line.
   * - Price
     - Real amount of term.

**\* Required field**

.. topic:: Field: Description
 
   * Automatically set with the term name.
   * Can be modified on update.

.. topic:: Field: Detail

   * Can be set on update.









.. raw:: latex

    \newpage


.. rubric:: Bill line: On produced work & On capped produced work

.. figure:: /images/GUI/BOX_BillLineOnProduceWork.png
   :alt: Bill line dialog box - On produced work & On capped produced work
   :align: center

   Bill line dialog box - On produced work & On capped produced work

.. list-table:: Bill line dialog box fields - On produced work & On capped produced work
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - N°
     - Number of the line for the bill.
   * - Quantity
     - Not applicable.
   * - **Resource**
     - Project resources to be selected.
   * - **Activity price**
     - Project activities price to be selected.
   * - **Start date**
     - Start date of the period to take into account.
   * - **End date**
     - End date of the period  to take into account.
   * - Description
     - Description of line.
   * - Detail
     - Detail of the line.
   * - Price
     - Price of the activity.

**\* Required field**

.. topic:: Field: Description
 
   * Automatically set with selected resource, activity price name and dates.
   * Can be modified on update.

.. topic:: Field: Detail

   * Can be set on update.


.. raw:: latex

    \newpage

.. rubric:: Bill line: Manual billing

.. figure:: /images/GUI/BOX_BillLineManual.png
   :alt: Bill line dialog box - Manual billing 
   :align: center

   Bill line dialog box - Manual billing

.. tabularcolumns:: |l|l|

.. list-table:: Bill line dialog box fields - Manual billing
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
 

.. raw:: latex

    \newpage

.. index:: ! Bill (Term)

.. _term:

Terms
-----

A term is a planned trigger for billing.

You can define as many terms as you wish, to define the billing calendar.

.. note::

   * Terms are mandatory to bill “Fixed price” project.
   * A term can be used just one time. The name bill will be displayed.

.. rubric:: A term has triggers

* You can link the activities that should be billed at this term.
* A summary of activities is displayed for validated and planned amount and end date.
* Validated and planned values play the role of reminder.
* You can use these values to set real amount and date.


.. sidebar:: Other sections

   * :ref:`Notes<note-section>`   
   * :ref:`Change history<chg-history-section>`

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
     - The project concerned with the term.
   * - Bill
     - Bill name that uses this term.
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
     - Defined amount for the term.
   * - Real date
     - Defined date for the term.
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

This section allows to manage element trigger.

.. rubric:: Trigger element management

* Click on |buttonAdd| to add an element trigger. 
* Click on |buttonRemove| to delete an element trigger.

.. figure:: /images/GUI/BOX_AddTriggerElementToTerm.png
   :alt: Add a trigger element to term dialog box
   :align: center

   Add a trigger element to term dialog box


.. list-table:: Add a trigger element to term dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Linked element type
     - Type of element to be selected (Activity, Meeting, Milestone, Project, Test session).
   * - Linked element
     - Item to be selected.

.. raw:: latex

    \newpage

.. index:: ! Bill (Activity Price)

.. _activity-price:

Activities prices
-----------------

Activity price defines daily price for activities of a given **activity type** and a given **project**.

This is used to calculate a billing amount for billing type **On produced work** and **On capped produced work**.

.. sidebar:: Other sections

   * :ref:`Change history<chg-history-section>`

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
     - The project concerned with the activity price.
   * - **Activity type**
     - Type of activities concerned with the activity price.
   * - Price of the activity
     - Daily price of the activities of the given activity type and the given project.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that activity price is archived.

**\* Required field**







