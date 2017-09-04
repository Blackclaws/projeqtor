	dependencies = {
	//Strip all console.* calls except console.warn and console.error. This is basically a work-around
	//for trac issue: http://bugs.dojotoolkit.org/ticket/6849 where Safari 3's console.debug seems
	//to be flaky to set up (apparently fixed in a webkit nightly).
	//But in general for a build, console.warn/error should be the only things to survive anyway.
	stripConsole: "normal",

	layers: [
		{
			name: "projeqtorMobileDojo.js",
			dependencies: [
         "dojox/mobile/parser",
         "dojo/data/ItemFileReadStore",
         "dojo/domReady!",
         "dijit/form/DataList",
         "dijit/layout/ContentPane",
         "dojox/mobile/Badge",
         "dojox/mobile/Button",
         "dojox/mobile/ComboBox",
         "dojox/mobile/compat",
         "dojox/mobile/Container",
         "dojox/mobile/ContentPane",       
         "dojo/store/DataStore",
         "dojox/mobile/FormLayout",
         "dojox/mobile/Heading",
         "dojox/mobile/ListItem",
         "dojox/mobile/ProgressIndicator",   
         "dojox/mobile/ScrollableView",
         "dojox/mobile/View",
         "dojox/mobile/RoundRect",
         "dojox/mobile/RoundRectCategory",
         "dojox/mobile/RoundRectList",
         "dojox/mobile/SpinWheelDatePicker",
         "dojox/mobile/SpinWheelTimePicker",
         "dojox/mobile/SimpleDialog",
         "dojox/mobile/Switch",
         "dojox/mobile/TextArea",
         "dojox/mobile/TextBox",
         "dojox/mobile/ToolBarButton"
			]
		}
	],

	prefixes: [
	    [ "dojo",  "../../dojo" ],
		[ "dijit", "../dijit" ],
		[ "dojox", "../dojox" ]
	]
}
