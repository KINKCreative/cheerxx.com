<?php

class ChallengeCategory extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Rules' => 'HTMLText',
		'LikesWeight' => 'Int',
		'MaxScore' => 'Int',
		'TotalScore' => 'Int'
	);
	
	private static $has_many = array (
		'Challenges' => 'Challenge',
		'ScoreCategories' => 'ScoreCategory'
	);
	
	private static $defaults = array(
		'LikesWeight' => 50
	);
	
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.ScoreCategories",new ReadonlyField("MaxScore","Max score from points"));
		$fields->addFieldToTab("Root.ScoreCategories",new NumericField("LikesWeight","Max score for Likes"));
		$fields->addFieldToTab("Root.ScoreCategories",new ReadonlyField("TotalScore","TotalScore"));
		$fields->removeByName("Challenges");
		//do we define max value of likes required for this score? E.g. 100
		$fields->addFieldToTab("Root.ScoreCategories",new CheckboxField("LikesPercentage","Check here to calculate percentage of Max Score as value of Likes (this will save the calculated number of points)"));
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
	
	function calculateMaxScore() {
		if($this->ScoreCategories()) {
			$score = $this->ScoreCategories()->sum("MaxPoints");
			return $score;
		}
	}
	
	function onBeforeWrite() {
		parent::onBeforeWrite();
		
		$this->MaxScore = $this->calculateMaxScore();
		if($this->LikesPercentage == 1) {
			$percentage = $this->LikesWeight;
			$this->LikesPercentage = 0;
			$multiplier = $percentage/100;
			$score = $this->MaxSccore*$multiplier;
			$this->LikesWeight = floor($this->MaxScore*$multiplier);
		}
		
		$this->TotalScore = $this->MaxScore + $this->LikesWeight;
		
	}
	
}



?>