.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. contents:: Graphic user interface
   :depth: 4
   :backlinks: top
   :local:

.. title:: Graphical User Interface



ProjeQtor graphical user interface is set into several areas.

Those areas are :

* Top bar
* Logo area
* Menu and Document windows
* Message and Link windows
* List window
* Detail window
* Info bar

.. figure:: /images/GUI/GUIwithArea.png
   :scale: 60 %
   :alt: GUI with areas
   :align: center

   GUI with areas

.. rubric::  Splitters

* Splitters allow resizing areas in graphic user interface.

* Green splitter allows resizing Menu and Documents windows & Message and Link windows areas.

* Red splitter allows resizing left and right side areas.

* Orange splitter allows resizing list and detail windows areas.

.. figure:: /images/GUI/windowsSplitters.png
   :scale: 60 %
   :alt: Windows splitters
   :align: center

   Splitters


.. raw:: latex

    \newpage

.. index:: ! Top bar

.. _gui-top-bar-label:

Top bar
-------

.. figure:: /images/GUI/topBar.png
   :scale: 60 %
   :alt: Top bar
   :align: center

   Top bar

.. index:: menu buttons

.. rubric:: Menu buttons

.. figure:: /images/GUI/menuButtons.png
   :scale: 80 %
   :alt: Menu buttons
   :align: center

* Menu buttons gives rapid access to main elements.

* Arrows allow to display buttons list.

.. topic:: Contextual menu buttons

   * Allows to select a work context to limit the visibility on displayed buttons.

.. raw:: latex

    \newpage

.. index:: project selector

.. rubric:: Project selector

.. figure:: /images/GUI/projectSelector.png
   :scale: 60 %
   :alt: Project selector
   :align: center

* Allows to restrict the visibility of all objects to the dedicated project, including sub-projects if any.

* The selection will also define de "default" project for new items.

.. topic:: Project selector parameters

   Through the project selector parameter icon |buttonIconParameter|, you can select :

   * View closed projects.

   * Change the project selector format.
  
   * Refresh the list.

.. figure:: /images/GUI/projectSelectorParameters.png
   :scale: 60 %
   :alt: Project selector parameters
   :align: center

.. raw:: latex

   \newpage

.. index:: navigation buttons

.. rubric:: Navigation buttons

.. figure:: /images/GUI/navigationButtons.png
   :scale: 60 %
   :alt: Navigation buttons
   :align: center

* The navigation buttons |buttonIconBackNavigation| |buttonIconForwardNavigation| give access to previous and next items in the history.


.. rubric:: New tab button

* Allows to open a new tab with the same session.

.. figure:: /images/GUI/newTabButton.png
   :scale: 60 %
   :alt: New tab button
   :align: center

.. raw:: latex

   \newpage

Logo area
---------

.. figure:: /images/GUI/logoArea.png
   :scale: 60 %
   :alt: GUI logo area
   :align: center

   Logo area

.. rubric:: Software information

* Clicking on the Logo Area will display the “About” pop-up.

.. figure:: /images/GUI/softwareInformation.png
   :scale: 60 %
   :alt: Software information
   :align: center

.. rubric:: Online user manual

* Click on the Help icon |buttonIconHelp| will open the online user manual, to the page corresponding to the actual screen. 

.. note:: 

   * You can change logo with your own.
   * Refer to administrative guide to replace the logo.


.. raw:: latex

    \newpage

Menu and Documents windows
--------------------------

.. figure:: /images/GUI/menuAndDocumentsWindows.png
   :scale: 60 %
   :alt: Menu and Documents windows
   :align: center

   Menu and Documents windows

.. note:: Toggle windows

   * You can toggle between Menu and Documents windows.
  
   * Just click on window header.

.. rubric:: Menu window

Menu is proposed as a tree view of reachable items.

The presented items will depend on user habilitation to the screens.

Click on a grouping line will expand-shrink the group. 

Click on a item will display the corresponding screen in the main area (right side of the screen).

.. figure:: /images/GUI/menuWindow.png
   :scale: 60 %
   :alt: Menu window
   :align: center

.. note:: icon size in menu

   * This parameter defines the size of icons in menu.
   * See this parameter under "Display parameters" section in :ref:`user-parameters-label`. 

.. rubric:: Documents window

* Document directories give direct access to documents contained in the directory.

.. figure:: /images/GUI/documentsWindow.png
   :scale: 60 %
   :alt: Documents window
   :align: center


.. topic:: Document directories

   This icon |buttonIconDocDir| gives direct access to the directories management screen.

.. raw:: latex

    \newpage

Message and Link windows
------------------------

.. figure:: /images/GUI/messageAndLinkWindows.png
   :scale: 60 %
   :alt: Message and Link area
   :align: center

   Message and Link windows

.. note:: Toggle windows

   * You can toggle between External shortcuts and Console messages windows.
  
   * Just click on window header.

.. rubric:: External shortcuts window

* Displays hyperlinks to remote web pages.
* Theses links are defined as hyperlink attachements on projects.
* Links displayed here depend on selected project.


.. figure:: /images/GUI/externalShortcuts.png
   :scale: 60 %
   :alt: External shortcuts window
   :align: center


.. rubric:: Console messages window

* Displays information about main actions : insert, update, delete. 
* Timestamp indicates when action was done.

.. figure:: /images/GUI/consoleMessages.png
   :scale: 60 %
   :alt: Console messages window
   :align: center

.. note::

   * This is only a temporary logging area.

   * Messages displayed here are not stored and will not live more than user connection.

.. raw:: latex

    \newpage

Main area
---------

The main area (right side of the screen) is generally divided in two parts : List window and Detail window.


.. _gui-list-window-label:

List window
-----------

.. figure:: /images/GUI/listWindow.png
   :scale: 60 %
   :alt: GUI list window
   :align: center

   List window


.. figure:: /images/GUI/listWindowPart.png
   :scale: 60 %
   :alt: GUI list window Part
   :align: center

.. rubric:: Element identified

* Identifies the element and the number of listed items is displayed.
* Each element are associated to a distinctive icon.

.. rubric:: Rapid filter

* Rapid filtering fields are proposed : “id”, “name” and “type”.
  
* Any change on “id” and “name” will instantly filter data.
  
  * Search is considered as “contains”, so typing “1” in “id” will select “1”, “10”, “11”, “21”, “31” and so on.
  
* Selecting a “type” in the combo box will restrict the list to the corresponding type.

.. raw:: latex

    \newpage 

.. rubric:: Buttons

* Click on the “search button” |buttonIconSearch| to display the textual search area.
* Click on the “advanced filter” |buttonIconFilter| to set advanced filter (see : :ref:`gui-advanced-filter-label`).
* Click on the “select columns to display” |buttonIconColumn| to set columns order (see : :ref:`gui-diplayed-columns-label`).
* Click on the “print the list” |buttonIconPrint| to get a printable version of the list.
* Click on the “export to PDF format” |buttonIconPdf| to export it to PDF format.
* Click on the “export to CSV format” |buttonIconCsv| to export all the data of the selected items into CSV format file (see : :ref:`gui-ExportCSV-format-label`).
* Click on the “create a new **item**” |buttonIconNew| to create a new item of element.

.. rubric:: Show closed items flag

* Check the “show closed items” to list also closed items.

.. rubric:: Columns header

* Click on the header of a column will sort the list on that column (first ascending, then descending).

.. note ::

   * The sorting is not always on the displayed name.

     * if the sorted column is linked to a reference list with sort order value, the sorting is executed on this sort value
    
       * for instance, here the sorting on the status is executed corresponding to Status sort order value, defined as a logic workflow for status change.

.. rubric:: Items list

* Click on a line (any column) will display the corresponding item in the detail window.

.. raw:: latex

    \newpage

.. _gui-advanced-filter-label:

Advanced filter
"""""""""""""""

.. figure:: /images/GUI/advancedFilterDefinition.png
   :scale: 60 %
   :alt: Advanced filter definition pop-up
   :align: center

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


.. figure:: /images/GUI/selectColunmsToDisplay.png
   :scale: 60 %
   :alt: Select columns to display pop-up
   :align: center

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


.. figure:: /images/GUI/chooseColumnsToExport.png
   :scale: 60 %
   :alt: Choose columns to export pop-up
   :align: center

.. note ::

   * CSV exported files can directly be imported through the Import functionality.



.. raw:: latex

    \newpage

Detail window
-------------

.. figure:: /images/GUI/detailWindow.png
   :scale: 60 %
   :alt: GUI detail window
   :align: center

   Detail window


.. figure:: /images/GUI/detailWindowPart.png
   :scale: 60 %
   :alt: GUI detail window Part
   :align: center


.. rubric:: Element identified

* Identifies the element and the item id number.
* Each element are associated to a distinctive icon.

.. rubric:: Creation information

* Information about item creation : issuer and date.

.. note::

   * Administrator can change information.


.. raw:: latex

    \newpage 

.. rubric:: Buttons

* Click on |buttonIconNew| to create new item.        

* Click on |buttonIconSave| to save the changes. 

  * You can rapidly save with :kbd:`Control-s`.      

* Click on |buttonIconPrint| to get a printable version of the detail.

* Click on |buttonIconPdf|  to get a printable version of the detail in PDF format.
 
* Click on |buttonIconCopy| to copy the current item (see : :ref:`gui-copyAndTransform-item-label`).        

* Click on |buttonIconUndo| to cancel ongoing changes.      

* Click on |buttonIconDelete| to delete the item.      

* Click on |buttonIconRefresh| to refresh the display.      

* Click on |buttonIconEmail| to send detail of item by email (see : :ref:`gui-email-detail-label`).

* Click on |buttonIconMultipleUpdate| to update several items in one operation (see : :ref:`gui-multiple-update-label`).

* Click on |buttonIconShowChecklist| to show checklist.

  * Available only when user set user parameter "display checklists" to "On request".
  * For detail of checklist information, see :ref:`gui-checklist-section-label`.

* Click on |buttonIconShowHistory| to show history of changes.

  * Available only when user set user parameter "display history" to "On request".
  * For detail of history of changes information, see :ref:`gui-chg-history-section-label`.

.. note::

   * Some buttons are not clickable when change are ongoing.
  
   * |buttonIconUndo| button is clickable only when changes are ongoing.

.. warning::

   * When changes are ongoing, you can not select another item or another menu item. 

   * Save or cancel ongoing changes first.

.. rubric:: Drop file area

* This area allows to add a attachement file in item.

  * You can drag and drop file.

  * Or click on area to select file.


.. rubric:: Sections

* The fields are regrouped under section.
* All sections can be folded or unfolded, clicking on the section title. 
* The sections are organized in columns.

  * Maximum three columns can be displayed.

* Some sections are displayed on almost all screens, see : :ref:`gui-sections-label`  

.. raw:: latex

    \newpage

.. _gui-copyAndTransform-item-label:

Copy item
"""""""""

* Allows copied item of element.
* Options displayed in pop-up depends on whether an item is simple or complex.

.. figure:: /images/GUI/copyElement.png
   :scale: 60 %
   :alt: GUI copy element
   :align: center


.. topic:: Simple items

    * Simple items (environment parameters, lists, …) can only be copied “as is”.

.. topic:: Complex items

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
  
.. _gui-email-detail-label:

Email detail
""""""""""""

It is possible to send an informative email to defined recipients list.

**message**

* The message that will be included in the body of the email, in addition to complete description of item.



.. raw:: latex

    \newpage

.. _gui-multiple-update-label:

Multiple update
"""""""""""""""

To update several items in one operation.

This will switch to new detail view :

.. figure:: /images/GUI/multipleModePart1.png
   :scale: 60 %
   :alt: GUI Multiple mode part 1
   :align: center

At this step, although the list does not seem to have changed, but it is now multi-selectable :

.. figure:: /images/GUI/multipleModePart2.png
   :scale: 60 %
   :alt: GUI Multiple mode part 2
   :align: center

Select lines of items you want to update, specify update and save : the update will be applied to all the items (if possible) and a report will be displayed on the right of the Multiple mode detail screen.

.. figure:: /images/GUI/multipleModePart3.png
   :scale: 60 %
   :alt: GUI Multiple mode part 3
   :align: center


.. raw:: latex

    \newpage

.. _gui-combo-list-fields-label:

Combo list fields
"""""""""""""""""

Combo list field allows to search, view or create item associate with the field.

.. figure:: /images/GUI/comboListFields.png
   :scale: 60 %
   :alt: GUI Combo list fields
   :align: center

   Example


* Click on |comboArrowDown| to get the list of value.

* Click on |buttonIconSearch| to access item details.

  * The action depends on whether the element is selected or not.

* Click on |iconGoto| will directly go to the selected item. 

.. note::

   * Access to view or create item depends on your access rights.

   * Some buttons become not available.

.. rubric:: Element is selected

If element is selected in the combo, detail of element is displayed.

.. figure:: /images/GUI/detailOfListElementOpt1.png
   :scale: 60 %
   :alt: GUI Detail of liste element option one
   :align: center

* Click on |buttonIconSearch| to search an item.
* Click on |buttonIconUndo| to close the window.

.. raw:: latex

    \newpage

.. rubric:: No element is selected

If no element is selected, list of elements is displayed, allowing to select an item.

.. figure:: /images/GUI/detailOfListElementOpt2.png
      :scale: 60 %
      :alt: GUI Detail of liste element option two
      :align: center

* Click on |buttonIconSelect| to select item.
* Click on |buttonIconNew| to create a new item.
* Click on |buttonIconUndo| to close the window.

.. note:: Header window

   * You have access to rapid filter, search button and advanced filter.
   * For detail, see : :ref:`gui-list-window-label`. 

.. note:: Select several items

    * Some elements is possible to select several items, use :kbd:`Control` or :kbd:`Shift`.
   
.. rubric:: Go to selected item

* Click on |iconGoto| will directly go to the selected item.

.. note :: Return to last screen

   * Click on |buttonIconBackNavigation| to return on last screen.

   * For detail, see **Navigation buttons** in :ref:`gui-top-bar-label` section. 

.. raw:: latex

    \newpage

Long text fields
""""""""""""""""

.. figure:: /images/GUI/longTextFields.png
   :scale: 60 %
   :alt: GUI long text fields
   :align: center

   Example

* Long text fields allow to write description, results, notes, ...

* A mini editor is provided.

* Text zone is expendable.

.. note :: Editor mode always on

   * This parameter defines editor is always on in long text fields.

   * See this parameter under "Graphic interface behavior" section in :ref:`user-parameters-label`. 

.. raw:: latex

    \newpage

Info bar
--------

.. figure:: /images/GUI/infobar.png
   :scale: 60 %
   :alt: GUI info bar
   :align: center

   Info bar

.. figure:: /images/GUI/infobarPart.png
   :scale: 60 %
   :alt: GUI info bar Part
   :align: center

.. rubric:: Log out button

* Allow to disconnect user.

.. note :: confirm quit application

   * This parameter defines whether a confirm disconnection will be displayed before.

   * See this parameter under "Graphic interface behavior" section in :ref:`user-parameters-label`. 

.. rubric:: User parameters button

* Allow to access user parameters.

.. rubric:: Hide and show menu button

* Allow to hide or show menu button

.. note :: hide menu

   * This parameter defines whether the menu is hidden by default.

   * See this parameter under "Graphic interface behavior" section in :ref:`user-parameters-label`. 

.. rubric:: Switched mode button

* Allow to enable or disable switched mode between list and detail windows.

* Window selected is displayed in "full screen" mode.

* Hidden window are replaced by a gray bar.

* Click on he gray bar to switch between windows. 

.. note :: switched mode

   * This parameter defines wheater switched mode is enable or not.

   * See this parameter under "Graphic interface behavior" section in :ref:`user-parameters-label`. 


.. rubric:: Database name

* Display database name.

.. rubric:: Version button

* Display application version.

* Click on button access to ProjeQtOr site.


.. raw:: latex

    \newpage

.. _gui-sections-label:

Common sections
---------------

Some sections are displayed on almost all screens.

Those sections allows to set information or link information to item of the element.

Section: Description
""""""""""""""""""""

This section allows to put information about item of the element.

Section: Treatment
""""""""""""""""""

This section allows to put information treatment done on the item of the element.

Mostly information under this section are :

* Status and Dates
* Responsible
* Result, Comment
* And so on

.. _gui-checklist-section-label:

Section: Checklist
""""""""""""""""""

If a checklist is defined for the current element a checklist section will appear.

The user just has to check information corresponding to the situation.

When done, the user name and checked date are recorded and displayed.

Each line can get an extra comment, as well a globally on the checklist.

.. note::

   * How to define a checklist, see: :ref:`ctrlAuto-checklist-def-label`. 

.. note:: display checklists

   * This parameter defines whether the checklist section is hidden or not.
  
   * If the value "On request" is set |buttonIconShowChecklist| button appear on detail header window.

   * See this parameter under "Graphic interface behavior" section in :ref:`user-parameters-label`.    


.. raw:: latex

    \newpage

.. _gui-LinkElement-section-label:

Section: Linked element
"""""""""""""""""""""""

Most items can be linked to most of all other items (Actions, Activities, Tickets, Documents, …).

.. note:: 

   Linked elements must belong to the same project.

Click |buttonAdd| on the corresponding section to add a link to an element. A “add link” pop up will be displayed. 

Select the linked element in the list and validate (OK).

Click on |buttonRemove| to delete the corresponding link.

.. figure:: /images/GUI/addLink.png
   :scale: 60 %
   :alt: GUI add link Pop-up
   :align: center

   Add link Popup

.. topic:: Linked element

   * Click on |buttonIconSearch| to show element detail.
   * Depends on whether the element is selected or not a pop up is displayed.
   * Detail about pop up, see :ref:`gui-combo-list-fields-label`

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

  .. index:: ! attachment - section

.. _gui-attachment-section-label:

Section: Attachments
""""""""""""""""""""

Users can attach files or hyperlinks on most of items.

Click on |buttonAdd| to add a attachment to an element. A “Attachment file” pop up will be displayed. 

Click on |iconLink| to add hyperlink to an element. A “Attachment hyperlink” pop up will be displayed. 

Select the attachment depends on either is a file or a hyperlink and validate (OK).

Click on |iconDownload| to download attachment file.

Click on |iconLink| to access to hyperlink.

Click on |buttonRemove| to delete the attachment.

.. rubric:: Attachment file

* To upload file :

  * Select file with "Browse" button.
  * Drop the file in "drop files here" area.

.. figure:: /images/GUI/attachmentFile.png
   :scale: 60 %
   :alt: GUI attachment file Pop-up
   :align: center

   Attachment file Pop up


.. rubric:: Hyperlink

* Set hyperlink in hyperlink field.

.. figure:: /images/GUI/attachmentHyperLink.png
   :scale: 60 %
   :alt: GUI attachment hyperlink Pop-up
   :align: center

   Attachment hyperlink Pop up

.. rubric:: Attachment visibilty

* public : Visible to anyone.
* team : Visible to every member of the creator’s team.
* private :  Visible only to creator.

.. rubric:: Attachment information

.. tabularcolumns:: |l|l|

.. list-table::
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
     - User who created the attchment.


.. index:: ! note - section

.. _gui-note-section-label:

Section: Notes
""""""""""""""

Users can add notes on most items.

Notes are comments, that can be shared to track some information or progress.

Click on |buttonAdd| to add a note to an element. A “note” pop up will be displayed. 

Click on |buttonEdit| to edit the note.

Click on |buttonRemove| to delete the note.

.. figure:: /images/GUI/note.png
   :scale: 60 %
   :alt: GUI note Pop-up
   :align: center

   Note Pop up

.. rubric:: Predefined note

* Predefined note list of value appear whetear a prefedefined note is created.

* Selecting an item in the list will automatically fill in the note text field.

* How to define predefined note, see: :ref:`ctrlAuto-predefined-notes-label`.

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

.. _gui-chg-history-section-label:

Section: Change history
"""""""""""""""""""""""

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

   * See this parameter under "Graphic interface behavior" section in :ref:`user-parameters-label`.    

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

   * See this parameter under "Display parameters" section in :ref:`user-parameters-label`. 


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

   * See this parameter under "Display parameters" section in :ref:`user-parameters-label`. 


