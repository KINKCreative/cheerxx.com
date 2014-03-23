<?php

class StaffProfile extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'JobPosition' => 'Varchar(125)',
		'Text' => 'Text',
		'VideoEmbed' => 'Text'
	);
	
	private static $has_one = array (
		'ProfilePage' => 'ProfilePage',
		'Image' => 'Image'
	);
	
	/* private static $default_sort = "Created ASC"; */
		
/*	function getCMSFields() {

		$myField = new UploadField('Image','Select image');
		$myField->setFolderName("images/profiles");
		
		return new FieldList(
			new TextField('Title'),
			new TextField('JobPosition'),
			new TextareaField('Text'),
			new TextareaField('VideoEmbed'),
			$myField
		);
	} */
			
	/* function canDelete($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	function canCreate($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	function canEdit($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	} */

}