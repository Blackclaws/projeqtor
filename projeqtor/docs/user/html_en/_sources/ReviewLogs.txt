.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Review logs
   :depth: 2
   :backlinks: top
   :local:

.. title:: Review logs

.. index:: ! Meeting 

.. _reviewLogs-meeting-label:

Meeting
-------

Meeting items are stored to keep trace of important meetings during the project lifecycle :

* Progress Meetings

* Steering committees

* Functional workshops

In fact, you should keep trace of every meeting where decisions are taken, or questions answered.

This will provide an easy way to find back when, where and why a decision has been taken.

.. sidebar:: Other sections

   * :ref:`reviewLogs-progress-section-label`

   * :ref:`pe-predSuces-element-section-label`

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
     - Unique Id for the meeting.
   * - Name
     - Short description of the meeting.
   * - **Meeting type**
     - Type of meeting. 
   * - **Project**
     - The project concerned by the meeting.
   * - **Meeting date**
     - Date of the meeting (initially expected date), including start and end time.
   * - Location
     - Place (room or else) when meeting will stand.
   * - Email invitation
     - Button to send the email to attendees.
   * - Description
     - Description of the meeting. Can be used to store Agenda.
 
**\* Required field**

.. topic:: Field: Name

   * If not set, will automatically be set to meeting type completed with meeting date.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity
     - Parent activity of the meeting.
   * - **Status**
     - Actual :term:`status` of the meeting.
   * - Responsible
     - Resource who is responsible for the organization of the meeting.
   * - :term:`Handled`
     - Flag to indicate that meeting has been taken into account. 
   * - :term:`Done`
     - Flag to indicate that meeting has been held.
   * - :term:`Closed`
     - Flag to indicate that meeting is archived.
   * - Cancelled
     - Flag to indicate that meeting is cancelled.
   * - Minutes
     - Minutes of the meeting.
 
**\* Required field**

.. topic:: Field: Parent activity

   * In the WBS structure, under which the meeting will be displayed in the Gantt planning.

.. topic:: Minutes

   * You can enter here only a short summary of the minutes and attach the full minutes as a file.

.. rubric:: Section: Attendees

.. topic:: Attendees list

   * Meeting is an activity you can assign ressources.
   * Detail of assignment ressource, see :ref:`pe-assignment-section-label`. 
   
.. topic:: Other attendees

   * Extra list of persons attending (or expecting to attend) the meeting, in completion to resource in attendees list.
   * Duplicate email addresses with attendees list will automatically be removed.



.. rubric:: Section: Progress


.. todo::

   Completer les sections celles des activités


.. raw:: latex

    \newpage


.. index:: ! Periodic Meeting 

.. _reviewLogs-periodic-meeting-label:

Periodic Meeting
----------------

Periodic meeting is a way to define some meetings that will occur on a regular basis.

Most fields fit meeting fields, but some information for meeting is not present for periodic meeting, such as Minutes or Status. 

If is because these fields won’t be set through periodic meeting definition, but must be set directly on the meetings.

.. note::

   * When saving Periodic Meeting, elementary meetings are automatically created.
 
   * Changes can then be done on elementary meetings. In most cases, these changes won’t be erased by Periodic Meeting updates.

   * On each update of a periodic meeting, meetings are re-evaluated. This may lead to deletion of some meetings.

   * This will also reposition meetings, even if their planned dates were elementarily updated.

.. sidebar:: Other sections

   * :ref:`reviewLogs-progress-section-label`

   * :ref:`pe-predSuces-element-section-label`

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
     - Unique Id for the periodic meeting.
   * - Name
     - Short description of the meeting.
   * - **Meeting type**
     - Type of meeting. 
   * - **Project**
     - The project concerned by the meeting.
   * - Location
     - Place (room or else) when meeting will stand.
   * - Description
     - Description of the meeting. Can be used to store Agenda.
 
**\* Required field**

.. topic:: Field: Name

   * If not set, will automatically be set to meeting type completed with meeting date.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity
     - Parent activity of the meeting.
   * - Responsible
     - Resource who is responsible for the organization of the meeting.
   * - :term:`Closed`
     - Flag to indicate that periodic meeting is archived.

.. topic:: Field: Parent activity

   * In the WBS structure, under which the meeting will be displayed in the Gantt planning.

.. rubric:: Section: Attendees

.. topic:: Attendees list

   * Meeting is an activity you can assign ressources.
   * Detail of assignment ressource, see :ref:`pe-assignment-section-label`. 
   
.. topic:: Other attendees

   * Extra list of persons attending (or expecting to attend) the meeting, in completion to resource in attendees list.
   * Duplicate email addresses with attendees list will automatically be removed.


.. rubric:: Section: Periodicity

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Period**
     - Start date and End date or number of occurrences to define the range of the periodicity.
   * - Time
     - Start and end time for all the meetings.
   * - **Periodicity**
     - Frequency of the meeting, on proposed bases (daily, weekly monthly).
   * - Only on open days
     - Specify that meetings will not be set on off days.

**\* Required field**

.. topic:: Field: Periodicity

   * Several periodicity are proposed:
    
     * Every day
     * Same day every week
     * Same day every mouth
     * Same week every mounth

.. raw:: latex

    \newpage

.. _reviewLogs-progress-section-label:

Section: Progress
-----------------

This section allows to follow-up the progress for a meeting.

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Validated work/cost
     - Committed work/cost, work/cost of the meeting should not be more. 
   * - Assigned work/cost
     - Work/cost for the assignments on the meeting.
   * - Real work/cost
     - Work/cost really spent on the meeting. 
   * - Left work/cost
     - Work/cost needed to complete the task.
 
.. topic:: Priority

   * :term:`Planning priority` of the meeting.

.. raw:: latex

    \newpage


.. index:: ! Decision 

Decision
--------

Decisions are stored to keep trace of important decisions, when, where and why the decision was taken.

You can link a decision to a meeting to rapidly find the minutes where the decision is described.

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
     - Unique Id for the decision.
   * - **Name**
     - Short description of the decision.
   * - **Decision type**
     - Type of decision. 
   * - **Project**
     - The project concerned by the decision.
   * - Description
     - Complete description of the decision.
 
**\* Required field**

.. rubric:: Section: Validation

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the decision.
   * - Decision date
     - Date of the decision.
   * - Origin
     - Origin of the decision.
   * - Accountable
     - Resource accountable for the decision. **The person who took the decision**
   * - :term:`Closed`
     - Flag to indicate that decision is archived.
   * - Cancelled
     - Flag to indicate that decision is cancelled.
 
**\* Required field**

.. topic:: Field: Origin

   * It can be either the reference to a meeting where decision was taken (so also add the reference to the meetings list), or a short description of why the decision was taken. 

.. raw:: latex

    \newpage

.. index:: ! Question 

Question
--------

Question are stored to keep trace of important Questions and Answers.

In fact, you should keep trace of every question and answer that have an impact to the project.

The Questions can also afford an easy way to track questions sent and follow-up non-answered ones.

This will provide an easy way to find back when, who and precise description of the answer to a question.

Also keep in mind that some people will (consciously or not) be able to change their mind and uphold it has always been their opinion… 

You can link a question to a meeting to rapidly find the minutes where the question was raised or answered.

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
     - Unique Id for the question.
   * - **Name**
     - Short description of the question.
   * - **Question type**
     - Type of question. 
   * - **Project**
     - The project concerned by the question.
   * - Description
     - Complete description of the question.
 
**\* Required field**

.. rubric:: Section: Answer

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the decision.
   * - Responsible
     - Resource who is responsible for the follow-up of the question.
   * - Initial due date
     - Initially expected date for the answer to the question.
   * - Planned due date
     - Updated expected date for the answer to the question.
   * - Replier
     - Name of the person who provided the answer.
   * - :term:`Handled`
     - Flag to indicate that question has been taken into account. 
   * - :term:`Done`
     - Flag to indicate that question has been answered.
   * - :term:`Closed`
     - Flag to indicate that question is archived.
   * - Cancelled
     - Flag to indicate that question is cancelled. 
   * - Response
     - Complete description of the answer to the question.

**\* Required field**

  

  


