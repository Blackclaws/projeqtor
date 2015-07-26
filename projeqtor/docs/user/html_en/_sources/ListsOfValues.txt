.. raw:: latex

    \newpage


.. contents:: Lists of values
   :depth: 2
   :backlinks: top
   :local:

.. title:: Lists of values

.. index:: ! Function - lists of values

Function
^^^^^^^^

The function defines the generic competency of a resource.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   * - Description
     - Complete description of this value.


**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Status - lists of values

Status
^^^^^^

The status is an important element of items lifecycle.

It defines the progress of the treatment of the element.

Some automations are implemented, depending on status definition, to set ‘handled’, ‘done’ and ‘closed’ flags on items.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Handled status
     - Defines whether ‘handled’ flag is automatically set for this status.
   * - Done status
     - Defines whether ‘done’ flag is automatically set for this status.
   * - Closed status
     - Defines whether ‘closed’ flag is automatically set for this status.
   * - Color
     - Color to display the status in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.

**\* Required field**

.. raw:: latex

    \newpage

Status definition
"""""""""""""""""

.. rubric:: Handled status

* This status specifies that the treatment of item is taken over.
* A responsible can be determined.
* It is possible to require the appointment of a responsible when the status change to "handled".

.. rubric:: Done status

* This status specifies that the treatment of item is done.
* A result can be specify.
* It is possible to require a result when the status change to "done".

.. rubric:: Closed status

* This status specifies that the item is closed.
* This item is archived, and it disappeared in the list.
* Item can reappear when "show closed item" is checked.

.. rubric:: Cancelled status

* This status specifies that the item is cancelled.


.. raw:: latex

    \newpage

.. index:: ! Quality level - lists of values

.. _Quality-label:

Quality level
^^^^^^^^^^^^^

The quality is a manual indicator for the conformity of a project to quality processes.

It defines in a visual way the global conformity of the project.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Color
     - Color to display the quality level in element lists and on today screen.
   * - Icon
     - Icon that can be displayed for this quality level. 
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**

.. topic:: Field: Icon
   
   * If no icon is defined, color is used.



.. raw:: latex

    \newpage


.. index:: ! Health Status - lists of values

Health Status
^^^^^^^^^^^^^

The health status is a manual indicator for the health of a project.

It defines in a visual way the global health of the project.

It is displayed on Today screen, for each project, as a Red / Amber / Green traffic light.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Color
     - Color to display the health status in element lists and on today screen.
   * - Icon
     - Icon that can be displayed for this health status.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**

.. topic:: Field: Icon
   
   * If no icon is defined, color is used.



.. index:: ! Overall progress - lists of values

Overall progress
^^^^^^^^^^^^^^^^

The overall progress is a manual indicator for global progress of a project.

It defines in a visual way the global progress of the project, independently from work progress.

It is displayed on Today screen, for each project.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.

**\* Required field**



.. raw:: latex

    \newpage

.. index:: ! Trend - lists of values

Trend
^^^^^

The trend is a manual indicator for the global trend of project health.

It defines in a visual way the health trend of the project.

It is displayed on Today screen, for each project.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Color
     - Color to display the trend in element lists and on today screen.
   * - Icon
     - Icon that can be displayed for this trend.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**

.. topic:: Field: Icon
   
   * If no icon is defined, color is used.


.. index:: ! Likelihood - lists of values

Likelihood
^^^^^^^^^^

The likelihood is the probability for a risk to occur.

The more likely a risk is, the more critical it is.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Value
     - Value used to calculate criticality from likelihood and severity.
   * - Color
     - Color to display the likelihood in element lists
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**


.. raw:: latex

    \newpage


.. index:: ! Criticality - lists of values

Criticality
^^^^^^^^^^^

The criticality is the importance  of an element to its context.

The risk criticality designs the level of impact the risk may have to the project.

The ticket criticality is the estimated impact that the subject of the ticket may have to the product.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Value
     - Value used to calculate criticality from likelihood and severity, and to calculate priority from criticality and urgency.
   * - Color
     - Color to display the criticality in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**



.. index:: ! Severity - lists of values

Severity
^^^^^^^^

The risk severity designs the level of impact the risk may have to the product.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Value
     - Value used to calculate criticality from likelihood and severity.
   * - Color
     - Color to display the severity in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**


.. raw:: latex

    \newpage

.. index:: ! Urgency - lists of values

Urgency
^^^^^^^

The ticket urgency is an element given by the requestor to indicate the quickness of treatment needed for the ticket.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Value
     - Value used to calculate priority from criticality and urgency.
   * - Color
     - Color to display the urgency in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**



.. index:: ! Priority - lists of values

Priority
^^^^^^^^

The ticket priority defines the order to treat different tickets.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Value
     - Value used to calculate priority from criticality and urgency.
   * - Color
     - Color to display the priority in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Risk level - lists of values

Risk level
^^^^^^^^^^

The risk level measures the technical risk of implementation of a requirement.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Color
     - Color to display the risk level in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**



.. index:: ! Feasibility - lists of values

Feasibility
^^^^^^^^^^^

The feasibility defines the first analysis of implementation of a requirement.

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
     - Unique Id for this status.
   * - **Name**
     - Name of this status.
   * - Color
     - Color to display the feasibility in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this status is archived.
   
**\* Required field**



.. raw:: latex

    \newpage

.. index:: ! Efficiency - lists of values

Efficiency
^^^^^^^^^^

The efficiency measures the result of an action.

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
     - Unique Id for this value.
   * - **Name**
     - Name of this value.
   * - Color
     - Color to display the efficiency in element lists.
   * - Sort order
     - Number to define order of display in lists.
   * - :term:`Closed`
     - Flag to indicate this value is archived.
   
**\* Required field**
