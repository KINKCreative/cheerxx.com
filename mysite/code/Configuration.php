<?php
class ManageAdmin extends ModelAdmin {
	
	static $url_segment = 'manage';
	
	static $menu_title = 'Manage';
	
	static $managed_models = array(
		'Article',
		'Author',
		'Tip',
		'StaffProfile'
	);
		
	public $showImportForm = false;
	
	function SearchClassSelector(){
		return "dropdown";
	}
	
}

//class TipAdmin extends ModelAdmin {
//	
//	static $url_segment = 'tips';
//	
//	static $menu_title = 'Tips';
//	
//	static $managed_models = array(
//		'Tip'
//	);
//		
//	public $showImportForm = true;
//	
//	function SearchClassSelector(){
//		return "dropdown";
//	}
//	
//}

class CoachingAdmin extends ModelAdmin {
	
	static $url_segment = 'coaching';
	
	static $menu_title = 'Coaching';
	
	static $managed_models = array(
		'CoachingCategorySubmission',
		'CoachingCategory'
	);
		
	public $showImportForm = true;
	
}


class VideoAdmin extends ModelAdmin {
	
	static $url_segment = 'videos';
	
	static $menu_title = 'Videos';
	
	static $managed_models = array(
		'Video'
	);
		
	public $showImportForm = false;
		
}

class ChallengeAdmin extends ModelAdmin {
	
	static $url_segment = 'Challenges';
	
	static $menu_title = 'Challenges';
	
	static $managed_models = array(
		'Challenge',
		'SuperChallenge',
		'ChallengeCategory'
	);
		
	public $showImportForm = false;
	
//	function SearchClassSelector(){
//		return "dropdown";
//	}
	
}

class SubmissionAdmin extends ModelAdmin {
	
	static $url_segment = 'submissions';
	
	static $menu_title = 'Submissions';
	
	static $managed_models = array(
		'ChallengeSubmission',
		'CoachingCategorySubmission'
	);
		
	public $showImportForm = false;
	
}

class RecruitingAdmin extends ModelAdmin {
	
	static $url_segment = 'recruiting';
	
	static $menu_title = 'Recruiting';
	
	static $managed_models = array(
		'RecruitingProfile',
		'Skill',
		'SkillCategory'
	);
		
	//public $showImportForm = false;
	
}