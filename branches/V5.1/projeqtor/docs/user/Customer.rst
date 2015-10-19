.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents::
   :depth: 1
   :backlinks: top

.. title:: Customers & Contacts

.. index:: ! Customer 

.. _customer:

Customers
---------

The customer is the entity for which the project is set.

It is generally the owner of the project, and in many cases it is the payer.

It can be an internal entity, into the same enterprise, or a different enterprise, or the entity of an enterprise.

The customer defined here is not a person. Real persons into a customer entity are called “Contacts”. 

.. rubric:: Bill information

.. topic:: Field: Delay for payment

   * Delay in payment can be displayed on the customer bill.

.. topic:: Field: Tax

   * Tax rates that will be applied to bills amounts for this customer.  

.. sidebar:: Other sections
  
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   
   * :ref:`Change history<chg-history-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Customers description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the customer.
   * - **Customer name**
     - Short name of the customer.
   * - Type of customer
     - Type of customer.
   * - Customer code
     - Code of the customer.
   * - Delay for payment
     - Delay in payment (in days).
   * - End of month
     - Flag to indicate that delay for payment is set at the end of month.
   * - Tax
     - Tax rates that are applied to bill amounts for this customer.
   * - :term:`Closed`
     - Flag to indicate that the customer is archived.
   * - :term:`Description`
     - Complete description of the customer.

**\* Required field**

.. rubric:: Section: Addreses

* Full address of the customer.

.. rubric:: Section: Projects

* List of the projects of the customer.

.. rubric:: Section: Contacts

* List of the contacts known in the entity of the customer.


.. raw:: latex

    \newpage

.. index:: ! Contact (Screen)
.. index:: ! Customer (Contact) 

.. _contact:

Contacts
--------

.. sidebar:: Concepts 

   * :ref:`projeqtor-roles`
   * :ref:`profiles-definition`
   * :ref:`user-ress-contact-demystify`
   * :ref:`photo`

A contact is a person in a business relationship with the company.

The company keeps all information data to be able to contact him when needed.

A contact can be a person in the customer organization.

A contact can be the contact person for contracts, sales and billing.


.. sidebar:: Other sections

   * :ref:`Affectations<affectations-section>`
   * :ref:`Change history<chg-history-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Contacts description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the contact.
   * - Photo
     - Photo of the contact.
   * - **Real name**
     - Name of the contact.
   * - User name
     - Name of user.
   * - Initials
     - Initials of the contact.
   * - Email address
     - Email address of the contact. 
   * - Profile
     - Profile of the user.
   * - Customer
     - The customer the contact belongs to.
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


.. topic:: Field: Is a resource
   
   * Check this if the contact must also be a resource.
   * The contact will then also appear in the “Resources” list. 

.. topic:: Field: Is a user

   * Check this if the contact must connect to the application. 
   * You must then define the **User name** and **Profile** fields.
   * The contact will then also appear in the “Users” list. 


.. rubric:: Section: Addreses

Full address of the contact.


.. rubric:: Section: Miscellanous

.. tabularcolumns:: |l|l|

.. list-table:: Contacts miscellanous section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Don't receive team mails
     - Flag to indicate that resource don't want to receive team mails.


