.. include:: ImageReplacement.txt

.. title:: Expenses

.. index:: ! Expense
.. index:: ! Project (Expense)

Expenses
========

The expenses incurred for the project are monitored.

.. contents:: Expense
   :backlinks: top
   :local:

.. index:: ! Expense (Call_for_tender)

.. _call-for-tenders:

Call for tenders
----------------

Call for tenders stores information about your needs to create a submission to call for tenders.

This can for instance be used to detail all the requests and find the best answer.

You have the possibility to create some different evaluation criterias. Thereafter you can attribute them a value in Offer.

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the call for tender.
   * - **Name**
     - Short name of the call for tender.
   * - **Type**
     - Type of tender.
   * - Project
     - Project link to call for tender.
   * - Maximum amount
     - Maximum amount of the call for tender.
   * - Expected delivery date
     - Date expected.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1
   
   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the call for tender.
   * - Responsible
     - Person responsible for the processing of this call for tender.
   * - Sent date
     - Sent date of the call for tender. 
   * - Expected answer date
     - Expected answer date, meaning expected tender date.
   * - Handled
     - Box checked indicates that the call for tender is handled with date when checked.
   * - Done
     - Box checked indicates that the call for tender is done with date when checked. 
   * - Closed
     - Box checked indicates that the call for tender is archived with date when checked.
   * - Cancelled
     - Box checked indicates that the call for tender is cancelled.

**\* Required field**


.. rubric:: Section: Submissions of tenders

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Provider
     - Provider of the tender.
   * - Contact
     - Contact for the tender. 
   * - Request date
     - Request date when tender sent with the hour.
   * - Expected answer date
     - Date expected with the hour.
   * - Tender status
     - Statut of the tender.

.. index:: ! Expense (Tenders)

.. _tenders:

Tenders
-------

Tenders store information about the responses to the call for tenders that you have submitted.

This can for instance be used to detail all the tenders and compare them to choose one of them.

If your call for tenders has evaluation criteria, you can attribute a rating for each criteria.

Evalutation will display a summary of your criterias with their ratings. 

Global rating will then be displayed on the call for tender for all concerned tenders.


.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the tender.
   * - **Name**
     - Short name of the tender.
   * - **Type**
     - Type of tender.
   * - Project
     - Project link to tender.
   * - Call for tender
     - Link to call for tender.
   * - Tender statuts
     - Statut of the tender.
   * - **Provider**
     -  Provider of the tender.
   * - External reference
     - External reference of the tender.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1
   
   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the tender.
   * - Responsible
     - Person responsible for the processing of this tender.
   * - Contact
     - Contact of the tender.
   * - Request date
     - Resquest date for tender.
   * - Expected answer date
     - Expected answer date of the tender.
   * - Date of receipt
     - Date of receipt of the tender with the hour.
   * - Offer validity
     - Offer validity date.
   * - Initial
     - Price
   * - Negotiated
     - Price of negotiated.
   * - Payment conditions
     - Type of payment conditions.
   * - Delivery delay
     - Delivery delay of the tender.
   * - Expected delivery date
     - Expected delivery date of the tender.   
   * - Handled
     - Box checked indicates that the tender is handled with date when checked.
   * - Done
     - Box checked indicates that the tender is done with date when checked. 
   * - Closed
     - Box checked indicates that the tender is archived with date when checked.
   * - Cancelled
     - Box checked indicates that the tender is cancelled.

**\* Required field**


.. index:: ! Expense (Individual)

.. _individual-expense:

Individual expense
------------------

An individual expense stores information about individual costs, such as travel costs or else.

Individual expense has detail listing for all items of expense.

This can for instance be used to detail all the expense on one month so that each user opens only one individual expense per month (per project), or detail all the elements of a travel expense.

.. rubric:: Planned amount

Planned amount will help to have an overview of project total costs, even before expense is realized.

.. sidebar:: Other sections

   * :ref:`expense-detail-lines`
   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense.
   * - **Name**
     - Short description of the expense.
   * - **Type**
     - Type of expense.
   * - **Project**
     - The project concerned by the expense.
   * - **Resource**
     - Resource concerned by the expense.
   * - :term:`Description`
     - Complete description of the expense.

**\* Required field**


.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the expense.
   * - Responsible
     - Person responsible for the processing of this expense.
   * - Planned
     - Planned amount of the expense (Date is mandatory). 
   * - Real
     - Real amount of the expense (Date is mandatory). 
   * - Payment done
     - Box checked indicates the payment is done.
   * - :term:`Closed`
     - Box checked indicates that the expense is archived.
   * - Cancelled
     - Box checked indicates that the expense is cancelled.

**\* Required field**

.. topic:: Fields: Planned & Real

   Columns:

   * **Full**: Amount.

     * Real amount is automatically updated with the sum of the amounts of detail lines.

   * **Payment date**: 

     * For field "Planned" is the planned date.
     * For field "Real" can be the payment date or else.


.. raw:: latex

    \newpage


.. index:: ! Expense (Project)

.. _project-expense:

Project expense
---------------

A project expense stores information about project costs that are not resource costs.

This can be used for all kinds of project cost : 

* Machines (rent or buy).
* Softwares.
* Office.
* Any logistic item.


.. rubric:: Purchase request

Allows to manage the purchase request information about the expense. (Purchase order, receipt and payment)


.. rubric:: Planned amount

Planned amount will help to have an overview of project total costs, even before expense is realized.


.. sidebar:: Other sections

   * :ref:`expense-detail-lines`
   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense.
   * - **Name**
     - Short description of the expense.
   * - **Type**
     - Type of expense.
   * - **Project**
     - The project concerned by the expense.
   * - Provider
     - Provider name.
   * - :term:`External reference`
     - External reference of the expense.
   * - Business responsible
     - The person who makes the purchase requisition.
   * - Financial responsible
     - The person who pays the purchase.
   * - Payment conditions
     - Conditions of payment.
   * - :term:`Description`
     - Complete description of the expense.

**\* Required field**

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
     - Actual :term:`status` of the expense.
   * - Order date
     - Date of the order.
   * - Delivery mode
     - Delivery mode for the order.
   * - Delivery delay
     - Delivery delay for the order.
   * - Expected delivery date
     - Expected delivery date for the order.
   * - Date of receipt
     - Date of receipt of the order.
   * - :term:`Closed`
     - Box checked indicates that the expense is archived.
   * - Cancelled
     - Box checked indicates that the expense is cancelled.
   * - Planned
     - Planned amount of the expense (Date is mandatory).
   * - Real
     - Real amount of the expense (Date is mandatory).
   * - Payment done
     - Box checked indicates the payment is done.
   * - Result
     - Complete description of the treatment of the expense.  
  

**\* Required field**

.. topic:: Fields: Planned & Real

   Columns:

   * **Ex VAT**: Amount without taxes.
     
     * Real amount is automatically updated with the sum of the amounts of detail lines.

   * **Tax**: Applicable tax. 

   * **Full**: Amount with taxes.

   * **Payment date**: 

     * For field "Planned" is the planned date.
     * For field "Real" can be the payment date or else.


.. raw:: latex

    \newpage

.. index::  ! Expense (Detail line)

.. _expense-detail-lines:

Expense detail lines
--------------------

.. rubric:: Section: Expense detail lines

This section is common to individual and project expenses.

It allows to enter detail on expense line.

.. topic:: Fields: Real amount and date

   * When a line is entered, expense real amount is automatically updated to sum of lines amount.
   * Real date is set with the date in the firts detail line.


.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Date
     - Date of the detail line.
   * - Name
     - Name of the detail line.
   * - Type
     - Type of expense.
   * - Detail
     - Detail depends on the type of expense.
   * - Amount
     - Amount of the detail line.


.. rubric:: Detail lines management
 
* Click on |buttonAdd| to add a detail line.
* Click on |buttonEdit| to modify an existing detail line.
* Click on |buttonIconDelete| to delete the detail line.


.. figure:: /images/GUI/BOX_ExpenseDetail.png
   :alt: Dialog box - Expense detail 
   :align: center


.. list-table:: Fields - Expense detail dialog box 
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Date
     - Date of the detail.
   * - Reference
     - External reference.
   * - **Name**
     - Name of the detail.
   * - Type
     - Type of expense.
   * - **Amount**
     - Amount of the detail.

**\* Required field**


.. topic:: Field: Date

   * This allows to input several items, during several days, for the same expense, to have for instance one expense per travel or per month.

.. topic:: Field: Type

   * Depending on type, new fields will appear to help calculate of amount.
   * Available types depending on whether individual or project expense.
   * See: :ref:`expense-detail-type`. 

.. topic:: Field: Amount 

   * Automatically calculated from fields depending on type.
   * May also be input for type “justified expense”.

