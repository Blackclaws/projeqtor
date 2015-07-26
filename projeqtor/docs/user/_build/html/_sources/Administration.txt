.. raw:: latex

    \newpage

.. contents:: Administration
   :depth: 2
   :backlinks: top
   :local:

.. title:: Administration

.. note::

   * The screens describe below  is restricted to users with administrator profile.
   * Users with others profiles can have access whether is given access rights to screens.   


.. index:: ! Administration console

Administration console
----------------------

Administration console allows to execute administration tasks on application.


.. rubric:: Section: Background tasks

* Allows to start and stop background task is a specific threaded treatment that regularly checks for indicators to generate corresponding alerts, warnings and automatic import when needed.

.. rubric:: Section: Send an internal alert

* Allows to send an internal alert to users.

.. rubric:: Section: Manage connections

* Allows to force disconnection of active users and close the application for new connections.

.. topic:: Users disconnection

   * Allows to disconnect all connected users except your own connection.

   .. note::

      * Disconnection will be effective for each user when his browser will ckeck for alerts to be displayed.
 
      * Delay for the effective disconnection of users will depend on the parameter “delay (in second) to check alerts” in :ref:`administration-global-parameters-label`.


.. topic:: Open and close application.

   * Allows to open and close application.
   * When the application is closed the closed message will appear on login screen. 

.. rubric:: Section: Maintenance of Data
 
* Administrator has the possibility to :

  * Close and delete sent emails and alerts. 
  * Delete connections history log. 
  * Update reference for any kind of element.  

.. rubric:: Section: Log files maintenance

* Administrator has the possibility to :
  
  * Delete old log files.
  * Show the list and specific log file.

.. index:: ! Audit connections

Audit connections
-----------------

* Audit connection proposes a view of “who is online”.

* Administrator has the possibility to force the disconnection of any user (except his own current connection).

.. raw:: latex

    \newpage

.. index:: ! Global parameters

.. _administration-global-parameters-label:

Global parameters
-----------------

Global parameters screen allows configuration of application settings.

.. note:: Tooltip

   * Moving the mouse over the caption of a parameter will display a tooltip with more description about the parameter.

.. rubric:: Section: Daily work hours

* Definition of regular “work hours”.

* Used to calculate delays based on “open hours”.





.. rubric:: Section: Units for work

.. topic:: Fields: Unit for real work allocation and for all work data

   * Definition of the unit can be in days or hours.

   .. note::
     
      * If both values are different, rounding errors may occur.
      * Remember that data is always stored in days.   
      * Duration will always be displayed in days, whatever the workload unit. 

.. topic:: Field: Number of hours per day

   * Allows to set number of hours per day.

.. topic:: Field: Max days to book work

   * Allows to set a max of days resource can enter real work without receiving an alert. 




.. rubric:: Section: Planning

* Specific parameters about Gantt planning presentation.

.. topic:: Field: Show resource in Gantt

   * Select if the resource can be displayed in a Gantt chart, and format for display : name or initials.

.. topic:: Field: Max projects to display 

   * Select max project to display (to avoid performance issue).

.. topic:: Field: Print Gantt with 'old style' format

   * Propose possibility to display “old style” Gantt : may cause performance issue, but could fix some display issue on browsers.

.. topic:: Field: Consolidate validated work & cost

   * Select if validated work & cost are consolidated on top activities and projects :
  
     * Never : Not consolidate
     * Always : Consolidate value replace value set of activities and project.
     * Only is set : Consolidate value don't replace value set of activities and project.

.. topic:: Field: Apply strict mode for dependencies

   * If no, a task can begin the same day as the preceding one.
 





.. rubric:: Section: Real work allocation

* Behavior of real work allocation screen, to define displayed tasks, and set handled status on first real work.

.. topic:: Field: Display only handled tasks

   * Select if only task with handled status is displayed.

.. topic:: Field: Set to first 'handled' status 

   * [Besoin d'explication]



.. rubric:: Section: Responsible

Behavior about management of responsible, including automatic initialization of responsible.

.. rubric:: Section: User and password

Security constraints about users and passwords.

.. rubric:: Section: Ldap management parameters

Information about LDAP connection and behavior on creation of new user from LDAP connection.

.. rubric:: Section: Format for reference numbering

Global parameters for reference formatting :

* Prefix : can contain {PROJ} for project code, {TYPE} for type code, {YEAR} for current year and {MONTH} for current month.

Global parameters for Document reference formatting :

* format : can contain {PROJ} for project code, {TYPE} for type code, {NUM} for number as computed for reference, and {NAME} for document name.
* Suffix : can contain {VERS} for version name.

.. rubric:: Section: Localization

* Localization and internationalization (i18n) parameters.

.. rubric:: Section: Miscellanous

Miscellaneous parameters :
 
* Auto check (or not) for existing new version of the tool (only administrator is informed);

* Separator for CSV files (on export and export);

* Memory limit for PDF generation.

.. rubric:: Section: Display

* Selection of graphic interface behavior and generic display parameter for users.

* Icon size are default : user can overwrite these values

.. rubric:: Section: Files and Directories

Definition of directories and other parameters used for Files management.

.. warning:: Attachments Directory

   Should be set out of web reach.

.. warning:: Temporary directory for reports
  
   Must be kept in web reach.

.. rubric:: Section: Document

Definition of directories and other parameters used for Documents management.

.. warning:: Root directory for documents

   Should be set out of web reach. 


.. rubric:: Section: Billing

Billing parameters, used to format bill number.

.. rubric:: Section: Management of automated service (CRON)

Parameters for the “Cron” process.

.. topic:: Defined frequency for these automatic functions

   * It will manage :

     * Alert generation : Frequency for recalculation of indicators values.

     * Check alert : Frequency for client side browser to check if alert has to be displayed.

     * Import : Automatic import parameters.

   .. warning:: Cron working directory

      Should be set out of web reach.

   .. warning:: Directory of automated integration files
     
      Should must be set out of web reach.

.. topic:: Defined parameters for the “Reply to” process
   
   * It will manage connection to IMAP INBOX to retrieve email answers.

   .. note:: Email input check cron delay

      * Delay of -1 deactivates this functionality. 

   .. note:: IMAP host

      * Must be an IMAP connection string.
   
      * Ex: to connect to GMAIL input box, host must be: {imap.gmail.com:993/imap/ssl}INBOX

.. rubric:: Section: Emailing

Parameters to allow the application to send emails.

.. rubric:: Section: Mail titles

* Parameters to define title of email depending on event (1).

(see: :ref:`administration-special-field-label`)

.. raw:: latex

    \newpage

.. index:: ! Special fields

.. _administration-special-field-label:

Special fields
""""""""""""""

Special fields can be used in the title and body mail to be replaced by item values :

* ${dbName} : the display name of the instance
* ${id} : id of the item
* ${item} : the class of the item (for instance "Ticket") 
* ${name} : name of the item
* ${status} : the current status of the item
* ${project} : the name of the project of the item
* ${type} : the type of the item
* ${reference} : the reference of the item
* ${externalReference} : the :term:`external reference` of the item
* ${issuer} : the name of the issuer of the item
* ${responsible}  : the name of the responsible for the item
* ${sender} : the name of the sender of email
* ${sponsor} : the name of the project sponsor
* ${projectCode} : the project code
* ${contractCode} : the contact code of project
* ${customer} : Customer of project 
* ${url} : the URL for direct access to the item
* ${login} the user name
* ${password} the user password
* ${adminMail} the email of administrator





