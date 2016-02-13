.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage



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

.. rubric:: 1- Selection timesheet

* Allows to select a timesheet for a resource and for a period.
* More detail about selection timesheet, see : :ref:`selectionTimesheet-section`.

.. rubric:: 2 - Show planned work

* Flag selected allows to display planned work.
* Planned work is indicated over each input cell, on top right corner, in light blue color.
* Allow to display the planned work of each task each day.

.. figure:: /images/GUI/ZONE_RealWorkAllocationWithPlannedWork.png
   :alt: Planned work displayed zone
   :align: center

   Planned work displayed zone

.. note::

   * The planned work will be deleted when the real work is entered (to avoid duplication of work in reports).

.. rubric:: 3 - Filters

* Filters allow to show or hide task in the task list.

 .. compound:: **Show only current week meeting**

    * Flag allows to show only the week meeting task.

 .. compound:: **Hide not handled items**

    * Flag allows to hide task not take over.

 .. compound:: **Hide done items**

    * Flag allows to hide done task.

 .. compound:: **Show closed items**

    * Flag allows to show closed task.

.. rubric:: 4 - Buttons

Buttons of the timesheet:

* Click on |buttonIconSave| to save timesheet data.
* Click on |buttonIconPrint| to print timesheet.
* Click on |buttonIconPdf| to export timesheet in PDF format.
* Click on |buttonIconUndo| to undo modification on the timesheet.

.. rubric:: 5 - Data entry validation

Buttons allow to send and validate real work.

 .. compound:: **Button: Submit work**

    * Users can send works to project leader.

 .. compound:: **Button: Validate work**

    * Project leaders can validate works.


.. rubric:: 6 - Scroll bar

* Scroll bar allows the scrolling on imputation lines.
* The header of table stays visible.
* The footer of the table (with the sum of inputs) remains visible, fixed, as soon as the number of lines is greater than 20.

.. rubric:: 7 - Input fields

* Input fields in timesheet.
* More detail about, see : :ref:`inputFields-section`


.. raw:: latex

    \newpage

.. rubric:: 8 - Tasks list

Task list allows to display each resource affectation task.

.. figure:: /images/GUI/ZONE_TaskList.png
   :alt: Task list zone
   :align: center

   Task list zone

|

 .. compound:: **A - Tasks**

    * Tasks are regrouped by project in hierarchical form. 
    * Tasks displayed in the list depends on :
   
      * Assigned tasks planified during this period.
      * Selected filter flags.
      * Behavior defined in :ref:`Global parameters<realWorkAllocation-section>` screen.

     .. note::

        * Tasks with real work are always displayed, even if closed.
        * The goal is to show all lines of the sum for each column, to be able to check that the week is completely entered.

    * Click on the name of the activity to access it.  
    * Click on |minusButton| or |plusButton| on the line will expand-shrink the group.
    * Click on the icon of the activity to display it detail without leaving the current screen.  
 

 .. compound:: **B - Function of the assignement**

    * The function on the assignment is displayed in blue after the name of the task.  
    * A resource assigned to the same task with many functions, several input line is displayed.

 .. compound:: **C - Comment on the assignment**

    * The icon |Note| indicates there is a comment on the assignment. 
    * Just move the mouse over the activity to see the comment.

 .. compound:: **D - Progress data**

    * **Planned dates**: Planned start and end dates.
    * **Assigned**: Planned work assigned to the resource.
    * **Real**: Sum of work done by the resource.
    * **Left**: The remaining planned work. 
    * **Reassessed**: The work needed to complete the task.  




.. raw:: latex

    \newpage

.. _selectionTimesheet-section:

Selection timesheet
^^^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/ZONE_TimeSheetSelector.png
   :alt: Timesheet selector zone
   :align: center

   Timesheet selector zone

.. rubric:: 1 - Selection of the resource 

* Users can only select themselves as a resource.

 .. note:: Access to other resources timesheet

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

.. rubric:: 1 - Comments

* A global comment can be added on the weekly follow-up.

.. rubric:: 2 - Real work entry

* Area allows to entry real work.
* Week is displayed from monday to sunday.
* It possible put real work in off days.

 .. compound:: **Current day**

    * Columns of current day is displayed in yellow.

 .. compound:: **Days off**

    * Columns of days off is displayed in grey.
    * Days off is determine in resource calendar definition, see: :ref:`calendar` screen.

.. rubric:: 3 - Left work

* Left work is automatically decreased on input of real work.
* Resources can update this data to reflect the real estimated left work.

.. rubric:: 4 - Unit for real work

* Unit for real work allocation is set :ref:`Global parameters<unitForWork-section>` screen.
* Selected unit is displayed on left at bottom window.   

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

.. raw:: latex

    \newpage

.. rubric:: Automatic status change

Status can change automatically depending on whether real work is entered or no more left work.

Automatic status change is defined  in :ref:`Global parameters<realWorkAllocation-section>` screen.

 .. compound:: **Display of icons**

    * An icon will be displayed on the task if a status change is applicable.

    * |statusStart| Due to real work is entered, the task status will be changed to the first 'handled' status.
    * |statusStartKO| The real work is entered, but the task status will not change because at issue is occurring. 
    * |statusFinish| Due to no more left work, the task status will be changed to the first ‘done’ status.
    * |statusFinishKO| No more left work, but the task status will not change because at issue is occurring. 

    .. note::

       * Move the cursor over the icon to see the message.

 .. compound:: **Common issue**

    * If a :term:`responsible` or a :term:`result` are set as mandatory in element type definition for the task. It's impossible to set those values by real work allocation screen.
    * The change status must be done in treatment section on the task definition screen.

.. rubric:: Entering real work is in excess of the number of days specified 

* This alert box appears when the real work to a resource is entering  ahead of time.
* The number of days in advance, resource can enter his real work is defined in "max days to book work" parameter in :ref:`Global parameters<unitForWork-section>` screen.

.. figure:: /images/GUI/ALERT_RealWorkOverExpectedDays.png
   :alt: Real work over expected days alert
   :align: center

   Real work over expected days alert


