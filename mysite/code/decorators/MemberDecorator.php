<?php

class MemberExtend extends DataExtension { 
	private static $db = array(
		'Username' => "Varchar(32)",
		'StripeUserID' => "Varchar(32)",
		"Gender" => "Enum(',Boy,Girl','')"
	);
	private static $many_many = array(
		'Likes' => 'Video'
//		'Favorites' => 'Video'
	);
	
	private static $belongs_many_many = array(
		'Favorites' => 'Video'
//		'Favorites' => 'Video'
	);
		
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab("Root.Main", new TextField('Username', 'Username', $this->owner->Username), "Email"); 
//		if(Permission::checkMember($this->owner->ID, "VIEW_FORUM")) {
		  // Edit the FieldList passed, adding or removing fields as necessary
//		}
		$fields->removeByName("Root.Likes");
		$fields->removeByName("Root.Favorites");
	}
	/* public function Name() {
		if($this->owner->Username) {
			return $this->owner->Username;
		}
		else {
			return $this->owner->getName();
		}
	} */
}
