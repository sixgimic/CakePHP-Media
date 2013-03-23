/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
	config.extraPlugins = 'grafikart';
	// Define changes to default configuration here. For example:
	config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.height = 500;
		
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },	
		{ name: 'links' },
		{ name: 'others' },
	];

};