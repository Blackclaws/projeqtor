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
    		"dojox/mobile/compat",
    		"dojox/mobile/ScrollableView",
    		"dojox/mobile/View",
    		"dojox/mobile/Heading",
    		"dojox/mobile/RoundRect",
    		"dojox/mobile/RoundRectList",
    		"dojox/mobile/ListItem",
    		"dojox/mobile/Switch",
    		"dojox/mobile/RoundRectCategory",
    		"dojox/mobile/FormLayout",
    		"dojox/mobile/SimpleDialog",
    		"dojox/mobile/TextBox",
    		"dojox/mobile/ComboBox",
    		"dojox/mobile/TextArea",
    		"dojox/mobile/Button",
    		"dojox/mobile/ToolBarButton",
    		"dojox/mobile/ProgressIndicator",
    		"dojox/mobile/ContentPane",
    		"dojox/mobile/Badge",
        "dojox/mobile/SpinWheelDatePicker",
        "dojox/mobile/SpinWheelTimePicker",
        "dojo/data/ItemFileReadStore",
        "dojo/store/DataStore",
        "dijit/form/DataList"
			]
		}
	],

	prefixes: [
	    [ "dojo",  "../../dojo" ],
		[ "dijit", "../dijit" ],
		[ "dojox", "../dojox" ]
	]
}
