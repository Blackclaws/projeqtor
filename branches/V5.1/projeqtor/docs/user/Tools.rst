.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Tools
   :depth: 1
   :backlinks: top
   :local:


.. title:: Tools

.. index:: ! Emails sent

Emails sent
-----------

You can have a look at the list of the automatic emails sent (see related topic).

You will have all the information about the email, including the status showing whether the email was correctly sent or not.

The information in the screen is read-only.

.. index:: ! Alerts

Alerts
------

You can have a look at the alerts sent.

By default, administrators can see all the alerts sent, and other users only see their own alerts.

This screen is read only.

If you are the receiver of the alert, and the alert is not tagged “read” yet (for instance you clicked “remind me” when alert was displayed), you will have a button to “mark as read” the alert. 


.. raw:: latex

    \newpage

.. index:: ! Message


.. _tools-message-label:

Message
-------

You can define some message that will be displayed on the “today” screen of users.

Optionnaly, the message can be showed on login screen.

You can limit the display to some profile and project.

The message will be displayed in a color depending on the Message type.

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
     - Unique Id for the message. 
   * - **title**
     - Header of the message.
   * - **Message type**
     - Type of message. 
   * - Profile
     - The profile of users who will see the message.
   * - Project
     - The project to limit display.
   * - Show on login screen
     - Show this message on login screen. 
   * - :term:`Closed`
     - Flag to indicate that resource is archived.
 
**\* Required field**

.. topic:: Field: Project

   * Only resources affected to the project will see the message.

.. rubric:: Section: Message

* Complete text of the message.

.. raw:: latex

    \newpage


.. index:: ! Import data

Import data
-----------

Imports work from CSV or XLSX files.

The first line of the file must contain de name of the fields : look into the Model class : the names are the same.

Just click on specific help button |buttonIconHelp| to have help on fields.

You may or may not add an "id" column to the file :

 - if column "id" exists and "id" is set for a line, the import will try to update the corresponding element, and will fail if it does not exist

 - if column "id" does not exists or if "id" is not set for a line, the import will create a new element from the data.  

In any case, columns with no data will not be updated : then you can update only one field on an element. To clear a data, enter the value "NULL" (not case sensitive).

For columns corresponding to linked tables ("idXxxx"), you can indicate as the column name  either "idXxxx“ or “Xxxx" (without "id") or the caption of the column (as displayed on screens).

If the value of the column is numeric, it is considered as the code of the item.

If the value of the column contains non numeric value, it is considered as name of the item, and the code will be searched from the name. 

Names of columns can contain spaces (to have better readability) : the spaces will be removed to get the name of the column.

Dates are expected in format “YYYY-MM-DD”.

Insertion into "Planning" elements (activity, project), automatically inserts an element in the table “PlanningElement” : the data of this table can be inserted into the import file (working from version V1.3.0).

.. warning::

   Pay attention if you intend to import users :

   * If you want to create new users don't put any id because if id already exists it will be overridden by the new (with possibility to erase admin user…)

   * The password field must be cut and pasted from the database because it is encrypted, then if you enter some readable password, the users will not be able to connect.

   * Always keep in mind that your import may have some impact on administrator user. So be sure to keep an operational admin access.


.. rubric:: How to do

* Select the element type from the list.

  * The content of the imported file must fit the element type description.

  * To know the data that may be imported, click on the |buttonIconHelp| button.

* After selecting file format (CSV or XLSX) and file to import, you can Import Data.

  * You will then have a full report of the import :

    * Data that is not imported because not recognized as a field appear in grey text in the result table.
    * Data that are voluntarily not imported (because must be calculated) appear in blue text in the result table.
