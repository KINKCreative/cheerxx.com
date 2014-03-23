<?php

class Challenge extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'DisplayTitle' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Published' => 'Boolean',
		'Featured' => 'Boolean',
		'VideoEmbed' => 'Text',
		'StartTime' => 'SS_Datetime',
		'EndTime' => 'SS_Datetime',
		'Price' => 'Currency'
	);
	
	private static $has_many = array (
		'Images' => 'ChallengeImage',
		'Submissions' => 'ChallengeSubmission'
	);
	
	private static $has_one = array(
		'ChallengeCategory' => 'ChallengeCategory',
		'SuperChallenge' => 'SuperChallenge'
	);
	
	function getCMSFields() { 
	    $fields = parent::getCMSFields();
	    $fields->addFieldToTab("Root.Main", new TextField("DisplayTitle"), "Title");
	    $fields->addFieldToTab("Root.Main", new CurrencyField("Price"));
	
	      $STField = DatetimeField::create('StartTime', 'Begin'); //->setConfig('datavalueformat', 'YYYY-MM-dd HH:mm');;
	      $ETField = DatetimeField::create('EndTime', 'End'); //->setConfig('datavalueformat', 'YYYY-MM-dd HH:mm');;
	      
	      $STField->getDateField()->setConfig('showcalendar',1);
	      $STField->getTimeField()->setConfig('timeformat', 'HH:mm');
	      $ETField->getDateField()->setConfig('showcalendar',1);
	      $ETField->getTimeField()->setConfig('timeformat', 'HH:mm');
	      
	      if(!$this->ID) {
	      	$STField->getDateField()->setValue(strftime("%m/%d/%G",strtotime("Next Sunday")));
	      	$STField->getTimeField()->setValue("8pm");
	      	$ETField->setValue(strftime("%m/%d/%G",strtotime("+2 Weeks Sunday")));
	      	$ETField->getTimeField()->setValue("8pm");
	      }
	      	
	      $fields->addFieldToTab('Root.Main', $STField, "Content");
	      $fields->addFieldToTab('Root.Main', $ETField, "Content");
		
		$gridFieldConfig = GridFieldConfig_RecordEditor::create(); 
		$gridFieldConfig->addComponent(new GridFieldBulkManager());
		$gridFieldConfig->addComponent(new GridFieldBulkImageUpload());   
		$gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));    
		
		$photoManager = new GridField("Images", "Images", $this->Images()->sort("SortOrder"), $gridFieldConfig);
	      
	      return $fields;
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
	
	function getURLPrefix() {
		return "challenges/".$this->SuperChallenge()->URLSegment."/".$this->URLSegment;
	}
	
	function Link() {
		return "competitions/".$this->SuperChallenge()->URLSegment."/challenge/".$this->URLSegment;
	}
	
	function FirstImage() {
		if($this->Images()->Count() > 0) {
			return $this->Images()->First();
		}
		else {
			if($this->SuperChallenge()->Images()->Count() > 0) {
				return $this->SuperChallenge()->Images()->First();
			}
		}
	}
	
	function onBeforeWrite() {
		if(!$this->ChallengeCategoryID) {
			user_error('You must assign the Challenge Category to this challenge.', E_USER_ERROR);
			return false;
		}
		else {
			parent::onBeforeWrite();
		}
	}
	
	
	function canSubmit() {
		$memberID = Member::currentUserID();
		if(!$memberID) {
			return false;
		}
		$s = $this->Submissions()->where("MemberID = $memberID")->first();
		if($s) {
			return false;
		}
		else {
			return true;
		}
	}
	
	function getUserSubmission() {
		$memberID = Member::currentUserID();
		if(!$memberID) {
			return false;
		}
		$s = $this->Submissions()->where("MemberID = $memberID")->first();
		if($s) {
			return $s;
		}
	}
	
	function showDisplayTitle() {
		if($this->DisplayTitle !="") {
			return $this->DisplayTitle;
		}
		else {
			return $this->Title;
		}
	}
	
	function getRecentSubmissions() {
		return $this->Submissions()->sort("Created DESC");
	}
	
	function getAdminSubmissions() {
		return $this->Submissions()->sort("PointScore ASC");
	}
	
	function IsPayable() {
		return ($this->Price > 0);
	}
	
	function DetailTitle() {
		return "CheerXX Challenge - ".$this->Title." (#".$this->ID.")";
	}
	
	function MaxPoints() {
		return $this->ChallengeCategory()->MaxPoints();
	}

}



?>