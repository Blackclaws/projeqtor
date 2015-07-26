.. raw:: latex

    \newpage


.. contents:: Access rights
   :depth: 1
   :backlinks: top
   :local:


.. title:: Access rights

.. index:: ! Profile

Profile
-------

The profile is a group of habilitations and right access to the data.

Each user is linked to a profile to defined the data he can see and possibly manage. 

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
     - Unique Id for the profile.
   * - Name
     - Name of the profile. (Translatable).
   * - Profile code
     - A code that may be internally used when generating emails and alerts.
   * - Sort order
     - Number to define order of display in lists
   * - :term:`Closed`
     - Flag to indicate that profile is archived.
   * - Description
     - Complete description of the profile.

.. topic:: Field: Profile code

   * ADM will designate administrator.
   * PL will designate Project Leader. 


.. raw:: latex

    \newpage


.. index:: ! Access mode

Access mode
-----------

The access mode defines a combination of rights to read, created, update or delete items.

Each access is defined as scope of visible and updatable elements, that can be :

* **No element:** No element is visible and updatable.
* **Own elements:** Only the elements created by the user.
* **Elements he is responsible for:** Only the elements the user is responsible for.
* **Elements of own project:** Only the elements of the projects the user/resource is affected to.
* **All elements on all projects:** All elements, whatever the project.

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
     - Unique Id for the access mode.
   * - **Name**
     - Name of the access mode. (Translatable).
   * - **Read rights**
     - Scope of visible items
   * - **Create rights**
     - Scope of possibility to create items.
   * - **Update rights**
     - Scope of updatable items.
   * - **Delete rights**
     - Scope of deletable items.
   * - Sort order
     - Number to define order of display in lists
   * - :term:`Closed`
     - Flag to indicate that access mode is archived.
   * - Description
     - Complete description of the access mode.

**\* Required field**


.. raw:: latex

    \newpage


.. index:: ! Access to forms

Access to forms
---------------

Access to forms defines for each screen the profiles of users that can access to the screen.

Users belonging to a profile not checked for a screen will not see the corresponding menu.

.. index:: ! Access to reports

Access to reports
-----------------

Access to reports defines for each report the profiles of users that can access to the report.

Users belonging to a profile not checked for a report will not see the corresponding report in the report list.

.. index:: ! Access to data (project dependant)

Access mode to data (project dependant)
---------------------------------------

Access mode defines for each “Project dependent” screen the access mode (scope of visibility and updatability) for each profile. 

.. index:: ! Access to data (not project dependant)

Access mode to data (not project dependant)
-------------------------------------------

.. index:: ! Specific access mode

Specific access mode
--------------------



