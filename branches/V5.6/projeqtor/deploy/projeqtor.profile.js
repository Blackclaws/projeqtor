dependencies = {
	//Strip all console.* calls except console.warn and console.error. This is basically a work-around
	//for trac issue: http://bugs.dojotoolkit.org/ticket/6849 where Safari 3's console.debug seems
	//to be flaky to set up (apparently fixed in a webkit nightly).
	//But in general for a build, console.warn/error should be the only things to survive anyway.
	stripConsole: "normal",

	layers: [
		{
			name: "projeqtorDojo.js",
			dependencies: [
				"dojo.data.ItemFileWriteStore",
			    "dojo.date",
			    "dojo.date.locale",
			    "dojo.dnd.Container",
			    "dojo.dnd.Manager",
			    "dojo.dnd.Source",
			    "dojo.dom-construct",
			    "dojo.dom-geometry",
			    "dojo.i18n",
			    "dojo.parser",
			    "dojo.store.DataStore",			    
			    "dijit.ColorPalette",
			    "dijit.Dialog", 
			    "dijit.Editor",
			    "dijit._editor.plugins.AlwaysShowToolbar",
			    "dijit._editor.plugins.FullScreen",
			    "dijit._editor.plugins.FontChoice",
			    "dijit._editor.plugins.TextColor",
			    "dijit.form.Button",
			    "dijit.form.CheckBox",
			    "dijit.form.ComboBox",
			    "dijit.form.DateTextBox",
			    "dijit.form.FilteringSelect",
			    "dijit.form.Form",
			    "dijit.form.MultiSelect",
			    "dijit.form.NumberSpinner",
			    "dijit.form.NumberTextBox",
			    "dijit.form.RadioButton",
			    "dijit.form.Textarea",
			    "dijit.form.TextBox",
			    "dijit.form.TimeTextBox",
			    "dijit.form.ValidationTextBox",
			    "dijit.InlineEditBox",
			    "dijit.layout.AccordionContainer",
			    "dijit.layout.BorderContainer",
			    "dijit.layout.ContentPane",
			    "dijit.Menu", 
			    "dijit.MenuBar",
			    "dijit.MenuBarItem",
			    "dijit.PopupMenuBarItem",
			    "dijit.ProgressBar",
			    "dijit.TitlePane",
			    "dijit.Toolbar",
			    "dijit.Tooltip",		    
			    "dijit.Tree", 
			    "dojox.form.FileInput",
  				"dojox.form.Uploader",
  				"dojox.form.uploader.plugins.IFrame",
  				"dojox.form.uploader.plugins.Flash",
  				"dojox.form.uploader.FileList",
  				"dojox.fx.scroll",
  				"dojox.fx",
			    "dojox.grid.DataGrid",
			    "dojox.image.Lightbox",
			    "dojox.form.PasswordValidator"
			]
		}
	],

	prefixes: [
	  [ "dojo",  "../../dojo" ],
		[ "dijit", "../dijit" ],
		[ "dojox", "../dojox" ]
	]
}
