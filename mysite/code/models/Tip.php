<?php

class Tip extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(64)',
		'Content' => 'Text',
		'From' => 'Varchar(64)'
	);
	
	private static $has_one = array (
	);
	
	private static $defaults = array(
		"From" => "Matej Kavcnik"
	);
	
	function getCMSFields_forPopup() {

		$myField = new ImageUploadField('Image','Select image');
		$myField->setUploadFolder("images/posts");
		return new FieldSet(
			new TextField('Title'),
			new TextareaField('Content'),
			new TextField('From')
		);
	}
		
	function canDelete($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	function canCreate($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	function canEdit($member = NULL) { 
		return Permission::check('CMS_ACCESS_CMSMain'); 
	}
	/*	
	public function Landscape()
	{
		return $this->File()->getWidth() > $this->File()->getHeight();
	}
	
	public function Portrait()
	{
		return $this->File()->getWidth() < $this->File()->getHeight();
	}
	
	public function Large()
	{
		if($this->Landscape())
			return $this->File()->SetWidth(740);
		else {
			return $this->File()->CroppedFromTopImage(740,450);
		}
	}
	*/
	
//	function Link() {
//		return $this->Article()->Link();
//	}
//	
//	public function RandColSize() {
//		return rand(2,3);
//	}
//	function getTitle() {
//		return $this->Article()->Title;
//	}
	
}



?>