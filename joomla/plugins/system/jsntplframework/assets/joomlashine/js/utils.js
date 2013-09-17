/**
* @author    JoomlaShine.com http://www.joomlashine.com
* @copyright Copyright (C) 2008 - 2011 JoomlaShine.com. All rights reserved.
* @license   GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
*/
var JSNUtils = {
	/* ============================== BROWSER  ============================== */
	/**
	 * Encode double quote character to comply with Opera browser
	 * Add more rules here if needed
	 */
	encodeCookie: function(value) {
		return value.replace(/\"/g, '%22');
	},

	/**
	 * Decode double quote character back to normal
	 */
	decodeCookie: function(value) {
		return value.replace(/\%22/g, '"');
	},

	writeCookie: function (name,value,days){
		value = JSNUtils.encodeCookie(value);

		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		} else expires = "";

		document.cookie = name+"="+value+expires+"; path=/";
	},

	readCookie: function (name){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return JSNUtils.decodeCookie(c.substring(nameEQ.length,c.length));
		}
		return null;
	},

	isIE7: function() {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1);
	},

	isDesktopViewOnMobile: function (params) {
		if (params && params.responsiveLayout) {
			if (!params.responsiveLayout.contains('mobile') && (JSNUtils.checkSmartphone()|| JSNUtils.checkTablet())) {
				document.body.addClass('jsn-desktop-on-mobile');
			}
		}

		return document.body.hasClass('jsn-mobile');
	},

	initMenuForDesktopView: function () {
		var sitetools = document.id('jsn-sitetools-menu');

		if (sitetools != null)
			sitetools.addClass('sitetool-desktop-on-mobile');

		document.getElements('ul.menu-mainmenu').addClass('jsn-desktop-on-mobile');
	},

	getBrowserInfo: function(){
		var name	= '';
		var version = '';
		var ua 		= navigator.userAgent.toLowerCase();
		var match	= ua.match(/(opera|ie|firefox|chrome|version)[\s\/:]([\w\d\.]+)?.*?(safari|version[\s\/:]([\w\d\.]+)|$)/) || [null, 'unknown', 0];
		if (match[1] == 'version')
		{
			name = match[3];
		}
		else
		{
			name = match[1];
		}
		version = parseFloat((match[1] == 'opera' && match[4]) ? match[4] : match[2]);

		return {'name': name, 'version': version};
	},

	/* ============================== DEVICE  ============================== */

	checkMobile: function(){
		var uagent = navigator.userAgent.toLowerCase(), isMobile = false, mobiles = [
			"midp","240x320","blackberry","netfront","nokia","panasonic",
			"portalmmm","sharp","sie-","sonyericsson","symbian",
			"windows ce","benq","mda","mot-","opera mini",
			"philips","pocket pc","sagem","samsung","sda",
			"sgh-","vodafone","xda","palm","iphone",
			"ipod","android", "ipad"
		];

		for (var i = 0; i < mobiles.length; i++) {
			if (uagent.indexOf(mobiles[i]) != -1) {
				isMobile = true;
			}
		}

		return isMobile;
	},

	getScreenWidth: function(){
		var screenWidth;

		if( typeof( window.innerWidth ) == 'number' )
		{
			// IE 9+ and other browsers
			screenWidth = window.innerWidth;
		}
		else if (document.documentElement && document.documentElement.clientWidth)
		{
			//IE 6 - 8
			screenWidth = document.documentElement.clientWidth;
		}

		return screenWidth;
	},

	checkSmartphone: function(){
		var screenWidth = JSNUtils.getScreenWidth(), isSmartphone = false;

		if (screenWidth >= 320 && screenWidth < 480)
		{
			isSmartphone = true;
		}

		return isSmartphone;
	},

	checkTablet: function(){
		var screenWidth = JSNUtils.getScreenWidth(), isTablet = false;

		if (screenWidth >= 481 && screenWidth < 1024)
		{
			isTablet = true;
		}

		return isTablet;
	},

	getScreenType: function(){
		var screenType;

		if (JSNUtils.checkSmartphone()) {
			screenType = 'smartphone';
		} else if (JSNUtils.checkTablet()) {
			screenType = 'tablet';
		} else {
			screenType = 'desktop';
		}

		return screenType;
	},


	/* ============================== DOM - GENERAL ============================== */

	addEvent: function(target, event, func){
		if (target.addEventListener){
			target.addEventListener(event, func, false);
			return true;
		} else if (target.attachEvent){
			var result = target.attachEvent("on"+event, func);
			return result;
		} else {
			return false;
		}
	},

	getElementsByClass: function(targetParent, targetTag, targetClass, targetLevel){
		var elements, tags, tag, tagClass;

		if(targetLevel == undefined){
			tags = targetParent.getElementsByTagName(targetTag);
		}else{
			tags = JSNUtils.getChildrenAtLevel(targetParent, targetTag, targetLevel);
		}

		elements = [];

		for(var i=0;i<tags.length;i++){
			tagClass = tags[i].className;
			if(tagClass != "" && JSNUtils.checkSubstring(tagClass, targetClass, " ", false)){
				elements[elements.length] = tags[i];
			}
		}

		return elements;
	},

	getFirstChild: function(targetEl, targetTagName){
		var nodes, node;
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if (node.tagName == targetTagName)
				return node;
		}
		return null;
	},

	getFirstChildAtLevel: function(targetEl, targetTagName, targetLevel){
		var child, nodes, node;
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if (targetLevel == 1) {
				if(node.tagName == targetTagName) return node;
			} else {
				child = JSNUtils.getFirstChildAtLevel(node, targetTagName, targetLevel-1);
				if(child != null) return child;
			}
		}
		return null;
	},

	getChildren: function(targetEl, targetTagName){
		var nodes, node;
		var children = [];
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if(node.tagName == targetTagName)
				children.push(node);
		}
		return children;
	},

	getChildrenAtLevel: function(targetEl, targetTagName, targetLevel){
		var children = [];
		var nodes, node;
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if (targetLevel == 1) {
				if(node.tagName == targetTagName) children.push(node);
			} else {
				children = children.concat(JSNUtils.getChildrenAtLevel(node, targetTagName, targetLevel-1));
			}
		}
		return children;
	},

	addClass: function(targetTag, targetClass){
		if(targetTag.className == ""){
			targetTag.className = targetClass;
		} else {
			if(!JSNUtils.checkSubstring(targetTag.className, targetClass, " ")){
				targetTag.className += " " + targetClass;
			}
		}
	},

	getViewportSize: function(){
		var myWidth = 0, myHeight = 0;

		if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			//IE 6+ in 'standards compliant mode'
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}

		return {width:myWidth, height:myHeight };
	},

	addURLPrefix: function(targetId)
	{
		var navUrl 			= window.location.href;
		var targetEl 		= document.getElementById(targetId);
		if(targetEl != undefined && targetEl.tagName.toUpperCase() == 'A')
		{
			orgHref = targetEl.href;
			targetEl.href = navUrl + ((navUrl.indexOf(orgHref) != -1)?'':orgHref);
		}
	},

	/* ============================== DOM - GUI ============================== */
	/* ============================== DOM - GUI - MENU ============================== */

	/**
	 * Reposition submenu if it goes off screen area.
	 */
	setSubmenuPosition: function(enableRTL)
	{
		// Initialize parameters
		var maxSize, parents, enableRTL = enableRTL || false;

		// Get all parents
		parents = document.getElements('ul.menu-mainmenu > li.parent');

		if (!parents.length) return;

		// Add level to all submenus
		parents.each(function(parent) {
			var submenu = parent.getChildren('ul'), level = 0;

			while (submenu.length) {
				var tmp = [];

				// Increase submenu level
				level++;

				// Add class to indicate submenu level
				submenu.each(function(ul) {
					ul.addClass('jsn-submenu-level-' + level);

					// Get nested submenus
					tmp = tmp.extend(ul.getElements('> li.parent > ul'));
				});

				// Set nested submenus
				submenu = tmp;
			}

			// Store max level of submenu
			parent.jsnMaxSubmenuLevel = level;
		});

		// Declare some utilities
		var placeSubmenu = function(parent, flipBack) {
			var	width = 0, submenu = parent.getElement('ul.jsn-submenu-level-' + parent.jsnMaxSubmenuLevel),
				farLeft = (enableRTL || flipBack) ? submenu.getPosition().x : parent.getPosition().x;

			// Calculate total width when all nested submenus are expanded
			if ( ! enableRTL) {
				while (!submenu.hasClass('menu-mainmenu')) {
					width += submenu.getSize().x;
	
					// Travel back the DOM tree
					submenu = submenu.getParent().getParent();
				}
			}

			// Check if there is any submenu goes off screen when all nested submenus are expanded
			if (((enableRTL || flipBack) && farLeft < 0) || ((!enableRTL || flipBack) && farLeft + width > maxSize.x)) {
				if (!flipBack) {
					parent.addClass('jsn-submenu-flipback');

					// Check if there is any submenu goes off screen in the opposite side after flipping back
					placeSubmenu(parent, true);
				} else {
					parent.removeClass('jsn-submenu-flipback');
				}
			}
		},

		resizeHandler = function() {
			// Disable left-right scrolling
			document.body.setStyle('overflow-x', 'hidden');

			// Temporary disable transition effect
			document.body.removeClass('jsn-css3');

			// Update max screen area
			maxSize = window.getSize();

			// Restore original position for all submenu
			parents.removeClass('jsn-submenu-flipback');

			// Place all submenus
			parents.each(function(parent) {
				var submenus = parent.getElements('ul');

				// Make sure all submenus is visible
				submenus.setStyle('display', 'block');

				// Place nested submenus
				placeSubmenu(parent);

				// Restore default visibility state for submenu
				submenus.setStyle('display', '');
			});

			// Re-enable transition effect if not viewing desktop site on mobile
			document.body.hasClass('jsn-desktop-on-mobile') || document.body.addClass('jsn-css3');

			// Restore original left-right scrolling
			document.body.setStyle('overflow-x', '');
		};

		// Handle window resize event
		window.addEvent('resize', function() {
			placeSubmenu.timer && clearTimeout(placeSubmenu.timer);
			placeSubmenu.timer = setTimeout(resizeHandler, 500);
		});

		// Place all submenus
		resizeHandler();
	},

	setMobileMenu: function(menuClass)
	{
		var toggle = function() {
			this.toggleClass("active");
			this.getNext("ul").toggleClass("jsn-menu-mobile");

			document.getElements("." + menuClass + " .jsn-menu-toggle").each(function (item) {
				var a = item.getPrevious(),
					size = a.getSize();

				item.setStyle('height', size.y);
			});
		};

		// Setup toggle for main trigger
		document.getElements("ul." + menuClass).getPrevious(".jsn-menu-toggle").addEvent('click', toggle);

		// Setup toggle for children triggers
		document.getElements("ul." + menuClass + " .jsn-menu-toggle").addEvent('click', toggle);

		window.addEvent('resize', function () {
			if (window.getSize().x > 960) {
				document.getElements('ul.jsn-menu-mobile').removeClass('jsn-menu-mobile');
			}
		});
	},

	setMobileSticky: function()
	{
		var page 			= document.id('jsn-page'),
			menu   			= document.id('jsn-menu'),
			menuToggler 	= menu.getElement('.jsn-menu-toggle'),
			mainMenu 		= menu.getElement('ul.menu-mainmenu'),
			menuSize 		= menu.getCoordinates(),
			menuPlacehoder 	= new Element('div', { 'id': 'jsn-menu-placeholder' }),
			menuParent		= menu.getParent(),
			menuParentOffset = menuParent.getCoordinates(),
			menuLeft 		= menuSize.left,
			menuPaddingHorz = parseInt(menu.getStyle('padding-left')) + parseInt(menu.getStyle('padding-right')),
			menuBorderHorz  = parseInt(menu.getStyle('border-left')) + parseInt(menu.getStyle('border-right')),
			isSticked		= false,
			touchStartOffset = {},
			isFixedSupport  = JSNUtils.isFixedSupport();

		menuPlacehoder.setStyles({
			height: menuSize.height,
			margin: menu.getStyle('margin')
		});

		var getMaxMenuHeight = function () { return window.innerHeight - menuSize.height; };
		var getTouchDirection = function (touchEvent) { return touchEvent.touches[0].pageY > touchStartOffset.y ? 'up' : 'down'; };

		var resetMenuPosition = function () {
			if (window.getScroll().y < menuPlacehoder.getPosition().y) {
				menu
					.removeClass('jsn-menu-sticky')
					.removeAttribute('style');

				menuPlacehoder.dispose();
				mainMenu.setStyles({
					'max-height': 'auto',
					'overflow-y': 'hidden'
				});

				isSticked = false;
			}
		};

		var getMenuWidth = function (forceMenuWidth) {
			var menuWidth = forceMenuWidth || menuSize.width;

			if (!isNaN(menuPaddingHorz))
				menuWidth = menuWidth - menuPaddingHorz;

			if (!isNaN(menuBorderHorz))
				menuWidth = menuWidth - menuBorderHorz;

			return menuWidth;
		};

		var fx = new Fx.Morph(menu, { transition: Fx.Transitions.Expo.easeOut });
			fx.addEvent('complete', resetMenuPosition);

		var makeMenuStick = function () {
			var scrollTop = window.getScroll().y,
				menuOffsetTop = menu.getPosition().y;

			if (mainMenu.getStyle('display') == 'block')
				return;

			if (scrollTop > menuOffsetTop && menuParent.getElement('#jsn-menu-placeholder') == null && isSticked == false) {
				if (fx.isRunning())
					fx.cancel();

				menuSize = menu.getCoordinates();
				menuLeft = menuSize.left;

				menu.addClass('jsn-menu-sticky')
					.setStyles({
						'left'		: menuLeft,
						'width'		: getMenuWidth(),
						'position'	: isFixedSupport ? 'fixed' : 'absolute',
						'top'		: isFixedSupport ? 0 : scrollTop,
						'z-index'   : 9999999
					});

				menuPlacehoder.inject(menu, 'before');
				isSticked = true;
			}
		};

		var updatePosition = function () {
			makeMenuStick();

			var scrollTop = window.getScroll().y,
				placeHoderOffset = menuPlacehoder.getPosition().y;

			if (fx.isRunning()) fx.pause();

			// Reset menu position
			if (isSticked == true && placeHoderOffset > scrollTop && menu.getStyle('position') == 'fixed') {
				menu.setStyles({
					position 	: 'absolute',
					top 		: scrollTop,
					left 		: menuPlacehoder.getCoordinates().left,
					width		: getMenuWidth()
				});

				fx.start({ top: placeHoderOffset });
			}

			// Update menu position
			else if (isSticked == true && menu.getStyle('position') == 'absolute') {
				var menuTop = menu.getPosition().y;

				if (mainMenu.getStyle('display') == 'block')
					return;

				fx.start({
					top: (placeHoderOffset > scrollTop) ? placeHoderOffset : scrollTop,
					left: menuPlacehoder.getCoordinates().left
				});
			}

			else {
				menu.setStyle('left', menuPlacehoder.getCoordinates().left);
			}
		};

		var updatePositionTimeout = null,
			updateMenuSizeTimeout = null,
			isMovedToTop          = false,
			backupWindowScroll    = null,
			pageHeight = page.getSize().y;

		menu.getElements('.jsn-menu-toggle').addEvent('click', function () {
			var menuHeight = menu.getSize().y + mainMenu.getSize().y;

			if (menuToggler.hasClass('active')) {
				if (menuHeight > window.getSize().y && menu.hasClass('jsn-menu-sticky')) {
					backupWindowScroll = window.getScroll();

					page.setStyles({ 'height': menuHeight, 'overflow': 'hidden' });
					menu.setStyles({ 'position': 'absolute', 'top': 0 });

					if (isMovedToTop == false) {
						window.scrollTo(0, 0);
						isMovedToTop = true;
					}
				}
				else {
					page.setStyles({ 'height': '', 'overflow': 'visible' });
					isMovedToTop = false;
				}
			}
			else {
				page.setStyles({ 'height': '', 'overflow': 'visible' });
				isMovedToTop = false;

				updatePosition();
			}
		});

		window.addEvent('touchmove', makeMenuStick);
		window.addEvent('scroll', updatePosition);
		window.addEvent('resize', function () {
			clearTimeout(updateMenuSizeTimeout);
			updateMenuSizeTimeout = setTimeout(function () {
				if (isSticked == true) {
					menuSize = menuPlacehoder.getCoordinates();
					menu.setStyle('width', getMenuWidth());
				}
				else {
					menuSize = menu.getCoordinates();
				}
			}, 100);
		});

		window.addEvent('orientationchange', function () {
			updatePosition();
		});

		window.addEvent('load', function () {
			clearTimeout(updatePositionTimeout);
			updatePositionTimeout = setTimeout(updatePosition, 100);
		});
	},

	setDropdownModuleEvents: function ()
	{
		document.getElements('div#jsn-menu div.display-dropdown.jsn-modulecontainer h3.jsn-moduletitle')
			.addEvent('click', function (e) {
				var
				elm = e.target;
				while (!elm.hasClass('jsn-modulecontainer'))
					elm = elm.getParent();

				elm.toggleClass('jsn-dropdown-active');
			});
	},

	setMobileSitetool: function()
	{
		var siteToolPanel = document.id("jsn-sitetoolspanel");

		if (siteToolPanel)
		{
			siteToolPanel.getElements("li.jsn-sitetool-control").addEvent("click", function() {
				this.toggleClass("active");
			});
		}
	},

	getSelectMenuitemIndex: function(elementID)
	{
		var childs = document.id(elementID).childNodes;
		var count  = childs.length;
		var index  = 0;

		for (var i = 0; i < count; i++)
		{
			if(childs[i].className != undefined && childs[i].className.indexOf('parent') != -1)
			{
				if(childs[i].className.indexOf('active') != -1)
				{
					return index;
				}
				index++;
			}
		}
		return -1;
	},

	createImageMenu: function(menuId, imageClass){
		if (!document.getElementById) return;

		var list = document.getElementById(menuId);
		var listItems;

		var listItem;

		if(list != undefined) {
			listItems = list.getElementsByTagName("LI");
			for(i=0, j=0;i<listItems.length;i++){
				listItem = listItems[i];
				if (listItem.parentNode == list) {
					listItem.className += " " + imageClass + (j+1);
					j++;
				}
			}
		}
	},

	/* Set position of side menu sub panels */
	setSidemenuLayout: function(menuClass, rtlLayout)
	{
		var sidemenus, sidemenu, smChildren, smChild, smSubmenu;
		sidemenus = JSNUtils.getElementsByClass(document, "UL", menuClass);
		if (sidemenus != undefined) {
			for(var i=0;i<sidemenus.length;i++){
				sidemenu = sidemenus[i];
				smChildren = JSNUtils.getChildren(sidemenu, "LI");
				if (smChildren != undefined) {
					for(var j=0;j<smChildren.length;j++){
						smChild = smChildren[j];
						smSubmenu = JSNUtils.getFirstChild(smChild, "UL");
						if (smSubmenu != null) {
							if(rtlLayout == true) { smSubmenu.style.marginRight = smChild.offsetWidth+"px"; }
							else { smSubmenu.style.marginLeft = smChild.offsetWidth+"px"; }
						}
					}
				}
			}
		}
	},

	/* Set position of sitetools sub panel */
	setSitetoolsLayout: function(sitetoolsId, rtlLayout)
	{
		var sitetoolsContainer, parentItem, sitetoolsPanel, neighbour;
		sitetoolsContainer = document.getElementById(sitetoolsId);
		if (sitetoolsContainer != undefined) {
			parentItem = JSNUtils.getFirstChild(sitetoolsContainer, "LI");
			sitetoolsPanel = JSNUtils.getFirstChild(parentItem, "UL");
			if (rtlLayout == true) {
				sitetoolsPanel.style.marginRight = -1*(sitetoolsPanel.offsetWidth - parentItem.offsetWidth) + "px";
			} else {
				sitetoolsPanel.style.marginLeft = -1*(sitetoolsPanel.offsetWidth - parentItem.offsetWidth) + "px";
			}
		}
	},

	/* Change template setting stored in cookie */
	setTemplateAttribute: function(templatePrefix, attribute, value)
	{
		var templateParams = JSON.parse(JSNUtils.readCookie(templatePrefix + 'params')) || {};

		templateParams[attribute] = value;

		JSNUtils.writeCookie(templatePrefix + 'params', JSON.stringify(templateParams));

		window.location.reload(true);
	},

	createExtList: function(listClass, extTag, className, includeNumber){
		if (!document.getElementById) return;

		var lists = JSNUtils.getElementsByClass(document, "UL", listClass);
		var list;
		var listItems;
		var listItem;

		if(lists != undefined) {
			for(j=0;j<lists.length;j++){
				list = lists[j];
				listItems = JSNUtils.getChildren(list, "LI");
				for(i=0,k=0;i<listItems.length;i++){
					listItem = listItems[i];
					if(className !=''){
						listItem.innerHTML = '<'+ extTag + ' class='+className+'>' + (includeNumber?(k+1):'') + '</'+  extTag +'>' + listItem.innerHTML;
					}else{
						listItem.innerHTML = '<'+ extTag + '>' + (includeNumber?(k+1):'') + '</'+  extTag +'>' + listItem.innerHTML;
					}
					k++;
				}
			}
		}
	},

	createGridLayout: function(containerTag, containerClass, columnClass, lastcolumnClass) {
		var gridLayouts, gridLayout, gridColumns, gridColumn, columnsNumber;
		gridLayouts = JSNUtils.getElementsByClass(document, containerTag, containerClass);
		for(var i=0;i<gridLayouts.length;i++){
			gridLayout = gridLayouts[i];
			gridColumns = JSNUtils.getChildren(gridLayout, containerTag);
			columnsNumber = gridColumns.length;
			JSNUtils.addClass(gridLayout, containerClass + columnsNumber);
			JSNUtils.addClass(gridLayout, 'clearafter');
			for(var j=0;j<columnsNumber;j++){
				gridColumn = gridColumns[j];
				JSNUtils.addClass(gridColumn, columnClass);
				if(j == gridColumns.length-1) {
					JSNUtils.addClass(gridColumn, lastcolumnClass);
				}
				gridColumn.innerHTML = '<div class="' + columnClass + '_inner">' + gridColumn.innerHTML + '</div>';
			}
		}
	},

	sfHover: function(menuId, menuDelay) {
		if(menuId == undefined) return;

		var delay = (menuDelay == undefined)?0:menuDelay;
		var pEl = document.getElementById(menuId);
		if (pEl != undefined) {
			var sfEls = pEl.getElementsByTagName("li");
			for (var i=0; i<sfEls.length; ++i) {
				sfEls[i].onmouseover=function() {
					clearTimeout(this.timer);
					if(this.className.indexOf("sfhover") == -1) {
						this.className += " sfhover";
					}
				}
				sfEls[i].onmouseout=function() {
					this.timer = setTimeout(JSNUtils.sfHoverOut.bind(this), delay);
				}
			}
		}
	},

	sfHoverOut: function() {
		clearTimeout(this.timer);
		this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
	},

	setFontSize: function (targetId, fontSize){
		var targetObj = (document.getElementById) ? document.getElementById(targetId) : document.all(targetId);
		targetObj.style.fontSize = fontSize + '%';
	},

	setVerticalPosition: function(pName, pAlignment) {
		var targetElement = document.getElementById(pName);

		if (targetElement != undefined) {
			var topDelta, vpHeight, pHeight;
			vpHeight = (JSNUtils.getViewportSize()).height;
			pHeight = targetElement.offsetHeight;
			switch(pAlignment){
				case "top":
					topDelta = 0;
				break;

				case "middle":
					topDelta = Math.floor((100 - Math.round((pHeight/vpHeight)*100))/2);
				break;

				case "bottom":
					topDelta = 100 - Math.round((pHeight/vpHeight)*100);
				break;
			}

			topDelta = (topDelta < 0)?0:topDelta;

			targetElement.style.top = topDelta + "%";

			targetElement.style.visibility = "visible";
		}
	},

	setupLayout: function()
	{
		var	container = document.id('jsn-content_inner7'), maxWidth = document.id('jsn-content_inner').getSize().x, flip, flipElm, width,
			colLeft, colLeftBg, colRight, colRightBg, colInnerLeft, colInnerLeftBg, colInnerRight, colInnerRightBg;

		// Get left column
		colLeft = container.getChildren().length > 1 ? container.getElement('> .order1') : null;
		colLeft = (colLeft && colLeft.id != 'jsn-maincontent') ? colLeft : container.getElement('> .order2');
		colLeftBg = colLeft ? document.id('jsn-content_inner') : null;

		// Set correct position for left column's background element
		if (colLeft && colLeftBg) {
			flip = colLeft.hasClass('order1') ? false : true;
			flipElm = document.id('jsn-content_inner1');
			width = ((flip ? colLeft.getPosition(container).x : colLeft.getSize().x) / maxWidth) * 100;

			colLeftBg.setStyle(flip ? 'left' : 'right', (flip ? width : 100 - width) + '%');
			flipElm.setStyle(flip ? 'right' : 'left', (flip ? width : 100 - width) + '%');
		}

		// Get right column
		colRight = container.getChildren().length > 1 ? container.getElement('> .order' + container.getChildren().length) : null;
		colRight = (colRight && colRight.id != 'jsn-maincontent') ? colRight : container.getElement('> .order' + (container.getChildren().length - 1));
		colRightBg = colRight ? document.id('jsn-content_inner2') : null;

		// Set correct position for right column's background element
		if (colRight && colRightBg) {
			flip = colRight.hasClass('order' + container.getChildren().length) ? false : true;
			flipElm = document.id('jsn-content_inner3');
			width = ((flip ? maxWidth - colRight.getPosition(container).x - colRight.getSize().x : colRight.getSize().x) / maxWidth) * 100;

			colRightBg.setStyle(flip ? 'right' : 'left', (flip ? width : 100 - width) + '%');
			flipElm.setStyle(flip ? 'left' : 'right', (flip ? width : 100 - width) + '%');
		}

		// Get inner-left column
		container = document.id('jsn-maincontent');
		colInnerLeft = container.getChildren().length > 1 ? container.getElement('> .order1') : null;
		colInnerLeft = (colInnerLeft && colInnerLeft.id != 'jsn-centercol') ? colInnerLeft : null;
		colInnerLeftBg = colInnerLeft ? document.id('jsn-content_inner4') : null;

		// Set correct position for inner-left column's background element
		if (colInnerLeft && colInnerLeftBg) {
			flipElm = document.id('jsn-content_inner5');
			width = ((colInnerLeft.getPosition(container.getParent()).x + colInnerLeft.getSize().x) / maxWidth) * 100;

			colInnerLeftBg.setStyle('right', (100 - width) + '%');
			flipElm.setStyle('left', (100 - width) + '%');
		}

		// Get inner-right column
		colInnerRight = container.getChildren().length > 1 ? container.getElement('> .order' + container.getChildren().length) : null;
		colInnerRight = (colInnerRight && colInnerRight.id != 'jsn-centercol') ? colInnerRight : null;
		colInnerRightBg = colInnerRight ? document.id('jsn-content_inner6') : null;

		// Set correct position for inner-right column's background element
		if (colInnerRight && colInnerRightBg) {
			flipElm = document.id('jsn-content_inner7');
			width = (colInnerRight.getPosition(container.getParent()).x / maxWidth) * 100;

			colInnerRightBg.setStyle('left', width + '%');
			flipElm.setStyle('right', width + '%');
		}
	},

	setEqualHeight: function()
	{
		var containerClass 	= "jsn-horizontallayout";
		var columnClass 	= "jsn-modulecontainer_inner";
		var horizontallayoutObjs = document.getElements('.' + containerClass);
		var maxHeight = 0;
		Array.each(horizontallayoutObjs, function(item) {
			var columns = item.getElements('.'+columnClass);
			maxHeight = 0;
			Array.each(columns, function(col) {
				var coordinates = col.getCoordinates();
				if (coordinates.height > maxHeight) maxHeight = coordinates.height;
			});
			Array.each(columns, function(col) {
				col.setStyle('height',maxHeight);
			});
		});
	},


	/* ============================== MOOTOOLS ANIMATION  ============================== */

	setToTopLinkCenter: function(rtl, jquery)
	{
		/* Min distance to be away from top for the link to be displayed */
		var min = 200;

		/* Determine RTL layout or not to set margin correctly */
		var marginFrom = "margin-left";
		if (rtl === true) {
			marginFrom = "margin-right";
		}

		if (jquery) {
			var element = $j('#jsn-gotoplink');
			if (!element.length) return;
			element.hide();
			($j(window).scrollTop() >= min) ? element.fadeIn() : element.fadeOut();
		} else if (typeof(MooTools) != 'undefined') {
			var element = document.id('jsn-gotoplink');
			if (!element) return;
			var elementHeight = element.getSize().y;

			element
				.setStyle('margin-left', -(element.getSize().x/2))
				.set('opacity','0')
				.fade((window.getScroll().y >= min) ? 'in' : 'out')
				.fade((window.getScroll().y >= min) ? 1 : 0);

			if (!JSNUtils.isFixedSupport()) {
			 	element.setStyle('position', 'absolute');
			 	window.addEvent('scroll', function () {
			 		var height = window.innerHeight;
			 		element.setStyle('bottom', 'auto');
			 		element.setStyle('top', window.getScroll().y + (height - elementHeight));
			 	});
			}
		}
	},

	isFixedSupport: function () {
		var userAgent = window.navigator.userAgent + '',
			isAppleDevice = /ipod|ipad|iphone/.test(userAgent.toLowerCase()),
			isWindowPhone = /Windows Phone/.test(userAgent),
			isAndroid     = /Android/.test(userAgent),
			isSupported   = true;

		if (isAppleDevice || isWindowPhone || isAndroid) {
			var pattern = /AppleWebKit\/([0-9]+\.[0-9]+)\s+/;

			if (isWindowPhone)
				pattern = /IEMobile\/([0-9]+\.[0-9]+);/;

			if (pattern.test(userAgent)) {
				var result  = pattern.exec(userAgent);
				var version = result[1];

				isSupported = ((isAppleDevice || isAndroid) && JSNUtils.versionCompare(version, '534.1', '>='));
			}
		}

		return isSupported;
	},

	versionCompare: function (v1, v2, operator) {
	    this.php_js = this.php_js || {};
	    this.php_js.ENV = this.php_js.ENV || {};

	    var i = 0,
	        x = 0,
	        compare = 0,
	        vm = {
	            'dev': -6,
	            'alpha': -5,
	            'a': -5,
	            'beta': -4,
	            'b': -4,
	            'RC': -3,
	            'rc': -3,
	            '#': -2,
	            'p': -1,
	            'pl': -1
	        },

	        prepVersion = function (v) {
	            v = ('' + v).replace(/[_\-+]/g, '.');
	            v = v.replace(/([^.\d]+)/g, '.$1.').replace(/\.{2,}/g, '.');
	            return (!v.length ? [-8] : v.split('.'));
	        },

	        numVersion = function (v) {
	            return !v ? 0 : (isNaN(v) ? vm[v] || -7 : parseInt(v, 10));
	        };
	    v1 = prepVersion(v1);
	    v2 = prepVersion(v2);
	    x = Math.max(v1.length, v2.length);
	    for (i = 0; i < x; i++) {
	        if (v1[i] == v2[i]) {
	            continue;
	        }
	        v1[i] = numVersion(v1[i]);
	        v2[i] = numVersion(v2[i]);
	        if (v1[i] < v2[i]) {
	            compare = -1;
	            break;
	        } else if (v1[i] > v2[i]) {
	            compare = 1;
	            break;
	        }
	    }
	    if (!operator) {
	        return compare;
	    }

	    switch (operator) {
	    case '>':
	    case 'gt':
	        return (compare > 0);
	    case '>=':
	    case 'ge':
	        return (compare >= 0);
	    case '<=':
	    case 'le':
	        return (compare <= 0);
	    case '==':
	    case '=':
	    case 'eq':
	        return (compare === 0);
	    case '<>':
	    case '!=':
	    case 'ne':
	        return (compare !== 0);
	    case '':
	    case '<':
	    case 'lt':
	        return (compare < 0);
	    default:
	        return null;
	    }
	},

	setSmoothScroll: function(jquery)
	{
		var objBrowser = JSNUtils.getBrowserInfo();

		// Setup smooth go to top link
		if (jquery) {
			$j('#jsn-gotoplink').click(function(e) {
				e.preventDefault();
				var gotoplinkOffset = $j('#top').offset().top;
				$j('html,body').animate({scrollTop: gotoplinkOffset}, 500);
				return false;
			});
		} else if (typeof(MooTools) != 'undefined') {
			new Fx.SmoothScroll({
				duration: 300,
				links: '#jsn-gotoplink'		// Target to only the gotop link
			}, window);
		}
	},

	setFadeScroll: function(jquery)
	{
		var min     = 200;
		if (jquery) {
			var element = $j('#jsn-gotoplink');
			if(element == null) return false;

			$j(window).scroll(function () {
				($j(window).scrollTop() >= min) ? element.fadeIn() : element.fadeOut();
			});
		} else if (typeof(MooTools) != 'undefined') {
			var element = document.id('jsn-gotoplink');
			if (element == null) return false;
			if (parseFloat(MooTools.version) < 1.2)
			{
				var fx 		   = new Fx.Style(element, "opacity", {duration: 500});
				var inside 	   = false;
				window.addEvent('scroll',function(e) {
					var position   = window.getSize().scroll;
					var y          = position.y;
					if (y >= min)
					{
						if (!inside)
						{
							inside = true;
							fx.start(0, 1);
						}
					}
					else
					{
						if (inside)
						{
							inside = false;
							fx.start(1, 0);
						}
					}
				}.bind(this));
			}
			else
			{
				window.addEvent('scroll',function(e) {
					element.fade((window.getScroll().y >= min) ? 'in' : 'out');
					element.fade((window.getScroll().y >= min) ? 1 : 0);
				}.bind(this));
			}
		}
	},

	/* ============================== TEXT  ============================== */

	checkSubstring: function(targetString, targetSubstring, delimeter, wholeWord){
		if(wholeWord == undefined) wholeWord = false;
		var parts = targetString.split(delimeter);
		for (var i = 0; i < parts.length; i++){
			if (wholeWord && parts[i] == targetSubstring) return true;
			if (!wholeWord && parts[i].indexOf(targetSubstring) > -1) return true;
		}
		return false;
	},

	/* ============================== REMOVE DUPLICATE CSS3 TAG IN IE7 - CSS3 PIE  ============================== */

	removeCss3Duplicate: function(className)
	{
		var element = document.getElements('.' + className);
		if (element != undefined)
		{
			element.each(function(e){
				var elementParent = e.getParent();
				var duplicateTag = elementParent.getChildren('css3-container');
				if (duplicateTag.length && duplicateTag.length > 1)
				{
					elementParent.removeChild(duplicateTag[0]);
				}
			});
		}
	}
};
