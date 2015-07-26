.. raw:: latex

    \newpage

.. title:: Recipient

.. index:: ! Recipient 

Recipient
---------

The Recipient is the beneficiary of bill payments.

Recipients are mainly defined to store billing information. 

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
     - Unique Id for the recipient.
   * - **Name**
     - Short name of the recipient.
   * - Company number
     - Company number, to be displayed on bill.
   * - Tax number
     - Tax reference number, to be displayed on bill.
   * - Tax free
     - Flag to indicate that tax is automatically set to zero for this recipient.
   * - :term:`Closed`
     - Flag to indicate that recipient is archived.
 
**\* Required field**

.. rubric:: Section: International Bank Account Number (IBAN)

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Bank
     - Bank name.
   * - Country
     - Country code. IBAN format.
   * - Key
     - Key code. IBAN format.
   * - Account number
     - Full account number defining the BBAN account code.

.. topic:: Field: Key

   * Automatically calculated from other IBAN fields.

.. topic:: Field: Account number
 
   * Format depends on country.

.. rubric:: Section: Addreses

* Full address of the recipient.


