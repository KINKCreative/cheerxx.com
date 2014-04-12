<?php

class RecruitingProfile extends DataObject {

	private static $db = array(
		"FirstName" => "Varchar(64)",
		"LastName" => "Varchar(64)",
		"SubscriptionDate" => "SS_DateTime",
		"Hometown" => "Varchar(64)",

		"School" => "Varchar(64)",
		"State" => "Varchar(2)",

		"ShowPartnerStuntSkills" => "Boolean",
		"ShowGroupStuntSkills" => "Boolean",
		"ShowStandingTumblingSkills" => "Boolean",
		"ShowRunningTumblingSkills" => "Boolean",
		"ShowBasketTossSkills" => "Boolean",
		
		"OtherPartnerStuntSkills" => "Text",
		"OtherGroupStuntSkills" => "Text",
		"OtherStandingTumblingSkills" => "Text",
		"OtherRunningTumblingSkills" => "Text",
		"OtherBasketTossSkills" => "Text",

		"IsFlyer" => "Boolean",
		"IsBase" => "Boolean",
		
		"Gender" => "Enum(',Boy,Girl','')",
		
		"TypeInterested" => "Enum(',Co-ed,All-girl,All-star','')",
		
		"CollegesInterested" => "Text",
		"ProfileText" => "Text",
		"OtherSkillsText" => "Text",
		"URLSegment" => "Varchar(255)"
	);

	private static $has_one = array(
		"Member" => "Member"
//		"ProfileImage" => "ProfileImage"
	);
	
	private static $has_many = array(
		"Images" => "Image"
	);
	
	private static $many_many = array(
		"Skills" => "Skill"
	);
	
	private static $indexes = array(
		"URLSegment" => true
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.Images", new UploadField("Images","Upload images"));
		
		$groupedSkillList = new GroupedList(Skill::get()); 
    	$grouped = $groupedSkillList->GroupedBy("CategoryID","Skills")->sort(array("CategoryID"=>"ASC", "SortOrder" => "ASC")); //,"Skills");
    	
    	$c=0;
//    	$fields->addFieldToTab("Root.YourSkills", new HeaderField("Skillsheader", "Skill categories",4));
		$fields->removeByName("Skills");
    	foreach($grouped as $skillset) {
    		//$fields->add(new HeaderField("Header", $skillset->Skills->first()->Category()->Title,4));
    		$idlist = $this->Skills()->getIDList();
    		$tempfield = new CheckboxSetfield("Skills_".$c++,$skillset->Skills->first()->Category()->Title,$skillset->Skills->toArray());
    		$tempfield->setValue($idlist);
    		$fields->addFieldToTab("Root.Skills",$tempfield);
    	}
    	$fields->addFieldToTab("Root.Main",
	    	new DropdownField(
	    	  'TypeInterested',
	    	  'TypeInterested',
	    	  singleton('RecruitingProfile')->dbObject('TypeInterested')->enumValues(),
	    	  $this->TypeInterested
	    	),
	    	"CollegesInterested"
	    );
		return $fields;
	}
	
	function getURLPrefix() {
		return "recruiting";
	}
	
	public function GroupedSkills() {
		$skills = new ArrayList();

		$allSkills = Skill::get();
		$mySkills = $this->Skills();
		$mySkillIds = $mySkills->getIDList();
		
		$customSkills = new ArrayList();
		foreach($allSkills as $s) {
			if(in_array($s->ID,$mySkillIds)) {
				$s->Active = 1;
			}
			$customSkills->push($s);
		}
		
		if($this->Gender=="Male") {
			$mySkills->removeByFilter("CategoryID IN (5,6)");
		}
		if(!$this->IsFlyer) {
			$mySkills->removeByFilter("CategoryID = 5");
		}
		
		$groupedSkillList = new GroupedList($customSkills);
		$grouped = $groupedSkillList->GroupedBy("CategoryID","Skills")->sort(array("CategoryID"=>"ASC", "SortOrder" => "ASC"));
		
		return $grouped;
	}
	
	function Link() {
		return "recruiting/profile/".$this->URLSegment;
	}
	function AbsoluteLink() {
		return "http://www.cheerxx.com/".$this->Link();
	}
	
	public static $singular_name = "Profile";
	public static $plural_name = "Profiles";

//	function getTitle() {
//		return $this->getName();
//	}
	
//	function getName() {
//		if($this->Member()) {
//			return $this->Member()->getName();
//		}
//	}
//
//	public function EditForm() {
//						
//			Requirements::javascript("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js");
//			Requirements::javascript("mysite/js/screwdefaultbuttons/js/jquery.screwdefaultbuttonsV2.min.js");
//			Requirements::customScript('
//				$(document).ready(function() {
//					$("form").validate({
//					    rules: {
//					        recaptcha_response_field: {
//					            required: true
//					        }
//					    },
//					    messages: {
//					        recaptcha_response_field: {
//					            required: "*",
//					            remote: "Invalid captcha"
//					        }
//					    }
//					});
//					$(":radio").screwDefaultButtons({
//				        image: \'url("themes/'.SSViewer::current_theme().'/img/radio.png")\',
//				        width: 40,
//				        height: 40
//				    });
//				    $( ".radio" )
//				      .click(function () {
//				        n = $("input:checked").length;
//				        perc = Math.round((n/5)*100);
//				        $(".progress-bar").css("width",perc+"%");
//				      });
//			    });
//			'); 
//		$form = new ProfileEditForm(Controller::curr(),"ProfileEditForm",$this);
//		return $form;
//		
//	}
	
	public function getHasActiveSubscription() {
//		$this->obj('SubscriptionDate')->
		if(!isset($this->SubscriptionDate)) { 
			return false;
		}
//		$date = $this->SubscriptionDate;
//		echo(strtotime("now"));
//		echo(".".strtotime($date));

		$date = new DateTime($this->SubscriptionDate);
		$date->modify('+1 year');
//		echo(strtotime($date->format('Y-m-d h:m')));

		if(strtotime("now") > strtotime($date->format('Y-m-d h:m'))){
		   return false;
		} else {
		   return true;
		}
	}
		
	function getTitle() {
		return $this->FirstName." ".$this->LastName; //." (".$this->ID.")";
	}
	
	function onBeforeWrite() {
		$skills = array();
    	for($i=0;$i<6;$i++) {
    		$name = "Skills_".$i;
    		if($this->getField($name)) {
    			$value = $this->getField($name);
    			$temp = explode(",",$value);
	    		$skills = array_merge($skills,$temp);
	    	}
    	}
		$profileSkills = $this->Skills();
		$profileSkills->setByIDList($skills);
		parent::onBeforeWrite();
	}	
	
}