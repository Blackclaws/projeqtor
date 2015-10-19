.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents::
   :depth: 4
   :backlinks: top

.. title:: Graphical User Interface

Global view
-----------

ProjeQtOr interface is divided into several areas.

Those areas are :

* :ref:`top-bar` |one|
* :ref:`logo-area` |two|
* :ref:`menu-document-window` |three|
* :ref:`message-link-window` |four|
* :ref:`list-window` |five|
* :ref:`detail-window` |six|
* :ref:`info-bar` |seven|

.. figure:: /images/GUI/SCR_GeneralwithArea.png
   :alt: General screen
   :align: center

   General screen

------------------

.. index:: ! GUI (Splitters)

.. rubric::  The splitters

* The splitters allow resizing areas in the interface.
* The green splitter allows to resize the areas "Menu and Documents window" & "Message and Link window".
* The red splitter allows to resize the areas  left and right.
* The orange splitter allows to resize the areas "List" and "Detail".

.. figure:: /images/GUI/SCR_WindowsSplitters.png
   :alt: Windows splitters
   :align: center

   Windows splitters


.. raw:: latex

    \newpage

.. index:: ! GUI (Top bar)

.. _top-bar:

Top bar
^^^^^^^

.. figure:: /images/GUI/SCR_TopBar.png
   :alt: Top bar
   :align: center

   Top bar

.. index:: menu buttonsInfo bar

.. rubric:: Menu buttons

.. figure:: /images/GUI/ZONE_MenuButtons.png
   :alt: Menu buttons zone
   :align: center

   Menu buttons zone

* The menu buttons |two| give rapid access to main elements.
* The arrows |three| allow to scroll buttons list.

 .. compound:: **Contextual menu buttons** |one|

    * Allows to select a work context to limit the displayed buttons.

-------------------

.. raw:: latex

    \newpage

.. index:: ! Project (Selector)
.. index:: ! GUI (Project selector)

.. rubric:: Project selector

.. figure:: /images/GUI/ZONE_ProjectSelector.png
   :alt: Project selector zone
   :align: center

   Project selector zone

* Allows restricting the visibility of all objects of the dedicated project, including sub-projects if any.
* The selection will also define the “default” project for new items.

 .. compound:: **Project selector parameters**

    * Click on |buttonIconParameter| to display the project selector parameters dialog box, you can select :

      * View closed projects.
      * Change the project selector format.
      * Refresh the list.

.. figure:: /images/GUI/BOX_ProjectSelectorParameters.png
   :alt: Project selector parameters dialog box
   :align: center

   Project selector parameters dialog box


--------------------

.. raw:: latex

   \newpage

.. index:: ! GUI (Navigation buttons)

.. rubric:: Navigation buttons

.. figure:: /images/GUI/ZONE_NavigationButtons.png
   :alt: Navigation buttons zone
   :align: center

   Navigation buttons zone

* The navigation buttons |buttonIconBackNavigation| |buttonIconForwardNavigation| give access to previous and next items in the history.

--------------------

.. index:: ! GUI (New tab)

.. rubric:: New tab button

* Allows to open a new tab within the same session.

.. figure:: /images/GUI/ZONE_NewTabButton.png
   :alt: New tab button zone
   :align: center

   New tab button zone

.. raw:: latex

   \newpage

.. _logo-area:

Logo area
^^^^^^^^^

.. figure:: /images/GUI/SCR_LogoArea.png
   :alt: Logo area
   :align: center

   Logo area

.. index:: ! GUI (Software information)

.. rubric:: Software information

* Clicking on the "Logo Area" will display the software information box.

.. figure:: /images/GUI/INFO_SoftwareInformation.png
   :alt: Software information box
   :align: center

   Software information box

-----------------------------

.. index:: ! GUI (Online user manual)

.. rubric:: Online user manual

* Click on the online manual icon |buttonIconHelp| will open the online user manual, to the page corresponding to the actual screen. 

  .. note:: 

     * You can change logo with your own.
     * Refer to administrative guide to replace the logo.


.. raw:: latex

    \newpage

.. _menu-document-window:

Menu and Documents windows
^^^^^^^^^^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/SCR_MenuAndDocumentsWindows.png
   :alt: Menu and Documents windows 
   :align: center

   Menu and Documents windows

.. note:: Toggle windows

   * You can toggle between the windows "Menu" and "Document".  
   * Just click on window header.




.. rubric:: Menu window

* The menu is proposed as a tree view of reachable items. 
* The items presented will depend on  access rights of user to the screens.
* Click on a grouping line will expand-shrink the group.
* Click on an item will display the corresponding screen in the main area (right side of the screen).

.. figure:: /images/GUI/ZONE_MenuWindow.png
   :alt: Menu window
   :align: center
   
   Menu window
  

.. note:: Icon size in menu

   * Icon size in the menu can be defined in :ref:`User parameters<display-parameters>` screen.

---------------------

.. rubric:: Documents window

* Document directories give direct access to documents contained in the directory.

.. figure:: /images/GUI/ZONE_DocumentsWindow.png
   :alt: Documents window
   :align: center

   Documents window


.. topic:: Document directories

   This icon |buttonIconDocDir| gives direct access to the :ref:`document-directory` screen.

.. raw:: latex

    \newpage

.. _message-link-window:

Message and Link windows
^^^^^^^^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/SCR_MessageAndLinkWindows.png
   :alt: Message and Link window
   :align: center

   Message and Link windows

.. note:: Toggle windows

   * You can toggle between the windows "External shortcuts" and "Console messages".  
   * Just click on window header.

.. rubric:: External shortcuts window

* Displays hyperlinks to remote web pages.
* These links are defined as hyperlink attachments on projects.
* Links displayed here depend on the selected project.


.. figure:: /images/GUI/ZONE_ExternalShortcuts.png
   :alt: External shortcuts
   :align: center

   External shortcuts

----------------------------

.. rubric:: Console messages window

* Displays information about main actions: insert, update, delete. 
* The timestamp indicates when the action was done.

.. figure:: /images/GUI/ZONE_ConsoleMessages.png
   :alt: Console messages
   :align: center

   Console messages

.. note::

   * Messages displayed here are not stored and will be flushed when user logout.

.. raw:: latex

    \newpage


.. _list-window:

List window
^^^^^^^^^^^

.. figure:: /images/GUI/SCR_ListWindow.png
   :alt: List window
   :align: center

   List window


.. figure:: /images/GUI/ZONE_ListWindowPart.png
   :alt: List window zone
   :align: center

   List window zone

|

 .. compound:: **Element identified** |one|

    * Identifies the element and the number of listed items is displayed.
    * Each element are associated to a distinctive icon.

 .. compound:: **Rapid filter** |two|

    * Rapid filtering fields are proposed : “id”, “name” and “type”.
    * Any change on “id” and “name” will instantly filter data.
  
      * Search is considered as “contains”, so typing “1” in “id” will select “1”, “10”, “11”, “21”, “31” and so on.
  
    * Selecting a “type” in the combo box will restrict the list to the corresponding type.


 .. compound:: **Buttons** |three|

    * Click on the “search button” |buttonIconSearch| to display the textual search area.
    * Click on the “advanced filter” |buttonIconFilter| to set advanced filter (see : :ref:`gui-advanced-filter-label`).
    * Click on the “select columns to display” |buttonIconColumn| to set columns order (see : :ref:`gui-diplayed-columns-label`).
    * Click on the “print the list” |buttonIconPrint| to get a printable version of the list.
    * Click on the “export to PDF format” |buttonIconPdf| to export it to PDF format.
    * Click on the “export to CSV format” |buttonIconCsv| to export all the data of the selected items into CSV format file (see : :ref:`gui-ExportCSV-format-label`).
    * Click on the “create a new **item**” |buttonIconNew| to create a new item of element.

 .. compound:: **Show closed items flag** |four|

    * Check the “show closed items” to list also closed items.

 .. compound:: **Columns header** |five|

    * Click on the header of a column will sort the list on that column (first ascending, then descending).

    .. note ::

       * The sorting is not always on the displayed name.
       * if the sorted column is linked to a reference list with sort order value, the sorting is executed on this sort value
    
         * for instance, here the sorting on the status is executed corresponding to Status sort order value, defined as a logic workflow for status change.

 .. compound:: **Items list** |six|

    * Click on a line (any column) will display the corresponding item in the detail window.

.. raw:: latex

    \newpage

.. _gui-advanced-filter-label:

Advanced filter
"""""""""""""""

.. figure:: /images/GUI/BOX_AdvancedFilterDefinition.png
   :alt: Advanced filter definition dialog box
   :align: center

   Advanced filter definition dialog box

The filter pop-up presents two areas : “Active filter” and “Saved filter”.


.. rubric:: Active filter

* Enter new clause in Active filter : in “Add a filter or sort clause”, select the name of the field, the operator and the value for the clause.

  * Then click on |buttonAdd| to add the clause to the filter criteria.

* Click on |buttonRemove| on a clause line to remove it.

* Click on |buttonRemove| on the header of Filter criteria to remove all clauses.

  *  This can also be done by clicking the “Clear” button.

* When Filter criteria is correct, click on “OK” button to apply the filter to the list.

* You can also click “Cancel” button to revert to previous filter.

* At any step you can enter a filter name and click on |IconSave| to save the filter definition.

.. topic:: Operators detail

   * **Sort** operator define a sort criteria, then possible values are “ascending” or “descending”.

   * **Amongst** operator allows multi-value selection is possible using :kbd:`Control` key.

.. note::

   * Filters are defined and stored for a user and a type of item (a screen).
 
   * When a filter is applied to a type of item, coming back after moving to another type (another selection in the menu) will apply the previously defined filter.

   * After disconnection, currently applied filter is lost, but stored filters are saved.

     * Default filter (if selected) is also stored and will be automatically applied on next connection.

.. rubric:: Saved filter

* Click on a Saved filter to retrieve its definition (filter criteria).

* Click on |buttonRemove| on a saved filter to delete it.

* Click on “Default” button to set actual stored filter as default, kept even after disconnection.

.. note ::

   * When filter is applied, filter button in the list area is checked |buttonIconActiveFilter|.



.. raw:: latex

    \newpage

.. _gui-diplayed-columns-label:

Displayed columns
"""""""""""""""""

* This button opens the list of all available fields.
* Just check the fields you want to display in the list.
* You can reorder fields with drag & drop feature, using the selector area |buttonIconDrag|.
* When a field is selected, you can change its width with the spinner button.

.. topic:: Width

   * Width is in % of total list width.
   * Minimum width is 1%. Maximum width is 50%.
   * So, if you select to many columns or set columns width too large, you may have total width over 100%.

     * This will be highlighted beside buttons.

   * This may lead to strange display, over page width, on List, reports or pdf export, depending on browser.
   * It is possible to reset the list display to its default format using the "reset" button.  

.. note:: id and name

   * “id” and “name” are mandatory fileds : they cannot be removed from display.
   * The “name” width is automatically adjusted so that total list width is 100%.
   * Take care that “name” width cannot be less than 10%.


.. figure:: /images/GUI/BOX_SelectColunmsToDisplay.png
   :alt: Select columns to display diaglog box
   :align: center

   Select columns to display diaglog box

.. raw:: latex

    \newpage

.. _gui-ExportCSV-format-label:

Export to CSV format
""""""""""""""""""""

The Export pop-up allows to choose fields to export.

The fields are presented in the order as they appear in the item description.

.. topic:: Selecting fields

   * You can easily check or uncheck all fields to export.

   * You can also easily restrict selected fields to the ones that are actually displayed in the list.

.. topic:: id or name for references

   * For fields that reference another item (displayed as lists in the item description), you can select to export either the id or the clear name of the referenced item. 


.. figure:: /images/GUI/BOX_Export.png
   :alt: Export dialog box
   :align: center

   Export dialog box

.. note ::

   * CSV exported files can directly be imported through the Import functionality.



.. raw:: latex

    \newpage

.. _detail-window:

Detail window
^^^^^^^^^^^^^

.. figure:: /images/GUI/SCR_DetailWindow.png
   :alt: Detail window
   :align: center

   Detail window


.. figure:: /images/GUI/ZONE_DetailWindowPart.png
   :alt: GUI detail window Part
   :align: center

|

 .. compound:: **Element identified** |one|

    * Identifies the element and the item id number.
    * Each element are associated to a distinctive icon.

 .. compound:: **Creation information** |two|

    * Information about item creation : issuer and date.

    .. note::

       * Administrator can change information.

 .. compound:: **Buttons** |three|

    * Click on |buttonIconNew| to create new item.        
    * Click on |buttonIconSave| to save the changes. 
 
      * You can rapidly save with :kbd:`Control-s`.      

    * Click on |buttonIconPrint| to get a printable version of the detail.
    * Click on |buttonIconPdf|  to get a printable version of the detail in PDF format.
    * Click on |buttonIconCopy| to copy the current item (see : :ref:`copy-item`).        
    * Click on |buttonIconUndo| to cancel ongoing changes.      
    * Click on |buttonIconDelete| to delete the item.      
    * Click on |buttonIconRefresh| to refresh the display.      
    * Click on |buttonIconEmail| to send detail of item by email (see : :ref:`email-detail`).
    * Click on |buttonIconMultipleUpdate| to update several items in one operation (see : :ref:`multiple-update`).
    * Click on |buttonIconShowChecklist| to show checklist.

      * Available only when user set user parameter "display checklists" to "On request".
      * For detail of checklist information, see :ref:`checklist-section`.

    * Click on |buttonIconShowHistory| to show history of changes.

      * Available only when user set user parameter "display history" to "On request".
      * For detail of history of changes information, see :ref:`Change history<chg-history-section>`.

    .. note::

       * Some buttons are not clickable when change are ongoing.
       * |buttonIconUndo| button is clickable only when changes are ongoing.

    .. warning::

       * When changes are ongoing, you can not select another item or another menu item. 
       * Save or cancel ongoing changes first.

 .. compound:: **Drop file area** |four|

    * This area allows to add a attachement file in item.

      * You can drag and drop file
      * Or click on area to select file.

 .. compound:: **Sections** |five|

    * The fields are regrouped under section.
    * All sections can be folded or unfolded, clicking on the section title. 
    * The sections are organized in columns.

      * Maximum three columns can be displayed.

    * Some sections are displayed on almost all screens, see : :ref:`gui-sections-label`  

.. raw:: latex

    \newpage

.. _copy-item:

Copy item
"""""""""

* Allows copied item of element.
* Options displayed in pop-up depends on whether an item is simple or complex.

.. figure:: /images/GUI/BOX_CopyElement.png
   :alt: Copy element dialog box
   :align: center

   Copy element dialog box

|

 .. compound:: **Simple items**

    * Simple items (environment parameters, lists, …) can only be copied “as is”.

 .. compound:: **Complex items**

    * Complex items (Tickets, Activities, …) it is possible to copy them into new kind of elements.

    * For instance, it is possible to copy a Ticket (the request) into an Activity (the task to manage the request). 

    * It is possible to select :

      * New kind of element.
      * Select new type (corresponding to the kind of element).
      * Change the name.
      * Select whether the initial element will be indicated as origin of the copied one.
      * For main items, it is also possible to choose to copy links, attachments and notes. 

     .. note:: 

        * For Projects and Activities, it is also possible to copy the hierarchic structure of activities (sub-projects, sub-activities). 

        * The new item are the status "copied".
  
.. _email-detail:

Email detail
""""""""""""

It is possible to send an informative email to defined recipients list.

.. figure:: /images/GUI/BOX_EmailDetail.png
   :alt: Email detail dialog box
   :align: center

   Email detail dialog box


**message**

* The message that will be included in the body of the email, in addition to complete description of item.



.. raw:: latex

    \newpage

.. _multiple-update:

Multiple update
"""""""""""""""

To update several items in one operation.

This will switch to new detail view :

.. figure:: /images/GUI/ZONE_MultipleMode.png
   :alt: Multiple mode window
   :align: center

   Multiple mode window

At this step, although the list does not seem to have changed, but it is now multi-selectable :

.. figure:: /images/GUI/ZONE_MultipleModeList.png
   :alt: Multiple mode item selection
   :align: center

   Multiple mode item selection

Select lines of items you want to update, specify update and save : the update will be applied to all the items (if possible) and a report will be displayed on the right of the Multiple mode detail screen.

.. figure:: /images/GUI/ZONE_MultipleModeReport.png
   :alt: Multiple mode report
   :align: center

   Multiple mode report

.. raw:: latex

    \newpage

.. _gui-combo-list-fields-label:

Combo list fields
"""""""""""""""""

Combo list field allows to search, view or create item associate with the field.

.. figure:: /images/GUI/ZONE_ComboListFields.png
   :alt: Combo list fields
   :align: center

   Combo list fields


* Click on |comboArrowDown| to get the list of value.
* Click on |buttonIconSearch| to access item details.

  * The action depends on whether the element is selected or not.

* Click on |iconGoto| will directly go to the selected item. 

.. note::

   * Access to view or create item depends on your access rights.

   * Some buttons become not available.

.. rubric:: Element is selected

If element is selected in the combo, detail of element is displayed.

.. figure:: /images/GUI/BOX_DetailOfListElement.png
   :alt: Detail of list element dialog box
   :align: center

   Detail of list element dialog box

* Click on |buttonIconSearch| to search an item.
* Click on |buttonIconUndo| to close the window.

.. raw:: latex

    \newpage

.. rubric:: No element is selected

If no element is selected, list of elements is displayed, allowing to select an item.

.. figure:: /images/GUI/BOX_DetailOfListElementList.png
   :alt: Detail of list element (list) dialog box
   :align: center

   Detail of list element (list) dialog box 

* Click on |buttonIconSelect| to select item.
* Click on |buttonIconNew| to create a new item.
* Click on |buttonIconUndo| to close the window.

.. note:: Header window

   * You have access to rapid filter, search button and advanced filter.
   * For detail, see : :ref:`list-window`. 

.. note:: Select several items

    * Some elements is possible to select several items, use :kbd:`Control` or :kbd:`Shift`.
   
.. rubric:: Go to selected item

* Click on |iconGoto| will directly go to the selected item.

.. note :: Return to last screen

   * Click on |buttonIconBackNavigation| to return on last screen.

   * For detail, see **Navigation buttons** in :ref:`top-bar` section. 

.. raw:: latex

    \newpage

Long text field
"""""""""""""""

.. figure:: /images/GUI/ZONE_LongTextFields.png
   :alt: Long text field
   :align: center

   Long text field

* Long text fields allow to write description, results, notes, ...

* A mini editor is provided.

* Text zone is expendable.

.. note :: Editor mode always on

   * This parameter defines editor is always on in long text fields.

   * See this parameter under "Graphic interface behavior" section in :ref:`User parameters<graphic-interface-behavior-section>` screen. 

.. raw:: latex

    \newpage

.. _gui-origin-field-label:

Origin field
""""""""""""
This field allows to determine the element of origin.

The origin is used to keep track of events (ex.: order from quote, action from meeting).

The origin may be selected manually or automatically inserted on copy. 


.. figure:: /images/GUI/ZONE_OriginField.png
   :alt: Origin field
   :align: center

   Origin field

.. rubric:: Origin element

* Click on |buttonAdd| to add a orgin element. A “Add an orgin element” pop up will be displayed. 

* Click on |buttonRemove| to delete the link.

.. figure:: /images/GUI/BOX_AddAnOriginElement.png
   :alt: Add an origin element diaglog box
   :align: center

   Add an origin element diaglog box

.. tabularcolumns:: |l|l|

.. list-table:: Add an origin element Popup fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Type of the orign
     - Type of element to be selected.
   * - Origin element
     - item to select.


.. raw:: latex

    \newpage



Accelerator buttons
"""""""""""""""""""

.. _moveToNextStatus-button:

.. rubric:: Move to next status button

* This button allows to skip to the next status without having to open the list.
* The next status is defined by the workflow linked to the type of element. 

.. figure:: /images/GUI/BUTTON_MoveToNextStatus.png
   :alt: Move to next status button
   :align: center

   Move to next status button

.. _assignToMe-button:

.. rubric:: Assign to me button

* This button allows to set current user in the related field.

.. figure:: /images/GUI/BUTTON_AssignToMe.png
   :alt: Assign to me button
   :align: center

   Assign to me button


.. raw:: latex

    \newpage

.. _info-bar:

Info bar
--------

.. figure:: /images/GUI/SCR_Infobar.png
   :alt: Info bar
   :align: center

   Info bar

.. figure:: /images/GUI/ZONE_Infobar.png
   :alt: Info bar Zone
   :align: center

   Info bar Zone

|

 .. compound:: **Log out button** |one|

    * Allow to disconnect user.

    .. note :: confirm quit application

       * This parameter defines whether a confirm disconnection will be displayed before.
       * See this parameter under "Graphic interface behavior" section in :ref:`User parameters<graphic-interface-behavior-section>` screen. 


 .. compound:: **User parameters button** |two|

    * Allow to access user parameters.

 .. compound:: **Hide and show menu button** |three|

    * Allow to hide or show menu button

    .. note :: hide menu

       * This parameter defines whether the menu is hidden by default.
       * See this parameter under "Graphic interface behavior" section in :ref:`User parameters<graphic-interface-behavior-section>` screen. 
 

 .. compound:: **Switched mode button** |four|

    * Allow to enable or disable switched mode between list and detail windows.
    * Window selected is displayed in "full screen" mode.
    * Hidden window are replaced by a gray bar.
    * Click on he gray bar to switch between windows. 

    .. note :: switched mode

       * This parameter defines wheater switched mode is enable or not.
       * See this parameter under "Graphic interface behavior" section in :ref:`User parameters<graphic-interface-behavior-section>` screen.  

 .. compound:: **Database name** |five|

    * Display database name.

 .. compound:: **Version button** |six|

    * Display application version.
    * Click on button access to ProjeQtOr site.


.. raw:: latex

    \newpage

.. _gui-sections-label:

Common sections
---------------

Some sections are displayed on almost all screens.

Those sections allows to set information or link information to item of the element.

Description section
^^^^^^^^^^^^^^^^^^^

This section allows to put information about item of the element.

Treatment section
"""""""""""""""""

This section allows to put information treatment done on the item of the element.

Mostly information under this section are :

* Status and Dates
* :term:`Responsible`
* Result, Comment
* And so on


.. index:: ! Checklist (Section)

.. _checklist-section:

Checklist section
"""""""""""""""""

If a checklist is defined for the current element a checklist section will appear.

The user just has to check information corresponding to the situation.

When done, the user name and checked date are recorded and displayed.

Each line can get an extra comment, as well a globally on the checklist.

.. note::

   * Checklists are defined in :ref:`checklist-definition` screen. 

.. note:: display checklists

   * This parameter defines whether the checklist section is hidden or not.  
   * If the value "On request" is set |buttonIconShowChecklist| button appear on detail header window.
   * See this parameter under "Graphic interface behavior" section in :ref:`User parameters<graphic-interface-behavior-section>` screen.   


.. raw:: latex

    \newpage

.. index:: Project (Affectation)

.. _affectations-section:


Affectations section
""""""""""""""""""""


.. sidebar:: Concepts 

   * :ref:`profiles-definition`
   * :ref:`project-affectation`

This section allows to manage project affectation.



.. list-table:: Affectations section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the affectation.
   * - **Project**
     - Project affected to.
   * - **Resource**
     - Name of the affected resource.
   * - Profile
     - Selected profile.
   * - Start date
     - Start date of affectation.
   * - End date
     - End date of affectation.
   * - Rate
     - Affectation rate for the projet (%).

.. topic:: Fields Project & Resource

   * If the project affectation management is done in the :ref:`project` screen, then the **resource** field will be displayed.
   * If the project affectation management is done in the :ref:`resource`, :ref:`contact` or :ref:`user` screen, then the **project** field will be displayed.


.. raw:: latex

    \newpage

.. rubric:: Affectation list management

* Click on |buttonAdd| to create a new affectation. 
* Click on |buttonEdit| to update an existing affectation.
* Click on |buttonRemove| to delete the corresponding affectation.

.. _affectations-box:

.. figure:: /images/GUI/BOX_Affectation.png
   :alt: Affectation dialog box
   :align: center

   Affectation dialog box


.. tabularcolumns:: |l|l|

.. list-table:: Affectation dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Project**
     - Project list.
   * - **Resource**
     - Resource list.
   * - **Profile**
     - Profile list.
   * - Rate
     - Rate (in %) of the affectation to the project.
   * - Start date
     - Start date of affectation.
   * - End date
     - End date of affectation.
   * - Closed
     - Flag to indicate that affectation in not active anymore, without deleting it.

**\* Required field**

.. topic:: Field: Resource

   * This field can contain a list of users, resources or contacts according to which screen comes from project affectation.

.. topic:: Field: Profile

   * The user profile defined will be displayed first. 
   * If the profile field is not available, then profile defined for each resource will be selected.  

.. topic:: Field: Rate

   * 100% means a full time affectation.

.. note::
 
   * Depending on which screen is used to manage projects affectation field behavior will change. 
 



.. raw:: latex

    \newpage

.. _linkElement-section:

Linked element section
""""""""""""""""""""""

Most items can be linked to most of all other items (Actions, Activities, Tickets, Documents, …).

.. note:: 

   Linked elements must belong to the same project.

Click |buttonAdd| on the corresponding section to add a link to an element. A “add link” pop up will be displayed. 

Select the linked element in the list and validate (OK).

Click on |buttonRemove| to delete the corresponding link.

.. figure:: /images/GUI/BOX_AddLink.png
   :alt: Add a link with element dialog box
   :align: center

   Add a link with element dialog box


.. rubric:: Linked elements information

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Element
     - Type and id of the linked element.
   * - Name
     - Name of the linked element.
   * - Date
     - Date of creation of the link.
   * - User
     - User who created the link.
   * - Status
     - Actual status of the linked element.
  

.. topic:: Reciprocally interrelated

   * If Item A is linked to Item B, Item B is automatically linked to Item A.

.. topic:: Go to
 
   * Click on the name of a item in the link list will directly move to it.

.. topic:: Link with Document

   * If you select a Document to link, you’ll have the possibility to select a version of the document, so that it is the version that will be linked.
   * For Documents and Document Versions, a direct link to the corresponding file is proposed.
   * For document, the last version of document will be proposed, the proposed download will change with document lifecycle.


.. raw:: latex

    \newpage


  .. index:: ! attachment - section

.. _attachment-section:

Attachments section
"""""""""""""""""""

Users can attach files or hyperlinks on most of items.

.. tabularcolumns:: |l|l|

.. list-table:: Attachments section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the attachment.
   * - File
     - File name or hyperlink.
   * - Date
     - Date of creation of the attachment.
   * - User
     - User who created the attachment.


.. rubric:: Add an attachment

* Click on |buttonAdd| to add an attachment file to an element. Dialog box "Attachment file" will be displayed. 
* Click on |iconLink| to add hyperlink to an element. Dialog box "Attachment hyperlink" will be displayed. 

.. rubric:: Select an attachment

Select an attachment depends on whether is a file or a hyperlink.

* Click on |iconDownload| to download attachment file.
* Click on |iconLink| to access to hyperlink.

.. rubric:: Delete an attachment

* Click on |buttonRemove| to delete an attachment.

.. _attachment-file:

.. rubric:: Attachment file


.. topic:: To upload a file
 
   * Select file with "Browse" button or drop the file in "drop files here" area.

.. figure:: /images/GUI/BOX_attachmentFile.png
   :alt: Attachment file dialog box
   :align: center

   Attachment file dialog box

.. note::

   * Attached files are stored on server side.
   * Attachments directory is defined in :ref:`Global parameters <file-directory-section>` screen. 
   


.. rubric:: Hyperlink

.. topic:: Hyperlink

   * Set hyperlink in Hyperlink field.

.. figure:: /images/GUI/BOX_attachmentHyperLink.png
   :alt: Attachment hyperlink dialog box
   :align: center

   Attachment hyperlink dialog box


.. tabularcolumns:: |l|l|

.. list-table:: Attachment dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Description
     - Description of attachment.
   * - Public
     - Attachment is visible to anyone.
   * - Team
     - Attachment is visible to every member of the creator’s team.
   * - Private
     - Attachment is visible only to creator.



.. index:: ! Note (section)

.. _note-section:

Notes section
"""""""""""""

Users can add notes on most items.

Notes are comments, that can be shared to track some information or progress.

Click on |buttonAdd| to add a note to an element. A “note” pop up will be displayed. 

Click on |buttonEdit| to edit the note.

Click on |buttonRemove| to delete the note.

.. figure:: /images/GUI/BOX_Note.png
   :alt: Note dialog box
   :align: center

   Note dialog box

.. rubric:: Predefined note

* Predefined note list of value appear whetear a prefedefined note is created.

* Selecting an item in the list will automatically fill in the note text field.

* Predefined notes are defined in :ref:`predefined-notes` screen.

.. rubric:: Attachment visibilty

* public : Visible to anyone.
* team : Visible to every member of the creator’s team.
* private :  Visible only to creator.

.. rubric:: Note information

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the note.
   * - Note 
     - Text of the note.
   * - Date
     - Date of creation or modification of the note.
   * - User
     - Name of the user who created the note.


.. index:: ! history - section

.. _chg-history-section:

Change history section
""""""""""""""""""""""

All the changes items are tracked.

They are stored and displayed on each item.

On creation, just an insert operation is stored, not all the initial values on creation.

.. rubric:: Change history information

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Operation
     - The operation on the item (insert or update).
   * - Data
     - The field modified.
   * - Value before
     - The value of the field before the update.
   * - Value after
     - The value of the field after the update.
   * - Date
     - Date of change operation.
   * - User
     - Name of the user who operated the change.


.. note:: display history

   * This parameter defines whether the display history section is hidden or not.  
   * If the value "On request" is set |buttonIconShowHistory| button appear on the detail header window.
   * See this parameter under "Graphic interface behavior" section in :ref:`User parameters<graphic-interface-behavior-section>` screen.      

.. raw:: latex

    \newpage

Alerts
------

You may receive some information displayed as pop-up on the bottom right corner of the screen.

Three kinds of information may be displayed :

* Information
* Warning
* Alert

Two possible actions :

* You can select to remind you in a given number of minutes (message will close and appear  again in the given number of minutes).
* You can mark it as read to definitively hide it.   

An alert can be sent by the administrator or indicator calculation.

.. note:: Administrator

   * Administrator can send alert by administration console.

.. note:: Indicator calculation

   * Indicator calculation send only warning and alert message.

   * Alert coming from indicator calculation message contains more information :

     * Item id and type.
  
     * Indicator description.
 
     * Target value.

     * Alert or warning value.

.. raw:: latex

    \newpage

Themes
------

Users can select colors Theme to display the interface. 

New theme is automatically applied when selected.

.. note :: theme

   * This parameter defines the theme to display.
   * Save parameters to retrieve this theme on each new connection.
   * See this parameter under "Display parameters" section in :ref:`User parameters<display-parameters>` screen.  


.. raw:: latex

    \newpage

Multilingual
------------

ProjeQtOr is multilingual.

Each user can choose the language to display all the captions.

.. note::

   Of course, data is displayed as input, no translation is operated.

.. note :: language

   * This parameter defines language is used to display captions.
   * Save parameters to retrieve this theme on each new connection.
   * See this parameter under "Display parameters" section in :ref:`User parameters<display-parameters>` screen. 


