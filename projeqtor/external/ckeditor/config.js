/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
  config.toolbar = [
    
    { name: 'basicstyles', items: [ 'RemoveFormat', '-', 'Bold', 'Italic', 'Underline'] },
    { name: 'paragraph', items: [ 'Indent', 'Outdent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','-','NumberedList', 'BulletedList'] },
    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    { name: 'tools', items: [ 'Maximize', 'Print' ] },
    { name: 'styles', items: [ 'Font', 'FontSize' ] },
    { name: 'links', items: [ 'Link', 'Unlink', 'Image','Table','SpecialChar','PasteFromWord'] }
  ];
};
/*
CKEDITOR.editorConfig = function( config ) {
config.toolbarGroups = [
  { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
  { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
  { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
  { name: 'forms', groups: [ 'forms' ] },
  { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
  { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
  { name: 'links', groups: [ 'links' ] },
  { name: 'insert', groups: [ 'insert' ] },
  { name: 'styles', groups: [ 'styles' ] },
  { name: 'colors', groups: [ 'colors' ] },
  { name: 'tools', groups: [ 'tools' ] },
  { name: 'others', groups: [ 'others' ] },
  { name: 'about', groups: [ 'about' ] }
];

config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,Smiley,PageBreak,Iframe,Styles,Format,ShowBlocks,About';
};
*/