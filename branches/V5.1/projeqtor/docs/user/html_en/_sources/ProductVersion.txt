.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Product & Version
   :depth: 1
   :backlinks: top
   :local:


.. title:: Product & Version

.. index:: ! Product 

Product
-------

Product is the element de project is built for.

A project works on one or more versions of the product . 

A product is any element delivered by the project. For IT/IS Projects, products are generally Applications.

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
     - Unique Id for the product.
   * - **Real name**
     - Name of the resource. Can contain first and last name.
   * - User name
     - User name.
   * - Initials
     - Initials of the resource.
   * - Email address
     - Email address of the resource. 
   * - Profile
     - Profile of the user.
   * - Capacity (FTE)
     - Capacity of the resource, in Full Time Equivalent.
   * - Calendar
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
     - Flag to indicate that product is archived.
   * - Description
     - Complete description of the product.

**\* Required field**

.. rubric:: Section: Product versions

List of the versions defined for the product.


.. raw:: latex

    \newpage

.. index:: ! Version 

Version
-------

Version is the declination of the product life.

A project works on one or more versions of the product . 

A version of product is any stable status of the element delivered by the project.

For IT/IS Projects, versions are generally Applications Versions.

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
     - Unique Id for the version.
   * - **Product**
     - The product on which the version applies.
   * - **Name**
     - Name of the version.
   * - Prime contractor
     - The contact, into customer organization, who will be responsible for the version delivery.
   * - Responsible
     - Resource responsible of the version.
   * - Entry into service
     - Initial, planned and real entry into service date of the version. 
   * - End date
     - Initial, planned and real end dates of the version.  
   * - Description
     - Complete description of the version.

**\* Required field**

.. topic:: Field: Prime contractor
     
   * Can be different from Product prime contractor.

.. topic:: Field: Entry into service

   * Done is checked when real is set.

.. topic:: Field: End date

   * Done is checked when real is set, corresponding to :term:`closed` version.


.. rubric:: Section: Projects linked to this version

Projects can be directly linked to version.

Click |buttonAdd| on to create a new link to project. A “Project – Version link” pop up will be displayed. 

Click on |buttonEdit| to update an existing link to project.

Click on |buttonRemove| to delete the corresponding link to project.

.. topic:: Pop up “Project – Version link”

   Project  - Project linked to the version.

   Version - Current version.

   Start date - Start date for validity of the link.
 
   End date - End date for validity of the link.

   Closed - Flag to indicate that link is not active any more, without deleting it.

