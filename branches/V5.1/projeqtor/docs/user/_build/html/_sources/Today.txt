.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Today
   :depth: 3
   :backlinks: top
   :local:

.. title:: Today


.. index:: ! Today

Today
-----

Today screen with summary data for project, list of work (to do list) and list of tasks to follow-up.

Today screen is completely configurable.

Any report can be displayed on today screen.

The “Today” screen is the first to be displayed on each connection.

It is divided in several parts. Each part can be folded/unfolded with a click on the header.


Section: Messages
^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/today_messages.png
   :scale: 60 %
   :alt: Today messages section
   :align: center

   Messages section

.. rubric:: Messages

* Messages are displayed depends on affected project or profile. 
* Every message is component by title |one| and message |two|.
* Messages are defined in :ref:`tools-message-label` screen in tools function.

.. topic:: Color title

   * Color title change depending on message type :
     	
     * Blue : Information message
     * Yellow : Warning message
     * Red : Alert message 

.. rubric:: Printing

* Click on |iconPrint| to print Today screen. 


.. raw:: latex

    \newpage

Parameters
""""""""""

* Click on |buttonIconParameter| to access screen parameters.

.. figure:: /images/GUI/today_Parameters.png
   :scale: 80 %
   :alt: Today parameters Popup
   :align: center

   Today parameters Popup

.. rubric:: Period for task selection

* Allows to define the period for tasks will be displayed.

.. topic:: Field : Due date

   * Select only items with due date less than today plus this selected period.

.. topic:: Field : Or not set

   * Select also items with due date not set. 


.. rubric:: Items to be displayed

* Allows to define tables to display on the screen.

  * Just select or deselect items. 

* Allows to reorder items displayed with drag & drop feature, using the selector area Button icon drag |buttonIconDrag|. 





.. raw:: latex

    \newpage


Section: Start guide
^^^^^^^^^^^^^^^^^^^^

* Start page for new installations to assist the administrator in the first configuration steps.
* A progress display |one| allows to determine the percent of complete installation.
* You can hide this section on startup, just not checked |two|.

  * This section will not be displayed any more.
  * To show it again, select it as the start page in user parameters. 

.. figure:: /images/GUI/today_StartGuide.png
   :scale: 60 %
   :alt: Today start guide section
   :align: center

   Start guide section





.. raw:: latex

    \newpage

Section: Projects
^^^^^^^^^^^^^^^^^

A quick overview of projects status.

The projects list is limited to the project visibility scope of the connected user. 

.. figure:: /images/GUI/today_Projects.png
   :scale: 60 %
   :alt: Today projects section
   :align: center

   Projects section



.. rubric:: Scope of the numbers counted

* Checkboxes allow to filter displayed projects: |one|

  * To do: Projects to do.
  * Not closed : Projects to do and done.
  * All : Projects to do, done and closed.

.. rubric:: Projects name

* Click on the name of a project will directly move to it. 

.. rubric:: Manuel indicators

* Manuel indicator can be set on project.
* Trend and health status indicators are displayed.

.. topic:: Icon: Trend |two| 

   * This icon allows to display the trend of the project.

.. topic:: Icon: Health status |three|

   * This icon allows to display the health status of the project.  

.. raw:: latex

    \newpage   

.. rubric:: Progress

* Calculated progress and Overall progress are displayed.

.. topic:: Calculated progress |four|

   * Actual progress of the work of project.

   .. note:: On mouse over the bar

      * On each project shows part of “to do” (red) compared to “done and closed” (green).

.. topic:: Overall progress |five|

   * Additional progress manually selected for the project.

.. rubric:: Project metrics

* Some metrics are displayed on each project. |six|

.. tabularcolumns:: |l|l|

.. list-table:: Project metrics fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Left
     - Left work for the project.
   * - Margin
     - Work margin.
   * - End date
     - Planified end date of the project.
   * - Late
     - Number of late days in project.

.. rubric:: Numbers of elements concerned to project

* Numbers of elements concerned to a project are displayed. |seven|

.. note:: On mouse over the bar

   * On each element shows part of “to do” (red) compared to “done and closed” (green).


.. raw:: latex

    \newpage

Sections: Tasks
^^^^^^^^^^^^^^^

Here are listed, as a “To do list” all the items for which the connected user is either “assigned to”, “responsible of”, “issuer or requestor of”, or "projects I am affected to".

Click on the name of an item will directly move to it.

.. note:: List limit

   * Number of items listed here are limited to a value defined in the global parameters screen.

.. tabularcolumns:: |l|l|

.. list-table:: Task sections fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`id`
     - Unique Id for the item.
   * - Project
     - The project concerned by the item.
   * - Type
     - Type of item.
   * - Name
     - Name of the item.
   * - Due date
     - Planned end date or due date.
   * - Status
     - Actual status of the item.
   * - Issuer
     - Flag on indicate the user is the issuer for the item.
   * - Resp.
     - Flag on indicate the user is the responsible for the item.

.. topic:: Column: Id

   * Id column displayed unique Id and specific icon for the item. 


.. raw:: latex

    \newpage    

Extending section
^^^^^^^^^^^^^^^^^

You can select any report to be displayed on the Today screen.

.. rubric:: Add selected report

* To do this, just go to the selected report, select parameters and display result (to check it is what you wish on today screen). 
* Click on |buttonIconToday| to insert this report with parameter on the today screen.
* Any unchanged parameter will be set as default value.
* These reports will be displayed on Today screen like other pre-defined parts.

.. figure:: /images/GUI/today_extending_section.png
   :scale: 60 %
   :alt: Report selection
   :align: center

   Report selection    

.. rubric:: Manage extending section

* Click on |buttonIconParameter| to access screen parameters.
* You can reorder like any other parts.
* Click on |buttonIconDelete| to completely remove them from the list.

.. figure:: /images/GUI/today_ParametersWithExtending.png
   :scale: 40 %
   :alt: Today parameters Popup with extending parts 
   :align: center

   Today parameters Popup with extending parts 

 


 



