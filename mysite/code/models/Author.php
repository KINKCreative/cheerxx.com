<?php

class Author extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar(64)',
		'Twitter' => 'Varchar(255)',
		'Facebook' => 'Varchar(255)',
		'Website' => 'Varchar(255)'
	);
			
	function canDelete($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	
	function canCreate($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	function canEdit($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}		
		
}