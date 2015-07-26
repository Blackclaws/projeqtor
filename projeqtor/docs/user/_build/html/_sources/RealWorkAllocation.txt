.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents:: Real work allocation
   :depth: 3
   :backlinks: top
   :local:

.. title:: Real work allocation

.. index:: ! Real work allocation 

Real work allocation
--------------------

This screen is devoted to input of real work.

Resource enters work day by day, on each assigned task.

The input is for one resource, on a weekly basis.

.. note::

   * The corresponding cost to the real work is automatically updated to the assignment, activity and project.

.. figure:: /images/GUI/RWA_TimeSheetZone.png
   :scale: 80 %
   :alt: RWA Timesheet areas
   :align: center

   Timesheet areas

.. rubric:: Selection timesheet

* Allows to select a timesheet for a resource and for a period. |one|
* More detail about selection timesheet, see : :ref:`RWA-selection-timesheet-label`.

.. rubric:: Show planned work

* Flag selected allows to display planned work. |two|
* Planned work is indicated over each input cell, on top right corner, in light blue color.
* Allow to display the planned work of each task each day.

.. figure:: /images/GUI/realWorkAllocationWithPlannedWork.png
   :scale: 60 %
   :alt: RWA Planned work displayed
   :align: center

   Planned work displayed

.. rubric:: Filters

* Filters allow to show or hide task in the task list. |three|

.. topic:: Show only current week meeting

   * Flag allows to show only the week meeting task.

.. topic:: Hide not handled items

   * Flag allows to hide task not take over.

.. topic:: Hide done items

   * Flag allows to hide done task.

.. topic:: Show closed items

   * Flag allows to show closed task.

.. rubric:: Buttons

Buttons of the timesheet: |four|

* Click on |buttonIconSave| to save timesheet data.
* Click on |buttonIconPrint| to print timesheet.
* Click on |buttonIconPdf| to export timesheet in PDF format.
* Click on |buttonIconUndo| to undo modification on the timesheet.

.. rubric:: Input fields

* Input fields in timesheet. |five|
* More detail about, see : :ref:`RWA-input-timesheet-label`

.. raw:: latex

    \newpage

.. rubric:: Tasks list

Task list allows to display each resource affectation task. |six| 

.. figure:: /images/GUI/RWA_TaskList.png
   :scale: 60 %
   :alt: RWA Task list area
   :align: center

   Task list area

.. topic:: Tasks |alpha|

   * Tasks are regrouped by project. 
   * Tasks displayed in the list depends on :
   
     * Assigned tasks planified during this period.
     * Selected filter flags.
     * :ref:`administration-global-parameters-label` set in "Real work allocation" section.   



.. topic:: Function of the assignement |beta|

   * The function on the assignment is displayed in blue after the name of the task.  
   * A resource assigned to the same task with many functions, several input line is displayed.

.. topic:: Comment on the assignment |gamma|  

   * The |Note| icon indicates there is a comment on the assignment. 
   * Just move the mouse over the activity to see the comment.

.. topic:: Task metrics |delta|

   * **Planned dates**: Planned start and end dates for the task.
   * **Assigned**: Assigned work for the task.
   * **Real**: Sum of real work for the task.
   * **Left**: Left work for the task.

 
   * **Planned**: Planned work for the task.  

.. raw:: latex

    \newpage

.. rubric:: Data entry validation

Buttons allow to send and validate real work. |seven|

.. topic:: Button: Submit work

   * Users can send works to project leader.

.. topic:: Button: Validate work

   * Project leaders can validate works.
 


.. raw:: latex

    \newpage

.. _RWA-selection-timesheet-label:

Selection timesheet
^^^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/RWA_TimeSheetSelector.png
   :scale: 60 %
   :alt: RWA Timesheet selector
   :align: center

   Timesheet selector

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

.. _RWA-input-timesheet-label:

Input fields
^^^^^^^^^^^^

.. figure:: /images/GUI/RWA_InputTimeSheet.png
   :scale: 60 %
   :alt: RWA Input timesheet
   :align: center

   Input timesheet

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
   * Days off is determine in resource calendar definition, see: :ref:`resource-calendar-label`.

.. rubric:: Left work

* Left work is automatically decreased on input of real work.
* Resources can update this data to reflect the real estimated left work. |three|

.. rubric:: Unit for real work

* Unit for real work is set with "unit for real work allocation" parameter in "Units for work" section, see: * :ref:`administration-global-parameters-label`.
* Selected unit is displayed on left at bottom window |four|.   

.. raw:: latex

    \newpage


Input entry validation
""""""""""""""""""""""

.. figure:: /images/GUI/realWorkAllocationWithColumnsValidation.png
   :scale: 100 %
   :alt: RWA Columns validation
   :align: center

   Columns validation

.. rubric:: Resource capacity validation

* Total of the day is green whether the entry in the day respects resource capacity.
* Total of the day is red whether the entry in the day is more than the resource capacity.

.. note::

   * This control is not blocking.


