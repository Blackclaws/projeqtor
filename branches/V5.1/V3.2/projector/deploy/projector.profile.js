dependencies = {
	//Strip all console.* calls except console.warn and console.error. This is basically a work-around
	//for trac issue: http://bugs.dojotoolkit.org/ticket/6849 where Safari 3's console.debug seems
	//to be flaky to set up (apparently fixed in a webkit nightly).
	//But in general for a build, console.warn/error should be the only things to survive anyway.
	stripConsole: "normal",

	layers: [
		{
			name: "projectorDojo.js",
			dependencies: [
				"dojo.data.ItemFileWriteStore",
			    "dojo.date",
			    "dojo.i18n",
			    "dojo.parser",
			    "dijit.Dialog", 
			    "dijit.Tooltip",
			    "dijit.layout.BorderContainer",
			    "dijit.layout.ContentPane",
			    "dijit.Menu", 
			    "dijit.form.ValidationTextBox",
			    "dijit.form.Textarea",
			    "dijit.form.ComboBox",
			    "dijit.form.CheckBox",
			    "dijit.form.RadioButton",
			    "dijit.form.DateTextBox",
			    "dijit.form.TimeTextBox",
			    "dijit.form.TextBox",
			    "dijit.form.NumberTextBox",
			    "dijit.form.Button",
			    "dijit.ColorPalette",
			    "dijit.form.Form",
			    "dijit.form.FilteringSelect",
			    "dijit.form.MultiSelect",
			    "dijit.form.NumberSpinner",
			    "dijit.Toolbar",
			    "dijit.Tree", 
			    "dijit.TitlePane",
			    "dojox.grid.DataGrid",
			    "dojox.form.FileInput",
				"dojox.form.Uploader",
				"dojox.form.uploader.FileList",
			    "dojox.form.PasswordValidator",
			    "dojo.store.DataStore",
			    "dojo.dnd.Container",
			    "dojo.dnd.Manager",
			    "dojo.dnd.Source"
			]
		}
	],

	prefixes: [
	    [ "dojo",  "../../dojo" ],
		[ "dijit", "../dijit" ],
		[ "dojox", "../dojox" ]
	]
}
