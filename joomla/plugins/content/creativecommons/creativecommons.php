<?php
/**
* Creative Commons Tagger
*
* version: 0.2
*
* Copyright (c) 2009 Mark A. Taff <mark@marktaff.com>
*
* Licensed under the GNU GPL, version 2, or any later version
* approved by Open Source Matters.
*
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//jimport( 'joomla.event.plugin' );
jimport( 'joomla.plugin.plugin' );

/**
* Creative Commons Tagger Plugin
*/
class plgContentCreativeCommons extends JPlugin {

    /*
    *   Properties...
    */
    var $author        = null;        // The name of the content's author
    var $license       = null;        // The CC license text
    var $title         = null;        // Title of the work
    var $attributeUrl  = null;        // The url to use for attribution
    var $permissions   = null;        // The url to consult to request additional permissions
    var $text          = null;        // The text to replace with the license

    /**
     * ctor
     */
    function plgContentCreativeCommons( &$subject )
    {
        parent::__construct( $subject );
        $this->_plugin =& JPluginHelper::getPlugin( 'content', 'creativecommons' );
        //$this->_params = new JParameter( $this->_plugin->params );

        //echo "Taff";


    } // End function plgContentCreativeCommons()




   /**
    * Slot called when onPrepareContent event fires
    * @param array Unknown
    * @param array Unknown
    * @param integer Unknown
    * @return boolean A bool indicating success
    */
    function onPrepareContent( &$row, &$params, $page=0 )
    {
        // Bail early if no row text
        if ($row->text == "") { return true;}

        // Initialize properties
        $this->initProperties($row);

        $regex = $this->buildRegexPattern();

        // Replace the text
        $row->text = preg_replace_callback( $regex, array($this, 'replacer'), $row->text );

        return true;
    } // End function onPrepareContent()




   /**
    * Reset properties to null
    */
    function initProperties(&$row)
    {
        // Reset properties
        $this->author       = null;
        $this->license      = null;
        $this->attributeUrl = null;
        $this->permissions  = null;

        // Set properties
        $this->title        = $row->title;
        $this->author       = $row->author;
        $this->attributeUrl = "http://".$_SERVER['HTTP_HOST'].$row->readmore_link;

        // Read parameters
        $this->permissions = $this->_params->get( 'permissions' );
		$this->permissions = "http://projectorria.toolware.fr";
    } // End function initProperties()




   /**
    * Build the regex pattern that parses the GeSHi tags
    * @return string The regex pattern
    */
    function buildRegexPattern()
    {
        $regex = '%(.{1}\{)((?:cc-by)|(?:cc-by-sa)|(?:cc-by-nd)|(?:cc-by-nc)|(?:cc-by-nc-sa)|
                      (?:cc-by-nc-nd)|(?:cc-pd)|(?:cc-gpl)|(?:cc-gpl-2)|(?:cc-gpl-3)|(?:cc-lgpl)|(?:cc-bsd)|(?:reserved))\}%sx';

        return $regex;
    } // End function buildRegexPattern()




   /**
    * Replace the text
    * @param array An array of matches (see preg_match_all)
    * @return string String containing the replacement text
    */
    function replacer( &$matches)
    {
        // Handle tags escaped with '{{' that shouldn't actually get replaced
        if ($matches[1] == "{{")
        {
            $this->text = "{" . $matches[2] . "}";
            return $this->text;
        }

        switch (strtolower($matches[2]))
        {
            case "cc-by":
                $this->ccAttribution();
                $this->text = $this->license;
                break;

            case "cc-by-sa":
                $this->ccAttributionShareAlike();
                $this->text = $this->license;
                break;

            case "cc-by-nd":
                $this->ccAttributionNoDerivatives();
                $this->text = $this->license;
                break;

            case "cc-by-nc":
                $this->ccAttributionNonCommercial();
                $this->text = $this->license;
                break;

            case "cc-by-nc-sa":
                $this->ccAttributionNonCommercialShareAlike();
                $this->text = $this->license;
                break;

            case "cc-by-nc-nd":
                $this->ccAttributionNonCommercialNoDerivatives();
                $this->text = $this->license;
                break;

            case "cc-pd":
                $this->ccPublicDomain();
                $this->text = $this->license;
                break;

            case "cc-gpl":  /** DEPRECATED **/
                $this->ccGPL2();
                $this->text = $this->license;
                break;

            case "cc-gpl-2":
                $this->ccGPL2();
                $this->text = $this->license;
                break;

            case "cc-gpl-3":
                $this->ccGPL3();
                $this->text = $this->license;
                break;

            case "cc-lgpl":
                $this->ccLGPL();
                $this->text = $this->license;
                break;

            case "cc-bsd":
                $this->ccBSD();
                $this->text = $this->license;
                break;

            case "reserved":
                $this->allRightsReserved();
                $this->text = $this->license;
                break;

            default:
                /** Can't Happen */

        } // End switch

        return $this->text;
    }



   /**
    * Builds the license string for the
    * Creative Commons Attribution License
    * @return string The license code
    */
    function ccAttribution()
    {
        $this->license = <<<LICENSE
<a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/us/88x31.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" property="dc:title" rel="dc:type"><em>{$this->title}</em></span> by <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->attributeUrl}" property="cc:attributionName" rel="cc:attributionURL">{$this->author}</a> is licensed<br /> under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/us/">Creative Commons Attribution 3.0 United States License</a>.<br />Permissions beyond the scope of this license may be <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->permissions}" rel="cc:morePermissions">available</a>.
LICENSE;
    } //End function ccAttribution()




   /**
    * Builds the license string for the
    * Creative Commons Attribution Share Alike License
    * @return string The license code
    */
    function ccAttributionShareAlike()
    {
        $this->license = <<<LICENSE
<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/us/88x31.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" property="dc:title" rel="dc:type"><em>{$this->title}</em></span> by <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->attributeUrl}" property="cc:attributionName" rel="cc:attributionURL">{$this->author}</a> is licensed<br /> under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/">Creative Commons Attribution-Share Alike 3.0 United States License</a>.<br />Permissions beyond the scope of this license may be <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->permissions}" rel="cc:morePermissions">available</a>.
LICENSE;
    } //End function ccAttributionShareAlike()




   /**
    * Builds the license string for the
    * Creative Commons Attribution No Derivatives License
    * @return string The license code
    */
    function ccAttributionNoDerivatives()
    {
        $this->license = <<<LICENSE
<a rel="license" href="http://creativecommons.org/licenses/by-nd/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nd/3.0/us/88x31.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" property="dc:title" rel="dc:type"><em>{$this->title}</em></span> by <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->attributeUrl}" property="cc:attributionName" rel="cc:attributionURL">{$this->author}</a> is licensed<br /> under a <a rel="license" href="http://creativecommons.org/licenses/by-nd/3.0/us/">Creative Commons Attribution-No Derivative Works 3.0 United States License</a>.<br />Permissions beyond the scope of this license may be <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->permissions}" rel="cc:morePermissions">available</a>.
LICENSE;
    } //End function ccAttributionNoDerivatives()




   /**
    * Builds the license string for the
    * Creative Commons Attribution Non-Commercial License
    * @return string The license code
    */
    function ccAttributionNonCommercial()
    {
        $this->license = <<<LICENSE
<a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/us/88x31.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" property="dc:title" rel="dc:type"><em>{$this->title}</em></span> by <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->attributeUrl}" property="cc:attributionName" rel="cc:attributionURL">{$this->author}</a> is licensed<br /> under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/us/">Creative Commons Attribution-Noncommercial 3.0 United States License</a>.<br />Permissions beyond the scope of this license may be <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->permissions}" rel="cc:morePermissions">available</a>.
LICENSE;
    } //End function ccAttributionNonCommercial()




   /**
    * Builds the license string for the
    * Creative Commons Attribution Non-Commercial Share Alike License
    * @return string The license code
    */
    function ccAttributionNonCommercialShareAlike()
    {
        $this->license = <<<LICENSE
<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/us/88x31.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" property="dc:title" rel="dc:type"><em>{$this->title}</em></span> by <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->attributeUrl}" property="cc:attributionName" rel="cc:attributionURL">{$this->author}</a> is licensed<br /> under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License</a>.<br />Permissions beyond the scope of this license may be <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->permissions}" rel="cc:morePermissions">available</a>.
LICENSE;
    } //End function ccAttributionNonCommercialShareAlike()




   /**
    * Builds the license string for the
    * Creative Commons Attribution Non-Commercial No Derivatives License
    * @return string The license code
    */
    function ccAttributionNonCommercialNoDerivatives()
    {
        $this->license = <<<LICENSE
<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/us/88x31.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" property="dc:title" rel="dc:type"><em>{$this->title}</em></span> by <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->attributeUrl}" property="cc:attributionName" rel="cc:attributionURL">{$this->author}</a> is licensed<br /> under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/us/">Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 United States License</a>.<br />Permissions beyond the scope of this license may be <a xmlns:cc="http://creativecommons.org/ns#" href="{$this->permissions}" rel="cc:morePermissions">available</a>.
LICENSE;
    } //End function ccAttributionNonCommercialNoDerivatives()




   /**
    * Builds the license string for the
    * Creative Commons Public Domain Declaration
    * @return string The license code
    */
    function ccPublicDomain()
    {
        /// Not Implemented: CC-PD requires email exchange for verification
        $this->license = <<<LICENSE
LICENSE;
    } //End function ccPublicDomain()




   /**
    * Builds the license string for the
    * Creative Commons GNU General Public License
    * @return string The license code
    */
    function ccGPL2()
    {
        $this->license = <<<LICENSE
<!-- Creative Commons License -->
<a href="http://creativecommons.org/licenses/GPL/2.0/">
<img alt="CC-GNU GPL" border="0" src="http://creativecommons.org/images/public/cc-GPL-a.png" /></a><br />
This software is licensed under the <a href="http://creativecommons.org/licenses/GPL/2.0/">CC-GNU GPL</a> version 2.0 or later.
<!-- /Creative Commons License -->
LICENSE;
    } //End function ccGPL2()




   /**
    * Builds the license string for the
    * Creative Commons GNU General Public License
    * @return string The license code
    */
    function ccGPL3()
    {
        $this->license = <<<LICENSE
<!-- License -->
<a href="http://www.gnu.org/licenses/gpl.html">
<img alt="GNU GPL, version 3" height="51" width="127" border="0" src="http://www.gnu.org/graphics/gplv3-127x51.png" /></a><br />
This software is licensed under the <a href="http://www.gnu.org/licenses/gpl.html">GNU GPL</a> version 3.0 or later.
<!-- /License -->
LICENSE;
    } //End function ccGPL3()




   /**
    * Builds the license string for the
    * Creative Commons GNU Lesser General Public License
    * @return string The license code
    */
    function ccLGPL()
    {
        $this->license = <<<LICENSE
<!-- Creative Commons License -->
<a href="http://creativecommons.org/licenses/LGPL/2.1/">
<img alt="CC-GNU LGPL" border="0" src="http://creativecommons.org/images/public/cc-LGPL-a.png" />
</a><br />
This software is licensed under the <a href="http://creativecommons.org/licenses/LGPL/2.1/">CC-GNU LGPL</a> version 2.1 or later.
<!-- /Creative Commons License -->
LICENSE;
    } //End function ccLGPL()




   /**
    * Builds the license string for the
    * Creative Commons Berkeley Software Distribution License
    * @return string The license code
    */
    function ccBSD()
    {
        $this->license = <<<LICENSE
<!-- Creative Commons License -->
<a href="http://creativecommons.org/licenses/BSD/">
<img alt="CC-BSD" border="0" src="http://creativecommons.org/images/license/40bsd.png" />
</a><br />
This software is licensed under the <a href="http://creativecommons.org/licenses/BSD/">CC-BSD</a> license.
<!-- /Creative Commons License -->
LICENSE;
    } //End function ccBSD()




   /**
    * Builds the default All Rights Reserved string
    * @return string The license code
    */
    function allRightsReserved()
    {
        $this->license = <<<LICENSE
    <p>All Rights Reserved.</p>
LICENSE;
    } //End function allRightsReserved()


} // End class plgContentCreativeCommons