.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents::
   :depth: 3
   :backlinks: top


.. title:: Real work allocation

.. index:: ! Real work allocation 

Real work allocation
--------------------

This screen is devoted to input of real work.

Resource enters work day by day, on each assigned task.

The input is for one resource, on a weekly basis.

.. note::

   * The corresponding cost to the real work is automatically updated to the assignment, activity and project.

.. figure:: /images/GUI/SCR_TimeSheetZone.png
   :alt: Timesheet zone screen
   :align: center

   Timesheet zone screen

.. rubric:: Selection timesheet

* Allows to select a timesheet for a resource and for a period. |one|
* More detail about selection timesheet, see : :ref:`selectionTimesheet-section`.

.. rubric:: Show planned work

* Flag selected allows to display planned work. |two|
* Planned work is indicated over each input cell, on top right corner, in light blue color.
* Allow to display the planned work of each task each day.

.. figure:: /images/GUI/ZONE_RealWorkAllocationWithPlannedWork.png
   :alt: Planned work displayed zone
   :align: center

   Planned work displayed zone



.. raw:: latex

    \newpage

.. rubric:: Filters

* Filters allow to show or hide task in the task list. |three|

 .. compound:: **Show only current week meeting**

    * Flag allows to show only the week meeting task.

 .. compound:: **Hide not handled items**

    * Flag allows to hide task not take over.

 .. compound:: **Hide done items**

    * Flag allows to hide done task.

 .. compound:: **Show closed items**

    * Flag allows to show closed task.

.. rubric:: Buttons

Buttons of the timesheet: |four|

* Click on |buttonIconSave| to save timesheet data.
* Click on |buttonIconPrint| to print timesheet.
* Click on |buttonIconPdf| to export timesheet in PDF format.
* Click on |buttonIconUndo| to undo modification on the timesheet.

.. rubric:: Input fields

* Input fields in timesheet. |five|
* More detail about, see : :ref:`inputFields-section`

.. raw:: latex

    \newpage

.. rubric:: Tasks list

Task list allows to display each resource affectation task. |six| 

.. figure:: /images/GUI/ZONE_TaskList.png
   :alt: Task list zone
   :align: center

   Task list zone

|

 .. compound:: **Tasks** |alpha|

    * Tasks are regrouped by project. 
    * Tasks displayed in the list depends on :
   
      * Assigned tasks planified during this period.
      * Selected filter flags.
      * Behavior defined in :ref:`Global parameters<realWorkAllocation-section>` screen.
 

 .. compound:: **Function of the assignement** |beta|

    * The function on the assignment is displayed in blue after the name of the task.  
    * A resource assigned to the same task with many functions, several input line is displayed.

 .. compound:: **Comment on the assignment** |gamma|

    * The icon |Note| indicates there is a comment on the assignment. 
    * Just move the mouse over the activity to see the comment.

 .. compound:: **Task metrics** |delta|

    * **Planned dates**: Planned start and end dates for the task.
    * **Assigned**: Assigned work for the task.
    * **Real**: Sum of real work for the task.
    * **Left**: Left work for the task. 
    * **Planned**: Planned work for the task.  

.. raw:: latex

    \newpage

.. rubric:: Data entry validation

Buttons allow to send and validate real work. |seven|

 .. compound:: **Button: Submit work**

    * Users can send works to project leader.

 .. compound:: **Button: Validate work**

    * Project leaders can validate works.
 


.. raw:: latex

    \newpage

.. _selectionTimesheet-section:

Selection timesheet
^^^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/ZONE_TimeSheetSelector.png
   :alt: Timesheet selector zone
   :align: center

   Timesheet selector zone

.. rubric:: Selection of the resource 

* Users can only select themselves as a resource. |one|

.. topic:: Access to other resources timesheet

   * Depending on access rights, user can select other resource timesheet. 

.. rubric:: Selection period

* By default, the period is determined depending on the current day.
* It is possible to change the period of two ways:

  * Select year and week. |two|
  * Or select the first day of the week. |three| 

.. rubric:: Displayed timesheet

* A timesheet is displayed depends on the resource and period selection.
* The name of the resource and the week are displayed. |four|
* The days of the week are displayed. |five|
* The current day is displayed. |six|



.. raw:: latex

    \newpage

.. _inputFields-section:

Input fields
^^^^^^^^^^^^

.. figure:: /images/GUI/ZONE_InputTimeSheet.png
   :alt: Input timesheet zone
   :align: center

   Input timesheet zone

.. rubric:: Comments

* A global comment can be added on the weekly follow-up. |one|

.. rubric:: Real work entry

* Area allows to entry real work. |two|
* Week is displayed from monday to sunday.
* It possible put real work in off days.

.. topic:: Current day

   * Columns of current day is displayed in yellow.

.. Topic:: Days off

   * Columns of days off is displayed in grey.
   * Days off is determine in resource calendar definition, see: :ref:`calendar` screen.

.. rubric:: Left work

* Left work is automatically decreased on input of real work.
* Resources can update this data to reflect the real estimated left work. |three|

.. rubric:: Unit for real work

* Unit for real work is set with "unit for real work allocation" parameter in "Units for work" section, see: * :ref:`global-parameters` screen.
* Selected unit is displayed on left at bottom window |four|.   

.. raw:: latex

    \newpage


Input entry validation
^^^^^^^^^^^^^^^^^^^^^^

.. rubric:: Resource capacity validation


* The total of the day is green whether entries respects the resource capacity of days.
* The total of the day is red whether entries is more than the resource capacity of days.

.. topic:: Resource capacity of days

   * The resource capacity is defined by the number of hours per day and the resource capacity.
   * The number of hours per day is defined in :ref:`Global parameters<unitForWork-section>` screen.
   * The capacity of the resource is defined :ref:`resource` screen.


.. figure:: /images/GUI/ZONE_RealWorkAllocationWithColumnsValidation.png
   :alt: Columns validation zone
   :align: center

   Columns validation zone


.. note::

   * This control is not blocking.

.. rubric:: Entering real work is in excess of the number of days specified 

* This alert box appears when the real work to a resource is entering  ahead of time.
* The number of days in advance, resource can enter his real work is defined in "max days to book work" parameter in :ref:`Global parameters<unitForWork-section>` screen.

.. figure:: /images/GUI/ALERT_RealWorkOverExpectedDays.png
   :alt: Real work over expected days alert
   :align: center

   Real work over expected days alert


