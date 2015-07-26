.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Controls & Automation
   :depth: 1
   :backlinks: top
   :local:


.. title:: Controls & Automation

.. index:: ! Workflow

.. _ctrlAuto-workflow-label:

Workflow
--------

A workflow defines the possibility to go from one status to another one, and who (depending on profile) can do this operation for each status.

Once defined, a workflow can be linked to any type of any item. 

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
     - Unique Id for the workflow.
   * - **Name**
     - Name of the workflow.
   * - Sort order
     - Number to define order of display in lists
   * - :term:`Closed`
     - Flag to indicate that workflow is archived.
   * - Description
     - Complete description of the workflow.

**\* Required field**

.. note::

   * The parameter button |buttonIconParameter| can be used to show or hide needed status.


.. rubric:: Section: Workflow Diagram

* The workflow diagram presents a visual representation of the workflow displaying all possible transitions (independently to profile rights).

.. rubric:: Section: Habilitation to change from a status to another

* The habilitation table helps defining who can move from one status to another one.
* Each line correspond to the status from which you want to be able to move.
* Each column correspond to the status to which you want to be able to go.
* It is not possible to go from one status to itself (these cells are blank).
* Just check the profile (or “all”) who is allowed to pass from one status to the other.

.. raw:: latex

    \newpage

.. index:: ! Mail on event

Mail on event
-------------

The application is able to automatically send mails on event such as status change or responsible change.

This must be defined for each type of element, and each new status or other event.

.. note::

   * The message of the mails is formatted to display information on the item.

   * Title of the mail is defined under "Mail titles" section in :ref:`administration-global-parameters-label`.

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
     - Unique Id for the status mail.
   * - Element updated
     - Type of elements that will be concerned by automatic emailing.
   * - New status
     - Positioning the elements to this status will generate emails.
   * - Or other event
     - Other event that will possibly generate email.
   * - :term:`Closed`
     - Flag to indicate that status mail is archived.

.. rubric:: Section: Mail receivers

* List of addressees of the mails.
* The list is not nominative but defined as roles on the element.
* Each addressee will receive mail only once, even if a person has several “checked” roles on the element
* see : :ref:`ctrlAuto-msg-receivers` for receivers detail.

.. raw:: latex

    \newpage

.. index:: ! Delay for Ticket

Delay for Ticket
----------------

It is possible to define default delay for tickets, for each ticket type and each urgency of ticket.

.. note::

   * On creation, due date will automatically be calculated as creation date + delay.

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
     - Unique Id for the delay definition.
   * - **Ticket type**
     - Ticket type the delay applies to.
   * - **Urgency**
     - Urgency of ticket the delay applied to.
   * - **Value**
     - Value of delay.
   * - :term:`Closed`
     - Flag to indicate that delay definition is archived.

**\* Required field**

.. topic:: Field: Value

   * Unit for the value can be :
    
     - Days : simple calculation as days.
     - Hours : simple calculation as hours.
     - Open days : calculation excluding off days (week-ends and off days defined on “calendar”).
     - Open hours : calculation only on the “standard open hours” defined on the global parameters. 

.. raw:: latex

    \newpage

.. index:: ! Indicator

Indicator
---------

It is possible to define indicators on each type of element.

Depending on type of elements the type of indicators that can be selected in list differs.

Some indicators are based on delay (due date), some on work, some on cost.

For each indicator a warning value and an alert value can be defined.

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
     - Unique Id for the indicator definition.
   * - Element
     - The elements the indicator applies to.
   * - Type
     - Type of the elements the indicator applies to.
   * - Reminder
     - Delay before due date or % of work or % or cost to send a warning.
   * - Alert
     - Delay before due date or % of work or % or cost to send an alert.
   * - :term:`Closed`
     - Flag to indicate that delay definition is archived.

.. rubric:: Section: Mail receivers

* List of addressees of the mails.
* The list is not nominative but defined as roles on the element.
* Each addressee will receive mail only once, even if a person has several “checked” roles on the element. 
* see : :ref:`ctrlAuto-msg-receivers` for receivers detail.

.. rubric:: Section: Internal alert receivers

* List of addressees of the internal alert.
* The list is not nominative but defined as roles on the element.
* see : :ref:`ctrlAuto-msg-receivers` for receivers detail.

.. raw:: latex

    \newpage

.. index:: ! Predefined notes

.. _ctrlAuto-predefined-notes-label:

Predefined notes
----------------

The predefined note set the possibility to define some predefined texts for notes.

When some predefined notes are defined for an element and / or type a list will appear on note creation.

Selecting an item in the list will automatically fill in the note text field.

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
     - Unique Id for the predefined note.
   * - **Name**
     - Name of the predefined note.
   * - Element
     - Kind of item (Ticket, Activity, …) for which this predefined note will be proposed on note creation.
   * - Type
     - Type of element for witch this predefined note will be proposed on note creation.
   * - :term:`Closed`
     - Flag to indicate that delay definition is archived.
   * - Text
     - Predefined text for notes.

**\* Required field**

.. topic:: Field: Element

   * If not set, predefined note is valid for every find of item.

.. topic:: Field: Type

   * If not set, predefined note is valid for every type of the element.

.. raw:: latex

    \newpage

.. index:: ! Checklist Definition

.. _ctrlAuto-checklist-def-label:

Checklist definition
--------------------

It is possible to define checklists on each type of element.

When a checklist definition exists for a given element, a checklist section will appear on the element.


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
     - Unique Id for the checklist definition.
   * - Element
     - The elements the checklist applies to.
   * - Type
     - Type of the elements the checklist applies to.
   * - :term:`Closed`
     - Flag to indicate that checklist definition is archived. 

.. rubric:: Section: Checklist lines

A checklist is built from checklist lines.

Click |buttonAdd| on to create a new checklist line. A “Choice for the checklist line” pop up will be displayed. 

Click on |buttonEdit| to update an existing checklist line.

Click on |buttonRemove| to delete the corresponding checklist line.

.. figure:: /images/GUI/choicesChecklistLine.png
   :scale: 60 %
   :alt: Choices for the checklist line Popup
   :align: center

   Choices for the checklist line

.. tabularcolumns:: |l|l|

.. list-table:: Choices for the checklist line fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Name
     - Name of the subject of the checklist line.
   * - Sort order
     - Order of the line in the list.
   * - Choice #n
     - Possible choices (checks) for the list (up to 5 choices).
   * - Exclusive
     - Are the choices exclusive (select one will unselect others).

.. topic:: Details of Pop up

   * Each line has a name, an order and up to 5 check choices.

   * A line with no check choice will be displayed as **section title**.

   * Name and Choices have 2 fields : 

     * first is the displayed caption, 
     * second is help text that will be displayed as tooltip.

   * Checks can be exclusive (select one will unselect others) or not (multi selection is then possible).





.. raw:: latex

    \newpage

.. index:: ! Mail receivers

.. _ctrlAuto-msg-receivers:

Receivers list
--------------

Receivers can receive email and alert.

A description of receivers below.

.. topic:: Requestor

   * The Contact defined as “requestor” on current item; sometimes appears as “contact” (on Quotation and Order for instance) and sometimes have no meaning (for instance for Milestone).

.. topic:: Issuer

   * The User defined as “Issuer”.


.. topic:: Responsible

   * The Resource defined as “responsible”.

.. topic:: Project team

   * All Resources affected to the Project.

.. topic:: Project leader

   * The Resource(s) affected to the Project with a “Project Leader” profile.

.. topic:: Project manager

   * The User defined as “manager” on the Project.

.. topic:: Assigned resource

   * All Resources assigned.

.. topic:: Other

    * Provides an extra field to manually enter email addresses.

    * If “other” is checked, an input box is displayed to enter a static mail address list.

    * Several addresses can be entered, separated by semicolon.

