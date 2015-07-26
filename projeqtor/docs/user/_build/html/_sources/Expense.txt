.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Expense
   :depth: 2
   :backlinks: top
   :local:

.. title:: Expense

.. index:: ! Individual expense 

Individual expense
------------------

An individual expense stores information about individual costs, such as travel costs or else.

Individual expense has detail listing for all items of expense.

This can for instance be used to detail all the expense on one month so that each user opens only one individual expense per month (per project), or detail all the elements of a travel expense.

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
     - Unique Id for the expense.
   * - **Name**
     - Short description of the expense.
   * - **Type**
     - Type of expense.
   * - **Resource**
     - Resource concerned by the expense.
   * - **Project**
     - The project concerned by the expense.
   * - Description
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
   * - Planned date
     - Planned date of the expense.
   * - Planned amount
     - Planned amount of the expense. 
   * - Real date
     - Real date of the expense.
   * - Real amount
     - Real amount of the expense. 
   * - :term:`Closed`
     - Flag to indicate that expense is archived.
   * - Cancelled
     - Flag to indicate that expense is cancelled.

**\* Required field**

.. hint:: 
    
   **Planned amount** will help to have an overview of project total costs, even before expense is realized.


.. topic:: Fields: Planned date and amount
  
   * When planned date or planned amount is set, other must also be set.

.. topic:: Fields: Real date and amount

   * When real date or real amount is set, other must also be set.

.. topic:: Field: Real amount 
 
   * If detail lines are entered, real amount is automatically calculated as sum of detail amounts, and is then locked.


.. raw:: latex

    \newpage


Expense detail
^^^^^^^^^^^^^^

.. rubric:: Section: Expense detail lines

Detail of individual expense can be entered line by line :
 
Click on |buttonAdd| the corresponding section to add a detail line.
A “Expense detail” pop up will be displayed. 

Click on |buttonEdit| to modify an existing detail line.

Click on |buttonRemove| to delete the detail line.

.. compound::

   .. note::
  
      **When a line is entered, expense real amount is automatically updated to sum of lines amount.**

.. topic:: Pop up "Expense detail"

   Name - Name of the detail. 

   Date - Date of the detail.

   * This allows to input several items, during several days, for the same expense, to have for instance one expense per travel or per month.

   Type - Type of expense detail.
  
   * Depending on type, new fields will appear to help calculate of amount.

   Amount - Amount of the detail.

   * Automatically calculated from fields depending on type. May also be input for type “justified expense”.

.. raw:: latex

    \newpage


.. index:: ! Project expense

Project expense
---------------

A project expense stores information about project costs that are not resource costs.

This can be used for all kind of project cost : 

* Machines (rent or buy)
* Softwares
* Office
* Any logistic item

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
     - Unique Id for the expense.
   * - **Name**
     - Short description of the expense.
   * - **Type**
     - Type of expense.
   * - **Project**
     - The project concerned by the expense.
   * - Description
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
   * - Planned date
     - Planned date of the expense.
   * - Planned amount
     - Planned amount of the expense. 
   * - Real date
     - Real date of the expense.
   * - Real amount
     - Real amount of the expense. 
   * - :term:`Closed`
     - Flag to indicate that expense is archived.
   * - Cancelled
     - Flag to indicate that expense is cancelled.

**\* Required field**

.. hint:: 
    
   **Planned amount** will help to have an overview of project total costs, even before expense is realized.


.. topic:: Fields: Planned date and amount

   * When planned date or planned amount is set, other must also be set.

.. topic:: Fields: Real date and amount 

   * When real date or real amount is set, other must also be set.
