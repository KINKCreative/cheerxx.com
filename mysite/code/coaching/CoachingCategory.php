<?php

class CoachingCategory extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'Text',
		'Price' => 'Currency'
	);
	
	private static $has_one = array(
		'Image' => 'Image'
	);
	
	public function CentPrice() {
		return ((int)$this->Price)*100;
	}
	
	function IsPayable() {
		return ($this->Price > 0);
	}
	
	function DetailTitle() {
		return "CheerXX - Online coaching - ".$this->Title." (#".$this->ID.")";
	}
	
}