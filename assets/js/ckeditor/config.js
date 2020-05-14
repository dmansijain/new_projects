/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	//config.extraPlugins = 'imageuploader';
	config.skin = 'icy_orange';
	
	
	config.toolbar =
    [
        ['Source'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        ['Undo','Redo','-','SelectAll','RemoveFormat'],
        '/',
        ['Bold','Italic','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        ['Image','Table','SpecialChar'],
        '/',
        ['Styles','Format','FontSize'],
        ['TextColor'],
        ['Maximize', 'ShowBlocks','iframe']
    ];
	
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
