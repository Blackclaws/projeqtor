.. raw:: latex

    \newpage

.. title:: Customer

.. index:: ! Customer 

Customer
--------

The Customer is the entity for which the Project is set.

It is generally the owner of the project, and in many cases it is the payer.

It can be an internal entity, into the same enterprise, or a different enterprise, or the entity of an enterprise.

The customer defined here is not a person. Real persons into customer entity are called “Contacts”. 

.. sidebar:: Other sections
  
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
     - Unique Id for the customer.
   * - **Customer name**
     - Short name of the customer.
   * - Type of customer
     - Type of customer.
   * - Customer code
     - Code of the customer.
   * - Delay for payment
     - Delay for payment (in days) that can be displayed in the bill.
   * - Tax
     - Tax rates that are applied to bill amounts for this customer.
   * - :term:`Closed`
     - Flag to indicate that customer is archived.
   * - Description
     - Complete description of the customer.

**\* Required field**

.. rubric:: Section: Addreses

* Full address of the customer.

.. rubric:: Section: Projects

* List of the projects of the customer.

.. rubric:: Section: Contacts

* List of the contacts known in the entity of the customer.

