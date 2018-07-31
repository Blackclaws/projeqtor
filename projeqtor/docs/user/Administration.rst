.. title:: Administration

.. note::

   * The screens described below are restricted to users with administrator profile.
   * Users with others profiles can have access whether access rights is granted.   


.. index:: ! Administration console

.. _admin-console:

Administration console
----------------------

Administration console allows to execute administration tasks on application.

.. index:: ! Internal alert (Background tasks)
.. index:: ! Email (Background tasks)
.. index:: ! Import data (Background tasks)

.. rubric:: Section: Background tasks

* Allows to start and stop background task is a specific threaded treatment that regularly checks for indicators to generate corresponding alerts, warnings and automatic import when needed.


.. index:: ! Internal alert (Send)

.. rubric:: Section: Send an internal alert

* Allows to send an internal alert to users.

.. index:: ! Connection (Management)

.. rubric:: Section: Manage connections

* Allows to force disconnection of active users and close the application for new connections.

 .. compound:: **Button: Disconnect all users**

    * Allows to disconnect all connected users except your own connection.
    * The application status is displayed below.

    .. note::

       * Disconnection will be effective for each user when his browser will ckeck for alerts to be displayed.
       * The delay for the effective disconnection of users will depend on the parameter “delay (in second) to check alerts” in :ref:`Global parameters<automated-service>` screen.

 .. compound:: **Button: Open/Close application**

    * Allows to open and close application.
    * When the application is closed the message below will appear on login screen.


.. index:: ! Email (Maintenance of Data)
.. index:: ! Internal alert (Maintenance of Data)
.. index:: ! Connection (Maintenance of Data)

.. rubric:: Section: Maintenance of Data
 
* The administrator has the possibility to:

  * Close and delete sent emails and alerts. 
  * Delete history of connections. 
  * Updating references for any kind of element.

.. index:: ! Log file (Maintenance)   

.. rubric:: Section: Log files maintenance

* The administrator has the possibility to:
  
  * Delete old log files.
  * Show the list and specific log file.

.. index:: ! Audit connections
.. index:: ! Connection (Audit)

.. _audit-connections:

Audit connections
-----------------

* Audit connection proposes a view of “who is online”.

.. note::

   * The administrator has the possibility to force the disconnection of any user (except his own current connection), see: :ref:`admin-console`.

.. raw:: latex

    \newpage

.. index:: ! Global parameters

.. _global-parameters:

Global parameters
-----------------

Global parameters screen allows configuration of application settings.

.. note:: Tooltip

   * Moving the mouse over the caption of a parameter will display a tooltip with more description about the parameter.

.. rubric:: GENERAL SECTION 1: Work time

.. _daily-work-hours-section:

.. rubric:: Section: Daily work hours

* Definition of regular “work hours”.

* Used to calculate delays based on “open hours”.

.. rubric:: Section: Open days

* Possibility to define the working days in the company.

  * For each day of the week, you can choose between open days or off days.

  .. note::
  
       * This parameter are taken into account in : working days on calendars, the working days on the calculation and the display ,the working days on the display of real work allocation.

.. index:: ! Real work allocation (Unit for work)
.. index:: ! Workload (Unit form work)

.. _unitForWork-section:

.. rubric:: Section: Units for work

* The parameters to real work allocation and workload.

 .. compound:: **Fields: Unit for real work allocation and for all work data**

    * Definition of the unit can be in days or hours.

    .. note::
     
       * If both values are different, rounding errors may occur.
       * Remember that data is always stored in days.   
       * Duration will always be displayed in days, whatever the workload unit. 

 .. compound:: **Number of hours per day**

    * Allows to set number of hours per day.

.. index:: ! Real work allocation (Behavior)

.. _realWorkAllocation-section:

.. rubric:: Section: Real work allocation

* Defines behavior of tasks in the real work allocation screen.

 .. compound:: **Display only handled tasks**

    * Display only tasks with "handled" status.

 .. compound:: **Set to first 'handled' status**

    * Change status of the task to the first "handled" status when  real work is entered.

 .. compound:: **Set to first 'done' status**

    * Change status of the task to the first "done" status when no left work remains.

 .. compound:: **Max days to book work (warning) :**

    * Number of days that user can enter real work in the future before getting a warning.
    
    .. note::
        * this parameter does not apply to administrative projects
    
 .. compound:: **Max days to book work (blocking)**

    * Number of days that user can enter real work in the future. This limit is blocking.
  
  .. note::
        * this parameter does not apply to administrative projects
  
 .. compound:: **Alert resource on input done by someone else**

    * Select your type of alert : Internal, Email, both or none.

 .. compound:: **Display pools on timesheet**
     * Possibly to display the pool whose the resource belongs to.

.. rubric:: GENERAL SECTION 2 : Activity

.. rubric:: Section: Planning

* Specific parameters about Gantt planning presentation.

 .. compound:: **Show resource in Gantt**

    * Select if the resource can be displayed in a Gantt chart, and format for display (name or initials or none).

 .. compound:: **Max projects to display**

    * Defines maximum number of projects to display.
    * To avoid performance issues.


  .. compound:: **Apply strict mode for dependencies**

    * If yes, the successor should begin the next day 
    * If no, the successor can start the same day.
    
.. rubric:: Section: Tickets

.. compound:: **Only responsible works on ticket**

    * Only responsible can enter some real work on the ticket.

 .. compound:: **Ticket responsible from product Responsible**

    * Select if the product Responsible is displayed ( always, if empty, never) as Ticket Responsible on that screen

 .. compound:: **Limit planning activity to those whit flag**
    * Display planning activity selected for the ticket

 .. compound:: **Enable to filter ticket reports by priority**
    * Can display tickets on Report screen by level of priority

 .. compound:: **Display ticket at customer level**
    * Display of tickets on the Customer screen and on the Contacts screen

 .. compound:: **Display ticket at version level**
    * Display of tickets on the version screen 

 .. compound:: **Manage accontable on ticket**
    * Display the coordinator as Accountable, so the Responsible is the current actor
    
.. rubric:: Section: Organization

.. compound:: **Use budget feature for organizations**

    *If yes, can display and work on budget for an organization.



.. rubric:: Section: Automation

 .. compound:: **Consolidate validated work & cost**

    * Select if validated work & cost are consolidated on top activities and therefore for projects :
  
      * **Never** : Not consolidated
      * **Always** : Values are replaced on activities and project.(erase parents)
      * **Only is set** : Replaces values ( excepted if set by null or stay not indicated,do not erase parents)

 .. compound:: **Auto set Responsible if single resource**

    * Automatically set Responsible if not set and by the only one resource allocated to the project 

 .. compound:: ** Auto allocated the Manager to the project**
 * Automatically create an allocation for the project Manager to the project. He should be a resource.

 .. compound:: ** Auto set a Responsible if needed**
 * Automatically set Responsible to current resource (as using the element) if not set and if a Responsible is required (respecting access rights)

 .. compound:: ** Auto assign Responsible to activity**
 * Assign automatically the Responsible to activities

 .. compound:: ** Update milestone from deliverable** (Have to link elements)
 * Update milestone Responsible automatically when the Responsible of deliverable has changed.

 .. compound:: ** Update milestone from incoming** (Have to link elements)
 * Update milestone Responsible automatically when the Responsible of deliverable has changed.

 .. compound:: ** Update deliverable from milestone**(have to link elements)
 * Update deliverable Responsible automatically when the Responsible of mielstone has changed.

 .. compound:: ** Update incoming from milestone**(have to link elements)
 * Update incoming Responsible automatically when the Responsible of milestone has changed.

 .. compound:: ** Auto set parent activity status**
 * Auto set status of parent activity from the status of children activity. 


.. rubric:: Section: Milestones

 .. compound:: ** Manage target milestone**
 * It updates the target (planned) date of the element (on Requirements, Tickets, Product Versions, Incomings, Deliverables and Deliveries) from the planned date of the milestone.

 .. compound:: ** Auto link the milestone**
 * It optionally allows you to display the element linked to the milestone (The option above should be on "yes" to have access to the selection of milestone targetted)

 .. compound:: ** Set milestone from product version**
 * It optionally allows you to automatically retrieve the milestone from the milestone of the Project Version.
   
.. rubric:: Section: Controls and restrictions

 .. compound:: ** Allow type restriction on project**
 * if yes : allow to define additional restrictions of types on each projet type additionally to restrictions defined eventually at each project type level by the Administrator.

 
.. rubric:: GENERAL SECTION 3 : Display
.. rubric:: Section: Display
.. rubric:: Section: Localization
.. rubric:: Section: Default values for user parameters
.. rubric:: GENERAL SECTION 4 : Miscellaneous
.. rubric:: Section: Format for reference numbering
* Allows to define reference formats for items of element, documents and bills.
  * Prefix : can contain {PROJ} for project code, {TYPE} for type code, {YEAR} for current year and {MONTH} for current month.

.. rubric:: Section: Document reference format
* Format : can contain {PROJ} for project code, {TYPE} for type code, {NUM} for number as computed for reference, and {NAME} for document name.

* Suffix : can contain {VERS} for version name.
    
.. rubric:: Section: Bill reference format
.. rubric:: Section: Product and Component

.. rubric:: GENERAL SECTION 5 : Mailing

.. rubric:: Section: Emailing
.. rubric:: Section: Mail titles
.. rubric:: Section: Automatic emails grouping

E-mail sending delay: possibility not to send emails in a row, but to delay them to send only one message if several changes generating an emails send are made in a short time.

.. rubric:: Section: Test email configuration

.. rubric:: GENERAL SECTION 6 : Authentication
.. rubric:: Section: Ldap management parameters

* Information about LDAP connection and behavior on creation of new user from LDAP connection.

.. rubric:: Section: User and password

* Security constraints about users and passwords.

.. rubric:: GENERAL SECTION 7 : Automation
.. rubric:: Section: Management of automated service (CRON)
Parameters for the “Cron” process.

.. topic:: Defined frequency for these automatic functions

   * It will manage :

     * Alert generation : Frequency for recalculation of indicators values.

     * Check alert : Frequency for client side browser to check if alert has to be displayed.

     * Import : Automatic import parameters as below.
     
.. rubric:: Section: Automatic import of files
.. warning:: Cron working directory

      Should be set out of web reach.

.. warning:: Directory of automated integration files
     
      Should must be set out of web reach.
.. rubric:: Section: Automatic import of replies to emails
.. topic:: Defined parameters for the “Reply to” process
   
   * It will manage connection to IMAP INBOX to retrieve email answers.

   .. note:: Email input check cron delay

      * Delay of -1 deactivates this functionality. 

   .. note:: IMAP host

      * Must be an IMAP connection string.
   
      * Ex: to connect to GMAIL input box, host must be: {imap.gmail.com:993/imap/ssl}INBOX
.. rubric:: Section: Generation of alerts if real work is not entered

* Specific parameters about alerts.

 .. compound:: **Send reminder on**
 
 * Select a day if you want send a reminder.
  
        .. note:: 
  
            * It is possible to choose every day or never.

 .. compound:: **Send reminder at** 

      * Select the hour when you want receive the reminder.

 .. compound:: **Control input up to**

      * Select when you want to be controlled, current day, previous day or next days.

 .. compound:: **Number of days to control**

      * Choose how many days will be controled
      
        .. note::
              
              * All days of the week, open or off days are taken into account.
              
              * Off days in real work allocation will not send you an alert.

 .. compound:: **Send alert to resource**

      * Select how send alert to ressource, Internal alert, email, both or none.

 .. compound:: **Send alert to project leader**

      * Select how send alert to project leader
      
 .. compound:: **Send alert to team manager**   
      
      * Select how send alert to team manager
.. rubric:: Section: Automatic planning calculation


.. rubric:: GENERAL SECTION 8 : System
.. rubric:: Section: Files and directories
Definition of directories and other parameters used for Files management.

.. warning:: Attachments Directory

   Should be set out of web reach.

.. warning:: Temporary directory for reports
  
   Must be kept in web reach.

.. _document-section:

.. rubric:: Section: Document

Definition of directories and other parameters used for Documents management.

.. warning:: Root directory for documents

   Should be set out of web reach. 
.. rubric:: Section: Localization data

* **Charset to save files on server**

    Keep empty for Linux servers, files names will be stored in UTF8. For windows OS server, define charset as "windows-1252" (for western europe) or similar corresponding to your localization.
    
* **Separator for CSV files (on export and export)**
  
.. rubric:: Section: Miscellaneous
* Auto check (or not) for existing new version of the tool (only administrator is informed);
.. rubric:: Section: PDF export

* Memory limit for PDF generation.

.. rubric:: Section: SSL connection to database

* SSL Key
* SSL Certification
* SSL Certificate Authority
* Enter patch to corresponding files to enable SSL connection to the database.

  .. warning:: Take care that these files must exist and be valid SSL files.
  
     If values are incorrect, the application will not work any more, and you'll have to manually fix parameters in the database.  
    
 666666666666666666666666666666666666666666666666666666666666666666666666666666666666666 
.. compound:: **Print Gantt with 'old style' format**

    * Propose possibility to display “old style” Gantt.
    * May cause performance issues, but could fix some display issue on browsers.



.. compound:: **Apply strict mode for dependencies**

    * Defines if a task can begin the same day as the preceding one.
 
 

  
  


.. _responsible-section:

.. rubric:: Section: Responsible

* Behavior about management of responsible, including automatic initialization of responsible.

 .. compound:: **Auto set responsible if single resource**

    * Automatically set responsible if not set and only one resource if allocated to the project.

 .. compound:: **Auto set responsible if needed**

    * Automatically set responsible to current resource if not set and the responsible is required (depending on status).






.. _global-display-section:

.. rubric:: Section: Display

* Selection of graphic interface behavior and generic display parameter for users.

* Icon size are default : user can overwrite these values




-----------------------

.. _automated-service:

.. rubric:: Section: Management of automated service (CRON)






.. _automatic-import:

.. rubric:: Automatic import

.. topic:: Field: Automatic import cron delay

   *

.. topic:: Field: Directory of automated integration files

   *

.. topic:: Field: Log destination

   * 

.. topic:: Field: Mailing list for logs

   *

------------------------

.. index:: ! Email (Parameters)

.. rubric:: Section: Emailing

Parameters to allow the application to send emails.

.. rubric:: Section: SSL connection to database




.. index:: ! Email (Formatted message)

.. _mail-titles:

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





