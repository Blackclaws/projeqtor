.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Resource
   :depth: 1
   :backlinks: top
   :local:


.. title:: Resource

.. index:: ! Resource 

Resource
--------

The Resource is a person that will work on activities.

A resource can also be a machine or any material resource which availability must be controlled through planning.

The resource is the power to run the project.

The responsible of items is a resource.

.. sidebar:: Other sections
   
   * :ref:`pe-affectations-section-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the resource.
   * - **Real name**
     - Name of the resource. Can contain first and last name.
   * - Photo
     - Photo of the resource.
   * - User name
     - Name of user.
   * - Initials
     - Initials of the resource.
   * - Email address
     - Email address of the resource. 
   * - Profile
     - Profile of the user.
   * - Capacity (FTE)
     - Capacity of the resource, in Full Time Equivalent.
   * - **Calendar**
     - Calendar defining the availability of the resource (off days).
   * - Team
     - The team to which the resource belongs.
   * - Phone
     - Phone number of the resource.
   * - Mobile
     - Mobile phone number of the resource.
   * - Fax
     - Fax number of the resource.
   * - Is a contact
     - Is this resource also a contact ?
   * - Is a user
     - Is this resource also a user ?
   * - :term:`Closed`
     - Flag to indicate that resource is archived.
   * - Description
     - Complete description of the resource.

**\* Required field**


.. topic:: Field: Photo

   * Click on |buttonAdd| or photo frame to add an image file.

.. topic:: Field: User name
   
   * Mandatory if “Is a user” is checked.

.. topic:: Field: Capacity (FTE)

   * Capacity can be :
     
     * lesser than one (for part time working resource)
     * greater than one (for Virtual resource or teams, to use for instance to initialize a planning).

.. topic:: Field: Is a contact
   
   * Check this if the resource must also be a requestor. 

.. topic:: Field: Is a user

   * Check this if the resource must connect to the application.
   * You must then define the user name, that can be the same as the resource name or not, and the profile.
   * The resource will then also appear in the “Users” list. 




.. rubric:: Section: Function and cost

A resource can have un main fonction.

You define the resource cost for a function and a period.

Click |buttonAdd| on to create a new resource cost to the ressource. A “Resource cost” pop up will be displayed. 

Click on |buttonEdit| to update an existing resource cost.

Click on |buttonRemove| to delete the resouce cost.

.. topic:: Pop up "Resource cost”

   Function - Function of the resource for the selected cost.

   Cost   

   * Cost of the resource for the selected function.
 
   * Cost is in currency per day, even if you manage work in hours.

   Start date

   * Start date for the cost of the resource, for the selected function.
  
   * Not selectable for the first cost of a given function for the resource. 

   * Mandatory for others. Then previous cost will be updated to finish at date minus 1 day. 

.. rubric:: Section: Miscellanous

Don't receive team mails - Flag to indicate that resource don't want receive team mails.

.. raw:: latex

    \newpage

.. index:: ! Contact 

Contact
-------

The Contact is a person into the organization of the customer.

The requestor of a ticket must be a contact.

It can be interesting to define all the informative data of the contact to be able to contact him when needed.

.. sidebar:: Other sections

   * :ref:`pe-affectations-section-label`
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the contact.
   * - **Real name**
     - Name of the contact. Can contain first and last name.
   * - Photo
     - Photo of the contact.
   * - User name
     - Name of user.
   * - Initials
     - Initials of the contact.
   * - Email address
     - Email address of the contact. 
   * - Profile
     - Profile of the user.
   * - Customer
     - The Customer the contact belongs to.
   * - Function
     - Function of contact.
   * - Phone
     - Phone number of the contact.
   * - Mobile
     - Mobile phone number of the contact.
   * - Fax
     - Fax number of the contact.
   * - Is a resource
     - Is this contact also a resource ?
   * - Is a user
     - Is this contact also a user ?
   * - :term:`Closed`
     - Flag to indicate that contact is archived.
   * - Description
     - Complete description of the contact.

**\* Required field**


.. topic:: Field: Photo

   * Click on |buttonAdd| or photo frame to add an image file.

.. topic:: Field: Customer

   * The contact is a person into the organization of the customer.
 
.. topic:: Field: Is a resource
   
   * Check this if the contact must also be assigned to activities and be able to input real work.
   * The contact will then also appear in the “Resources” list. 

.. topic:: Field: Is a user

   * Check this if the contact must connect to the application. 
   * You must then define the user name, that can be the same as the contact name or not, and the profile.
   * The contact will then also appear in the “Users” list. 

.. topic:: Field: User name
   
   * Mandatory if “Is a user” is checked.



.. rubric:: Section: Addreses

Full address of the contact.

.. rubric:: Section: Miscellanous

Don't receive team mails - Flag to indicate that resource don't want receive team mails.


.. raw:: latex

    \newpage

.. index:: ! User 

User
----

The User is a person that will be able to connect to the application.

The login id will be the user name.

To be able to connect, user must have a password and a profile defined.

The issuer of items is a user.

.. sidebar:: Other sections

   * :ref:`pe-affectations-section-label`   
   * :ref:`gui-chg-history-section-label`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the user.
   * - **User name**
     - Name of the user, used as login to connect to the application.
   * - Real name
     - Name of the user. Can contain first and last name.
   * - Photo
     - Photo of the user.
   * - Initials
     - Initials of the user.
   * - Email address
     - Email address of the user. 
   * - **Profile**
     - Profile of the user.
   * - Locked
     - Flag used to lock the user, to prohibit connections.
   * - Is a contact
     - Is this user also a contact ?
   * - Is a resource
     - Is this user also a resource ?
   * - :term:`Closed`
     - Flag to indicate that user is archived.
   * - Description
     - Complete description of the user.

**\* Required field**

.. topic:: Field: User name

   * Must be unique.

.. topic:: Field: Photo

   * Click on |buttonAdd| or photo frame to add an image file.

.. topic:: Field: Locked

   * Administrator can unlock the user.
 
.. topic:: Field: Is a contact
   
   * Check this if the user must also be a requestor.
   * This user will then appear in the “Contact” list 

.. topic:: Field: Is a resource

   * Check this if the user must also be assigned to activities and be able to input real work. 
   * The user will then also appear in the “Resources” list.
 
.. rubric:: Section: Miscellanous

.. topic:: Password

   * Password to connect to the application.
   * Administrator can only reset password to default value.

.. topic:: Don't receive team mails

   * Flag to indicate that user don't want receive team mails.

.. topic:: Comes from Ldap
 
   * Flag to indicate that user come from Ldap.

.. topic:: API key 

   * Key string used with web service.

   * Button "Send information to the user"
 
     * Send the key string to the user.	

.. raw:: latex

    \newpage

.. index:: ! Team 

Team
----

Team is a group of resources gathered on any criteria.

A resource can belong to only one team.

The actual version of the tool does not use much of team notion.

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
     - Unique Id for the team.
   * - **Name**
     - Name of the team.
   * - :term:`Closed`
     - Flag to indicate that team is archived.
   * - Description
     - Complete description of the team.

.. rubric:: Section: Team members

List of the resources member of the team.

.. note::

   It is possible to directly affect every team member to a project, using the corresponding button.

.. raw:: latex

    \newpage

.. index:: ! Calendar 

.. _resource-calendar-label:

Calendar
--------

Planning dispatches work on every open days.

By default, open days are days from Monday to Friday, excluding week ends.

The Calendar screen sets possibility to defined off days (for instance New Year, National day). 

As these days are different from one country to the other, is must be entered manually. 

On the calendar screen, you can also define some specific ‘opened’ week-end days. 

The calendar information is taken into account when calculating planning. 

You must re-calculate an existing planning to take into account changes on the calendar.

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
     - Unique Id for the calendar.
   * - Name
     - Name of the calendar.
 
.. note::

   The default calender can't be deleted.

.. rubric:: Section: Year

.. topic:: Field : Year field

   * Select year of displayed calendar.

.. topic:: Button : Import this year from calendar 

   * Copy exceptions of the selected year of the selected calendar into current calendar.
   * Existing exceptions of current calendar are not changed.

.. rubric:: Section: Calendar days

A calendar of selected year (see above) is displayed to give a global overview of the exceptions existing :
 
* in blue exception off days, 

* in red exception open days, 

* in bold current day. 

Just click on one day in the calendar to switch between off and open day.

