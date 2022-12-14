/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
var token = $('meta[name="csrf-token"]').attr('content');
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';
	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';
	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

    config.filebrowserBrowseUrl = BASE_URL+'library/ckfinder/ckfinder.html';
	// config.filebrowserImageBrowseUrl = BASE_URL+'library/kcfinder-3.12/browse.php?opener=ckeditor&type=images&dir=images/public&_token='+token;
	// config.filebrowserFlashBrowseUrl = BASE_URL+'library/kcfinder-3.12/browse.php?opener=ckeditor&type=flash&_token='+token;
	config.filebrowserUploadUrl = BASE_URL+'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&_token='+token;
	// config.filebrowserImageUploadUrl = BASE_URL+'library/kcfinder-3.12/upload.php?opener=ckeditor&type=images&_token='+token;
	// config.filebrowserFlashUploadUrl = BASE_URL+'library/kcfinder-3.12/upload.php?opener=ckeditor&type=flash&_token='+token;
};
