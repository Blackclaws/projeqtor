.. raw:: latex

    \newpage


.. contents:: Requirements and Tests
   :depth: 1
   :backlinks: top
   :local:


.. title:: Requirements and Tests

.. index:: ! Requirement 

Requirement
-----------

Requirements are rules that must be applied to a product.

In most IT projects, requirements are functional rules for a software.

A requirement must be defined for a Product and/or a project (at least one of both must be selected).

A requirement can also be defined for a given version of the product, meaning the rule is valid since this “target version”.  

Linking requirements to a project will limit the visibility, respecting rights management at project level.

Requirements can be linked to many items (like other items), but the most interesting are links to test cases.

Linking a requirement to a test case will display summary of test case run (defined in test session). This way, you will have instant display of test coverage for the requirement.


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
     - Unique Id for the requirement.
   * - **Name**
     - Short description of the requirement.
   * - **Requirement type**
     - Type of requirement.
   * - **Project**
     - The project concerned by the requirement.
   * - **Product**
     - The product concerned by the requirement.
   * - :term:`External reference`
     - External reference for the requirement.
   * - Requestor
     - Contact who requested the requirement.
   * - :term:`Origin`
     - Element which is the origin of the requirement.
   * - Urgency
     - Urgency of implementation of the requirement.
   * - Initial due date
     - Initial date due.
   * - Planned due date
     - Planned due date.
   * - **Description**
     - Long description of the requirement.

**\* Required field**

.. topic:: Fields: Project and Product

   * Project or product must be set. 
   * You can set both.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Top requirement
     - Parent requirement, defining a hierarchic structure.
   * - **Status**
     - Actual :term:`status` of the requirement.
   * - Responsible
     - Resource who is responsible for the requirement.
   * - Criticality
     - Level of criticality of the requirement for the product.
   * - Feasibility
     - Result of first analysis to check the feasibility of the implementation of the requirement.
   * - Technical risk
     - Result of first analysis to measure the technical risk of the implementation of the requirement.
   * - Estimated effort
     - Result of first analysis to measure the estimated effort of the implementation of the requirement.
   * - :term:`Handled`
     - Flag to indicate that requirement is taken into account.
   * - :term:`Done`
     - Flag to indicate that requirement has been treated.
   * - :term:`Closed`
     - Flag to indicate that requirement is archived.
   * - Cancelled
     - Flag to indicate that requirement is cancelled.
   * - Target version
     - Version of the product where the requirement will be active.	
   * - Result
     - Description of the implementation of the requirement. 
 
**\* Required field**

.. rubric:: Section: Lock

A requirement can be locked to ensure that its definition is not changed during the implementation process.

Only the user who locked the requirement or a habilitated user can unlock a requirement.

.. topic:: Button: Lock / Unlock requirement

   * Button to lock or unlock the requirement to preserve it from being changed.

.. topic:: Requirement locked

   * When requirement is locked the next fields are set.

.. tabularcolumns:: |l|l|

.. list-table:: Fields when requirement is locked
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Locked
     - Flag to indicated that the requirement is locked.
   * - Locked by
     - User who locked the requirement (if locked).
   * - Locked since
     - Date and time when requirement was locked (if locked).


.. raw:: latex

    \newpage

.. rubric:: Section: Summary of tests cases

When test cases are linked to a requirement, this section summarizes the status of theses tests.

.. topic:: Details of fields

   **Summary**

   * Global status of tests linked to the requirement, as appering in all tests sessions including the tests.
 
   **failed**

   * At least one test failed.

   **blocked**

   * No test failed, at least one test blocked.

   **planned**

   * No test failed or blocked, at least one test planned.

   **passed**

   * All tests passed.

   **not planned**

   * No test linked.

   **Linked**

   * Number of test cases linked to the requirement.

   **Total**

   * Number of test cases on a test session whatever the status of the test case.
 
   * Because a test case can be linked to several test sessions, total can be greater than linked.

   * Planned, Passed, Blocked, Failed : number of test cases on a test session in the corresponding status. 

   **Issues**

   * Number of tickets linked to the requirement.

.. raw:: latex

    \newpage

.. index:: ! Test case 

Test case
---------

Test cases are elementary actions executed to test a requirement.
You may define several tests to check a requirement, or check several requirements with one test.

A test case must be defined for a Product and/or a project (at least one of both must be selected).
A test case can also be defined for a given version of the product, meaning the test is valid since this “version”.
Linking test case to a project will limit the visibility, respecting rights management at project level.

In the test case screen, you’ll find a complete list of test case run. These are links of the test to test sessions.
You cannot change links or status here, you must go to the corresponding test session.

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
     - Unique Id for the test case.
   * - **Name**
     - Short description of the test case.
   * - **Test type**
     - Type of test case.
   * - **Project**
     - The project concerned by the test case.
   * - **Product**
     - The product concerned by the test case.
   * - Product version
     - Version of the product where the test case will be valid.
   * - :term:`External reference`
     - External reference for the test case.
   * - Environment
     - List of 3 items describing the context of the test case.
   * - **Description**
     - Complete description of the test case.

**\* Required field**

.. topic:: Fields: Project and Product

   * Project or product must be set. 
   * You can set both.

.. topic:: Field: Environment

   * Contexts are initialized for IT Projects as “Environment”, “OS” and “Browser”.
   * This can be easily changed in the “Contexts” definition screen.

.. topic:: Field: Description

   * The description for test case should describe the steps to run the test.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent test case
     - Parent test case, defining a hierarchic structure for test cases.
   * - **Status**
     - Actual :term:`status` of the requirement.
   * - Responsible
     - Resource who is responsible of the test case.
   * - Priority
     - Level of priority for the test case.
   * - :term:`Handled`
     - Flag to indicate that test case is taken into account.
   * - :term:`Done`
     - Flag to indicate that test case has been treated.
   * - :term:`Closed`
     - Flag to indicate that test case is archived.
   * - Cancelled
     - Flag to indicate that test case is cancelled.
   * - Prerequisite
     - List of steps that must be performed before running the test.	
   * - Expected result
     - Description of expected result of the test.
   * - Summary
     - Summary of test case run in the test sessions. 
 
**\* Required field**

.. topic:: Field: Prerequisite

   * If left blank and test case has a parent, parent prerequisite will automatically be copied here. 

.. rubric:: Section: Test case runs

In the test case screen, you’ll find a complete list of test case run.

These are links of the test to test sessions.

This list also displays the current status of the test in the sessions.

You cannot change links or status here, you must go to the corresponding test session.

.. raw:: latex

    \newpage

.. index:: ! Test session 

.. _reqTest-test-session-label:

Test session
------------

A test session defines all the tests to be executed to reach a given target.

When running the test, you be able to easily change the status of the test run.

The status for tests cases on session are :

* Planned : test to be executed.

* Passed : test passed with success (result is conform to expected result).

* Blocked : impossible to run the test because of prior incident (blocking incident or incident on preceding test) or missing prerequisite.

* Failed : test has return wrong result.

  * When status is set to failed, the reference to a ticket must be defined (reference to the incident).

.. rubric:: Ressources assignment

* Resources can be assigned to Test sessions, exactly in the same way as assignment to activities.
* See : :ref:`pe-assignment-section-label`

.. sidebar:: Other sections

   * :ref:`pe-assignment-section-label`

   * :ref:`pe-progress-section-label`

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
     - Unique Id for the test session.
   * - **Name**
     - Short description of the test session.
   * - **Session type**
     - Type of test session.
   * - **Project**
     - The project concerned by the test session.
   * - **Product**
     - The product concerned by the test session.
   * - Product version
     - Version of the product where the test session will be valid.
   * - :term:`External reference`
     - External reference for the test session.
   * - **Description**
     - Complete description of the test session.

**\* Required field**

.. topic:: Fields: Project and Product

   * Project or product must be set. 
   * You can set both.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity
     - Parent activity, to define hierarchic position in the Gantt.
   * - Parent session
     - Parent session, to define session of sessions.
   * - **Status**
     - Actual :term:`status` of the test session.
   * - Responsible
     - Resource who is responsible of the test session.
   * - :term:`Handled`
     - Flag to indicate that test session is taken into account.
   * - :term:`Done`
     - Flag to indicate that test session has been treated.
   * - :term:`Closed`
     - Flag to indicate that test session is archived.
   * - Cancelled
     - Flag to indicate that test session is cancelled.
   * - Result
     - Summary result of the test session. 
 
**\* Required field**

