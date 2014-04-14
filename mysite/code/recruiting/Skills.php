<?php

class SkillCategory  extends DataObject {
	
	private static $db = array(
		"Title" => "Varchar(255)",
		"MethodClassName" => "Varchar(255)",
	);
	
	private static $has_many = array(
		"Skills" => "Skill"
	);
	
//	function onBeforeWrite() {
//		$this->MethodClassName = implode(explode($this->Title," "));
//		parent::onBeforeWrite();
//	}	
}

class Skill  extends DataObject {
	
	private static $db = array(
		"Title" => "Varchar(255)",
		"SortOrder" => "Int"
	);
	
	private static $has_one = array(
		"Category" => "SkillCategory"
	);
	
	private static $default_sort = "SortOrder ASC, Title ASC";
	
	public static $summary_fields = array(
		"Title",
		"CategoryID"
	);
	
	private static $belongs_many_many = array(
		"RecruitingProfiles" => "RecruitingProfile"
	);
	
	function onAfterWrite() {
		parent::onAfterWrite();
		if($this->CategoryID && !$this->SortOrder) {
			$max = Skill::get()->where("CategoryID = ".$this->CategoryID)->Max("SortOrder");
			$this->SortOrder = $max + 1;
			$this->write();
		}
	}
	
}