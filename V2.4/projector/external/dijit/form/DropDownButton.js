//>>built
require({cache:{"url:dijit/form/templates/DropDownButton.html":"<span class=\"dijit dijitReset dijitInline\"\r\n\t><span class='dijitReset dijitInline dijitButtonNode'\r\n\t\tdata-dojo-attach-event=\"ondijitclick:_onClick\" data-dojo-attach-point=\"_buttonNode\"\r\n\t\t><span class=\"dijitReset dijitStretch dijitButtonContents\"\r\n\t\t\tdata-dojo-attach-point=\"focusNode,titleNode,_arrowWrapperNode\"\r\n\t\t\trole=\"button\" aria-haspopup=\"true\" aria-labelledby=\"${id}_label\"\r\n\t\t\t><span class=\"dijitReset dijitInline dijitIcon\"\r\n\t\t\t\tdata-dojo-attach-point=\"iconNode\"\r\n\t\t\t></span\r\n\t\t\t><span class=\"dijitReset dijitInline dijitButtonText\"\r\n\t\t\t\tdata-dojo-attach-point=\"containerNode,_popupStateNode\"\r\n\t\t\t\tid=\"${id}_label\"\r\n\t\t\t></span\r\n\t\t\t><span class=\"dijitReset dijitInline dijitArrowButtonInner\"></span\r\n\t\t\t><span class=\"dijitReset dijitInline dijitArrowButtonChar\">&#9660;</span\r\n\t\t></span\r\n\t></span\r\n\t><input ${!nameAttrSetting} type=\"${type}\" value=\"${value}\" class=\"dijitOffScreen\" tabIndex=\"-1\"\r\n\t\tdata-dojo-attach-point=\"valueNode\"\r\n/></span>\r\n"}});define("dijit/form/DropDownButton",["dojo/_base/declare","dojo/_base/lang","dojo/query","../registry","../popup","./Button","../_Container","../_HasDropDown","dojo/text!./templates/DropDownButton.html"],function(_1,_2,_3,_4,_5,_6,_7,_8,_9){return _1("dijit.form.DropDownButton",[_6,_7,_8],{baseClass:"dijitDropDownButton",templateString:_9,_fillContent:function(){if(this.srcNodeRef){var _a=_3("*",this.srcNodeRef);this.inherited(arguments,[_a[0]]);this.dropDownContainer=this.srcNodeRef;}},startup:function(){if(this._started){return;}if(!this.dropDown&&this.dropDownContainer){var _b=_3("[widgetId]",this.dropDownContainer)[0];this.dropDown=_4.byNode(_b);delete this.dropDownContainer;}if(this.dropDown){_5.hide(this.dropDown);}this.inherited(arguments);},isLoaded:function(){var _c=this.dropDown;return (!!_c&&(!_c.href||_c.isLoaded));},loadDropDown:function(_d){var _e=this.dropDown;var _f=_e.on("load",_2.hitch(this,function(){_f.remove();_d();}));_e.refresh();},isFocusable:function(){return this.inherited(arguments)&&!this._mouseDown;}});});