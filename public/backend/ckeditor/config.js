/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = "/ott/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files";
    config.filebrowserImageBrowseUrl = "/ott/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images";
    config.filebrowserFlashBrowseUrl = "/ott/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash";
    config.filebrowserUploadUrl = "/ott/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files";
    config.filebrowserImageUploadUrl = "/ott/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images";
    config.filebrowserFlashUploadUrl = "/ott/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash";
};
