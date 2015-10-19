.. raw:: latex

    \newpage

.. contents:: Quotation and Order
   :depth: 1
   :backlinks: top
   :local:

.. title:: Quotation and Order

.. index:: ! Quotation 

.. _quotation:

Quotations
----------

A quotation is a proposal estimate sent to customer to get approval of what’s to be done, and how must the customer will pay for it.

On the quotation form, you can record all the information about the sent proposal, including attaching some file completely describing the proposal with details terms and conditions.

.. rubric:: Transform quotation to order

* A quotation can be copied into an order when corresponding document is received as customer agreement.


--------------

.. glossary::

   PPD

    * Price Per Day.
    * It represent the cost of one work day.

--------------

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
     - Unique Id for the quotation.
   * - **Name**
     - Short description of the quotation.
   * - **Quotation type**
     - Type of quotation.
   * - **Project**
     - The project concerned by the quotation.
   * - :term:`Origin`
     - Element which is the origin of the quotation.
   * - Customer
     - Customer concerned by the quotation.
   * - Contact
     - Contact in customer organization to whom you sent the quotation.
   * - :term:`Request<Description>`
     - Request description.
   * - Additional info.
     - Any additional information about the quotation.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the quotation.
   * - :term:`Responsible`
     - Resource who is responsible for the quotation.
   * - Sent date
     - Date when quotation is sent to customer contact.
   * - Offer validity
     - Limit date of the validity of the proposal.
   * - :term:`Handled`
     - Flag to indicate that quotation is taken into account.
   * - :term:`Done`
     - Flag to indicate that quotation is done (execution processed).
   * - :term:`Closed`
     - Flag to indicate that quotation is archived.
   * - Cancelled
     - Flag to indicate that quotation is cancelled.
   * - Estimated work
     - Work days corresponding to the quotation.
   * - :term:`PPD`
     - Price Per Day for the quotation.
   * - Planned amount
     - Total amount of the quotation.  
   * - Planned end date
     - Target end date of the activity object of the quotation.
   * - Activity type
     - Type of the activity object of the quotation.  
   * - Comments
     - Comment about the treatment of the quotation.

**\* Required field**

.. topic:: Field: Planned amount
     
   * Planned amount = Planned work * PPD.

.. hint:: Activity type

   * The activity should be created only after approval.



.. raw:: latex

    \newpage


.. index:: ! Order 

.. _order:

Orders
------

An order (also called command) is the trigger to start work.

On the order form, you can record all the information of the received order.

.. rubric:: Work on the activity

* An order can be linked to an activity. It then represents the command of the work on the activity.
* In that case, validated work of the activity is the sum of the orders linked to the activity.

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
     - Unique Id for the order.
   * - **Name**
     - Short description of the order.
   * - **Order type**
     - Type of order.
   * - Project
     - The project concerned by the order.
   * - Customer
     - Customer concerned by the order.
   * - Contact
     - Contact in customer organization to whom you sent the order.
   * - **External reference**
     - :term:`External reference` of the order (as received).
   * - :term:`Origin`
     - Element which is the origin of the order.
   * - Description
     - Complete description of the order.
   * - Additional info.
     - Any additional information about the order.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Linked activity
     - Activity representing the execution of the order.
   * - **Status**
     - Actual :term:`status` of the order.
   * - :term:`Responsible`
     - Resource who is responsible for the order.
   * - :term:`Handled`
     - Flag to indicate that order is taken into account.
   * - :term:`Done`
     - Flag to indicate that order is done (execution processed).
   * - :term:`Closed`
     - Flag to indicate that order is archived.
   * - Cancelled
     - Flag to indicate that order is cancelled.
   * - Work
     - Work days corresponding to the order.
   * - :term:`PPD`
     - Price Per Day for the order.
   * - Amount
     - Total amount of the order.  
   * - Activity type
     - Type of the activity object of the order.
   * - Start date
     - Initial start date of the execution of the order.
   * - End date 
     - Initial and validated end date of the execution of the order. 
   * - Comments
     - Comment about the treatment of the order.

**\* Required field**

.. topic:: Fields: Work, PPD and Amount

   Columns:

   * **Initial** : Initial values.
   * **Amendment** : Additionnal values.
   * **Validated** : Sum of the initial values and amendment.

   Calculation:

   * Amount = Work * PPD.

.. topic:: Fields: Start and end date

   * **Initial** : Initial dates
   * **Validated** : Validated dates

.. hint:: Activity type

   * The activity should be created only after approval.

