//>>built
require({cache:{"url:dijit/form/templates/ComboButton.html":"<table class=\"dijit dijitReset dijitInline dijitLeft\"\r\n\tcellspacing='0' cellpadding='0' role=\"presentation\"\r\n\t><tbody role=\"presentation\"><tr role=\"presentation\"\r\n\t\t><td class=\"dijitReset dijitStretch dijitButtonNode\" data-dojo-attach-point=\"buttonNode\" data-dojo-attach-event=\"ondijitclick:_onClick,onkeypress:_onButtonKeyPress\"\r\n\t\t><div id=\"${id}_button\" class=\"dijitReset dijitButtonContents\"\r\n\t\t\tdata-dojo-attach-point=\"titleNode\"\r\n\t\t\trole=\"button\" aria-labelledby=\"${id}_label\"\r\n\t\t\t><div class=\"dijitReset dijitInline dijitIcon\" data-dojo-attach-point=\"iconNode\" role=\"presentation\"></div\r\n\t\t\t><div class=\"dijitReset dijitInline dijitButtonText\" id=\"${id}_label\" data-dojo-attach-point=\"containerNode\" role=\"presentation\"></div\r\n\t\t></div\r\n\t\t></td\r\n\t\t><td id=\"${id}_arrow\" class='dijitReset dijitRight dijitButtonNode dijitArrowButton'\r\n\t\t\tdata-dojo-attach-point=\"_popupStateNode,focusNode,_buttonNode\"\r\n\t\t\tdata-dojo-attach-event=\"onkeypress:_onArrowKeyPress\"\r\n\t\t\ttitle=\"${optionsTitle}\"\r\n\t\t\trole=\"button\" aria-haspopup=\"true\"\r\n\t\t\t><div class=\"dijitReset dijitArrowButtonInner\" role=\"presentation\"></div\r\n\t\t\t><div class=\"dijitReset dijitArrowButtonChar\" role=\"presentation\">&#9660;</div\r\n\t\t></td\r\n\t\t><td style=\"display:none !important;\"\r\n\t\t\t><input ${!nameAttrSetting} type=\"${type}\" value=\"${value}\" data-dojo-attach-point=\"valueNode\"\r\n\t\t/></td></tr></tbody\r\n></table>\r\n"}});define("dijit/form/ComboButton",["dojo/_base/declare","dojo/_base/event","dojo/keys","../focus","./DropDownButton","dojo/text!./templates/ComboButton.html"],function(_1,_2,_3,_4,_5,_6){return _1("dijit.form.ComboButton",_5,{templateString:_6,_setIdAttr:"",_setTabIndexAttr:["focusNode","titleNode"],_setTitleAttr:"titleNode",optionsTitle:"",baseClass:"dijitComboButton",cssStateNodes:{"buttonNode":"dijitButtonNode","titleNode":"dijitButtonContents","_popupStateNode":"dijitDownArrowButton"},_focusedNode:null,_onButtonKeyPress:function(_7){if(_7.charOrCode==_3[this.isLeftToRight()?"RIGHT_ARROW":"LEFT_ARROW"]){_4.focus(this._popupStateNode);_2.stop(_7);}},_onArrowKeyPress:function(_8){if(_8.charOrCode==_3[this.isLeftToRight()?"LEFT_ARROW":"RIGHT_ARROW"]){_4.focus(this.titleNode);_2.stop(_8);}},focus:function(_9){if(!this.disabled){_4.focus(_9=="start"?this.titleNode:this._popupStateNode);}}});});