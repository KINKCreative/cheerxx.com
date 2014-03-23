<?php

class PageImage extends Image {
	
	private static $db = array(
		'Caption' => 'Varchar(255)',
		'Link' => 'Varchar(255)'
	);
	
	private static $has_one = array (
		'Page' => 'Page'
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
	
	function Link() {
		if($this->Link) {
			return $this->Link;
		}
		else {
			return $this->Page()->AbsoluteLink();
		}
	}
	function getTitle() {
		return $this->Page()->Title;
	}
}



?>