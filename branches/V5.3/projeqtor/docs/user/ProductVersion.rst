.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. title:: Product & Component

.. _product-component-management:

Product & Component
-------------------

.. sidebar:: Concepts 

   * :ref:`product-concept`

The product and component management is done on screens:

* :ref:`product`
* :ref:`component`
* :ref:`product-version`
* :ref:`component-version`

.. raw:: latex

    \newpage

.. index:: ! Product

.. _product:

Products
^^^^^^^^

Allows to define product and sub-product.

Allows to link components to product.

.. sidebar:: Other sections
   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: 
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the product.
   * - **Name**
     - Name of the product.
   * - Designation
     - Trade name of the product known outside the company.
   * - Customer
     - The customer the product should be delivered to.
   * - Prime contractor
     - The contact, into customer organization, who will be responsible for the product delivery.
   * - Is sub-product of 
     - Name of the top product if this product is a sub-product. 
   * - :term:`Closed`
     - Flag to indicate that product is archived.
   * - Description
     - Complete description of the product.

**\* Required field**

.. rubric:: Section: Product versions

* List of versions defined for the product.
* Product versions are defined in :ref:`product-version` screen.

.. rubric:: Section: List of components for this product

* More detail on component list management, see: :ref:`product-structure-management`.

.. topic:: Button: Display structure

   * Displays the structure of the product.
   * Check the box "Show versions for all structure" to display versions of sub-products and components.
   * Check the box "Show projects linked to versions" to display projects linked.


.. raw:: latex

    \newpage

.. index:: ! Component

.. _component:

Components
^^^^^^^^^^

Allows to define product components.

Allows to define products using the component.

.. sidebar:: Other sections
   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: 
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the component.
   * - **Name**
     - Name of the component.
   * - Identifier
     - Another name to identify the component.
   * - :term:`Closed`
     - Flag to indicate that the component is archived.
   * - Description
     - Complete description of the component.

**\* Required field**

.. rubric:: Section: Component versions

* List of versions defined for the component.
* Component versions are defined in :ref:`component-version` screen.

.. rubric:: Section: List of products using this component

* More detail on product list management, see: :ref:`product-structure-management`.

.. raw:: latex

    \newpage

.. index:: ! Product (Version)

.. _product-version:

Product Versions
^^^^^^^^^^^^^^^^

Allows to define versions of a product.

Allows to link a component version to product version.

Allows to link the product version to a project.

.. sidebar:: Other sections


   * :ref:`Projects linked to this version<Link-version-project-section>`  
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

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
     
   * Can be different from product prime contractor.

.. topic:: Field: Entry into service (Real)

   * Specify the date of entry into service.
   * The box "Done" is checked when the real date field is set.

.. topic:: Field: End date (Real)

   * Specify the date end-of-service.
   * The box "Done" is checked when the real date field is set.

.. rubric:: Section: List of product versions using this component version

* More detail on management of version list of component, see:  :ref:`product-structure-management`.

.. raw:: latex

    \newpage

.. index:: ! Component (Version)

.. _component-version:

Component Versions
^^^^^^^^^^^^^^^^^^

Allows to define versions of a component.

Allows to link a product version to component version.

.. sidebar:: Other sections

   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the version.
   * - **Component**
     - The component on which the version applies.
   * - **Name**
     - Name of the version.
   * - Entry into service
     - Initial, planned and real entry into service date of the version. 
   * - End date
     - Initial, planned and real end dates of the version.  
   * - Description
     - Complete description of the version.

**\* Required field**

.. topic:: Field: Entry into service (Real)

   * Specify the date of entry into service.
   * The box "Done" is checked when the real date field is set.

.. topic:: Field: End date (Real)

   * Specify the date end-of-service.
   * The box "Done" is checked when the real date field is set.

.. rubric:: Section: List of product versions using this component version

* More detail on management of version list of product, see:  :ref:`product-structure-management`.

.. raw:: latex

    \newpage

.. _product-structure-management:

Links between products and components
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Allows to manage links between products and components.

Allows to manage links between product versions and component versions.

.. note::

   * A component can be linked with more one product.
   * The component must be linked to the product, before linking their versions.

.. rubric:: Link management

* Click on |buttonAdd| to create a new link. The dialog box "Product Structure" appear. 
* Click on |buttonIconDelete| to delete the corresponding link.

.. rubric:: Dialog box “Product Structure”

* The contents of the dialog box changes depending on kind of link.

.. raw:: latex

    \newpage

.. _Link-version-project-section:

Link version to projects
^^^^^^^^^^^^^^^^^^^^^^^^

This section allows to manage links between projects and versions of product or its components.

.. rubric:: Link version to projects management

* Click on |buttonAdd| to create a new link. 
* Click on |buttonEdit| to update an existing link.
* Click on |buttonIconDelete| to delete the corresponding link.


.. figure:: /images/GUI/BOX_ProjectVersionLink.png
   :alt: Project - Version link dialog box
   :align: center

   Project - Version link dialog box


.. list-table:: Fields of Project - Version link dialog box
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Project
     - The project linked to version or the project list.
   * - Product
     - Product or component linked to the project or the list of  product and component.
   * - Version
     - Version linked to the project or list of versions.
   * - Start date
     - Start date for validity of the link.
   * - End date
     - End date for validity of the link.
   * - Closed
     - Flag to indicate that link is not active any more, without deleting it.

.. topic:: Fields: Project, Product and Version
 
   * From the screen «Projects», the fields «product and version» will be selectable.
   * From the screen «Product versions», the field «project» will be selectable.




