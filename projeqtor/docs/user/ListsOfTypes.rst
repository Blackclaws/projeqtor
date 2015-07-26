.. raw:: latex

    \newpage


.. contents:: Lists of types
   :depth: 1
   :backlinks: top
   :local:

.. title:: Lists of types


.. index:: ! Project - type

.. _project-type-label:

Project type
------------

Project type is a way to define common behavior on group of projects.

Some important behavior will depend on code :

.. index:: project operational

.. rubric:: OPE : Operational project

Most common project to follow activity.

.. index:: project administrative

.. rubric:: ADM : Administrative project

Type of project to follow non productive work : holidays, sickness, training, …
Every resource will be able to enter some real work on such projects, without having to be affected to the project, nor assigned to project activities.
Assignments to all project task will be automatically created for users to enter real work.

.. index:: project template
.. rubric:: TMP : Template project 

These projects will not be used to follow some work.
They are just designed to define templates, to be copied as operational projects.
Any project leader can copy such projects, without having to be affected to them.

.. note::

   All new types are created with **OPE** code.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - Billing type
     - Will define billing behavior (see: :ref:`bill-billing-type-label`).
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. index:: ! Ticket - type

Ticket type
-----------

Ticket type is a way to define common behavior on group of tickets.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. raw:: latex

    \newpage

.. index:: ! Activity - type

Activity type
-------------

Activity type is a way to define common behavior on group of activities.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. index:: ! Milestone - type

Milestone type
--------------

Milestone type is a way to define common behavior on group of milestones.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

  
.. raw:: latex

    \newpage

.. index:: ! Quotation - type

Quotation type
--------------

Quotation type is a way to define the way the concerned activity should be billed.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. index:: ! Order - type

Order type
----------

Order type is a way to define the way the activity references by the order will be billed.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. raw:: latex

    \newpage

.. index:: ! Individual expense - type

Individual expense type
-----------------------

Individual expense type is a way to define common behavior on group of individual expense.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. index:: ! Project expense - type

Project expense type
--------------------

Project expense type is a way to define common behavior on group of project expense.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Expense detail - type

Expense detail type
-------------------

Expense detail type is a way to define common behavior and calculation mode on group of expense details.

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
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Sort order
     - Number to define order of display in lists.
   * - Value / unit
     - Define calculation mode for the detail type. 
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. topic:: Field: Value / unit
   
    * If unit is set and not value, this line will be imputable.
    * If both unit and value are set, the line will be read only.
    * Result cost will be the multiplication between each of the three non empty line values.

.. rubric:: Section: Scope

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Individual expense
     - Details type of individual expense.
   * - Project expense
     - Details type of project expense.

.. raw:: latex

    \newpage

.. index:: ! Bill - type

Bill type
---------

Bill type is a way to define common behavior on group of bills.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. index:: ! Risk - type

Risk type
---------

Risk type is a way to define common behavior on group of risks.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage


.. index:: ! Opportunity - type

Opportunity type
----------------

Opportunity type is a way to define common behavior on group of opportunities.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**




.. index:: ! Action - type

Action type
-----------

Action type is a way to define common behavior on group of actions.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Issue - type

Issue type
-----------

Issue type is a way to define common behavior on group of issues.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**



.. index:: ! Meeting - type

Meeting type
------------

Meeting type is a way to define common behavior on group of meetings.

Meeting type is also used for periodic meetings definition.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. raw:: latex

    \newpage

.. index:: ! Decision - type

Decision type
-------------

Decision type is a way to define common behavior on group of decisions.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**





.. index:: ! Question - type

Question type
-------------

Ticket type is a way to define common behavior on group of tickets.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Message - type

Message type
------------

Message type is a way to define common behavior on group of messages (appearing on today screen).

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Color
     - Display color for messages of this type.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**




.. index:: ! Document - type

Document type
-------------

Document type is a way to define common behavior on group documents.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Context - type

Context type
------------

Context type is defining a fixed list of environmental context to describe ticket or test case.

Only three context types exist, corresponding to the three selectable fields in ticket or test case.

.. note::

   * Only the name of the context types can be changed.

   * No new context type can be added.

   * No context type can be deleted.

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
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**



.. index:: ! Requirement - type

Requirement type
----------------

Requirement type is a way to define common behavior on group of requirements.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Test case - type

Test case type
--------------

Test case type is a way to define common behavior on group of test cases.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**




.. index:: ! Test session - type

Test session type
-----------------

Test session type is a way to define common behavior on group of test sessions.

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Code
     - Code of the type.
   * - **Workflow**
     - Defined the workflow ruling status change for items of this type (see: :ref:`ctrlAuto-workflow-label`).
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Customer - type

Customer type
-------------

Customer type is a way to define different status of customers  (prospects or clients).

.. sidebar:: Other sections

   * :ref:`LOT-Behavior-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the type.
   * - **Name**
     - Name of the type.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate that type is archived.
   * - Description
     - Description of the type.

**\* Required field**


.. _LOT-Behavior-label:

Section: Behavior
-----------------

Allows to determine some GUI behavior, according to the type of element.

.. topic:: Description, Comments

   * This field allows to fill a specific detail on an item.  
   * Depending on the type of element, name of field can be different. 
   * Flag on defining that field is mandatory.
  

.. topic:: Responsible

   * This field allows to select a resource responsible who took over item. 
   * Flag on defining that field is mandatory when the handled status is on.

.. topic:: Result 

   * This field allows to fill a result of an item has been treated.  
   * Flag on defining that field is mandatory when the done status is on.

.. topic:: Flags status (handled, done, closed et canceled)

   * Allows to determine whether flags status are locked or not.
   * When a flag status is locked, move to this status through status change. 













