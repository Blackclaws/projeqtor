.. raw:: latex

    \newpage


.. contents:: Risk & Issue Management
   :depth: 1
   :backlinks: top
   :local:


.. title:: Risk & Issue Management

.. index:: ! Risk 

Risk
----

A risk is any threat of an event that may have a negative impact to the project, and which may be neutralized, or at least minimized, through pre-defined actions.

The risk management plan is a key point to Project Management :


 - identify risks and estimate their severity and likelihood.

 - identify mitigating actions

 - identify opportunities

 - follow-up actions

 - identify risks that finally occur (becoming an issue)

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
     - Unique Id for the risk.
   * - **Name**
     - Short description of the risk.
   * - **Type**
     - Type of risk.
   * - **Project**
     - The project concerned by the risk.
   * - Severity
     - Level of importance of the impact for the project.
   * - Likelihood
     - Probability level of the risk to occur.
   * - Criticality
     - Global evaluation level of the risk.
   * - :term:`Origin`
     - Element which is the origin of the risk.
   * - Cause
     - Description of the event that may trigger the risk.
   * - Impact
     - Description of the estimated impact on the project if the risk occurs.
   * - Description
     - Complete description of the risk.

**\* Required field**

.. topic:: Field: Criticality

   * Automatically calculated from Severity and Likelihood values.
   * Value can be changed. 

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the risk.
   * - Responsible
     - Resource who is responsible for the treatment of the risk.
   * - Priority
     - Expected priority to take into account this risk.
   * - Initial end date
     - Initially expected end date of the risk.
   * - Planned end date
     - Updated end date of the risk.
   * - :term:`Handled`
     - Flag to indicate that risk is taken into account.
   * - :term:`Done`
     - Flag to indicate that risk has been treated.
   * - :term:`Closed`
     - Flag to indicate that risk is archived.
   * - Cancelled
     - Flag to indicate that risk is cancelled.
   * - Result
     - Complete description of the treatment done on the risk.  
 
**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Opportunity 

Opportunity
-----------

An opportunity can be seen as a positive risk. It is not a threat but the opportunity to have a positive impact to the project.

The risk management plan is a key point to Project Management :

 - identify risks and estimate their severity and likelihood.

 - identify mitigating actions

 - identify opportunities

 - follow-up actions

 - identify risks that finally occur (becoming an issue)

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
     - Unique Id for the opportunity.
   * - **Name**
     - Short description of the opportunity.
   * - **Type**
     - Type of opportunity.
   * - **Project**
     - The project concerned by the opportunity.
   * - Severity
     - Level of importance of the impact for the project.
   * - Expected improvement
     - Evaluation of the estimated improvement, or positive impact, on the project of the opportunity.
   * - Criticality
     - Global evaluation level of the opportunity.
   * - :term:`Origin`
     - Element which is the origin of the opportunity.
   * - Opportunity source
     - Description of the event that may trigger the opportunity.
   * - Impact
     - Description of the estimated positive impact on the project.
   * - Description
     - Complete description of the opportunity.

**\* Required field**

.. topic:: Field: Criticality

   * Automatically calculated from Severity and Likelihood (Expected improvement) values.
   * Value can be changed. 

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the opportunity.
   * - Responsible
     - Resource who is responsible for the opportunity.
   * - Priority
     - Expected priority to take into account this opportunity.
   * - Initial end date
     - Initially expected end date of the opportunity.
   * - Planned end date
     - Updated end date of the opportunity.
   * - :term:`Handled`
     - Flag to indicate that opportunity is taken into account.
   * - :term:`Done`
     - Flag to indicate that opportunity has been treated.
   * - :term:`Closed`
     - Flag to indicate that opportunity is archived.
   * - Cancelled
     - Flag to indicate that opportunity is cancelled.
   * - Result
     - Complete description of the treatment of the opportunity.  
 
**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Issue 

Issue
-----

An issue is a problem that occurs during the project.

If the Risk Management Plan has been correctly managed, issues should always be occurring identified Risks.

Actions must be defined to solve the issue.

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
     - Unique Id for the issue.
   * - **Name**
     - Short description of the issue.
   * - **Type**
     - Type of issue.
   * - **Project**
     - The project concerned by the issue.
   * - Criticality
     - Level of importance of the impact for the project.
   * - Priority
     - Priority requested to the treatment of the issue.
   * - :term:`Origin`
     - Element which is the origin of the issue.
   * - Cause
     - Description of the event that led to the issue.
   * - Impact
     - Description of the impact of the issue on the project.
   * - Description
     - Complete description of the issue.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the issue.
   * - Responsible
     - Resource who is responsible for the issue.
   * - Initial end date
     - Initially expected end date of the issue.
   * - Planned end date
     - Updated end date of the issue.
   * - :term:`Handled`
     - Flag to indicate that issue is taken into account.
   * - :term:`Done`
     - Flag to indicate that issue has been treated.
   * - :term:`Closed`
     - Flag to indicate that issue is archived.
   * - Cancelled
     - Flag to indicate that issue is cancelled.
   * - Result
     - Complete description of the treatment of the issue.  
 
**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Action 

Action
------

An action is a task or activity that is set-up in order to :

 - reduce the likelihood of a risk

 - or reduce the impact of a risk

 - or solve an issue

 - or build a post-meeting action plan

 - or just define a “to do list”.

The actions are the main activities of the risk management plan.

They must be regularly followed-up.

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
     - Unique Id for the action.
   * - **Name**
     - Short description of the action.
   * - **Action type**
     - Type of action.
   * - **Project**
     - The project concerned by the action.
   * - Priority
     - Priority requested to the treatment of the action.
   * - Description
     - Complete description of the action.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the action.
   * - Responsible
     - Resource who is responsible for the action.
   * - Initial end date
     - Initially expected end date of the action.
   * - Planned end date
     - Updated end date of the action.
   * - :term:`Handled`
     - Flag to indicate that action is taken into account.
   * - :term:`Done`
     - Flag to indicate that action has been treated.
   * - :term:`Closed`
     - Flag to indicate that action is archived.
   * - Cancelled
     - Flag to indicate that action is cancelled.
   * - Efficiency
     - Evaluation of the efficiency the action had on the objective (for instance on the risk mitigation).
   * - Result
     - Complete description of the treatment of the action.  
 
**\* Required field**


