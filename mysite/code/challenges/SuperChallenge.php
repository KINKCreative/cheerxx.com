<?php

class SuperChallenge extends DataObject {
	
	public $URLPrefix = 'challenges';
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'ContentUpcoming' => 'HTMLText',
		'ContentActive' => 'HTMLText',
		'ContentClosed' => 'HTMLText',
		'Published' => 'Boolean',
		'Featured' => 'Boolean',
		'VideoEmbed' => 'Text',
		'StartTime' => 'SS_Datetime',
		'EndTime' => 'SS_Datetime',
		'Hashtag' => 'Varchar(64)'
	);
	
//	private static $has_one = array (
//		'Image' => 'Image'
//	);
	
	private static $has_many = array(
		'Images' => 'SuperChallengeImage',
		'Challenges' => 'Challenge'
	);
	
	function getCMSFields() { 
		$fields = parent::getCMSFields();
	    
	    $gridFieldConfig = GridFieldConfig_RecordEditor::create(); 
	    $gridFieldConfig->addComponent(new GridFieldBulkManager());
	    $gridFieldConfig->addComponent(new GridFieldBulkImageUpload());   
	    $gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));    
	    
	    $photoManager = new GridField("Images", "Images", $this->Images()->sort("SortOrder"), $gridFieldConfig);
	    
	    
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
		
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create("Content","Default description (always visible)")->setRows(8), "VideoEmbed");
		$fields->addFieldToTab('Root.Views', HTMLEditorField::create("ContentUpcoming","Text before challenge is live")->setRows(8));
		$fields->addFieldToTab('Root.Views', HTMLEditorField::create("ContentActive","Text when challenge is active")->setRows(8));
		$fields->addFieldToTab('Root.Views', HTMLEditorField::create("ContentClosed","Text when challenge is closed")->setRows(8));	      
		
	    return $fields;
	}	      
	      		
//	function canDelete($member = NULL) { 
//		return Permission::check('CMS_ACCESS_CMSMain'); 
//	}
//	function canCreate($member = NULL) { 
//		return Permission::check('CMS_ACCESS_CMSMain'); 
//	}
//	function canEdit($member = NULL) { 
//		return Permission::check('CMS_ACCESS_CMSMain'); 
//	}

	
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
		return "competitions/".$this->URLSegment;
	}
	
	function Status() {
		$now = SS_Datetime::now();
		$startTime = $this->StartTime;
		$endTime = $this->EndTime;
		if($now < $startTime) {
			return 1;
		} else if (($startTime < $now) && ($startTime < $endTime)) {
			return 2;
		}
		else return 3;
	}

}



?>