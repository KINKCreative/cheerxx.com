<?php

class SuperChallengeImage extends DataObject {
	
	private static $db = array(
			'Title' => 'Varchar(255)'
		);
		
		private static $has_one = array (
			'SuperChallenge' => 'SuperChallenge',
			'Image' => 'Image'
		);
			
		function getCMSFields() {
			$fields = parent::getCMSFields();
			$fields->removeByName("SuperChallengeID");
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
		
	//	function SmallView() {
	//		return $this->renderWith('HasManyObject_small');
	//	}
	//	
	//	function forTemplate() {
	//		return $this->renderWith('PageImage');
	//	}
	//	function LeadingImageURL() {
	//		if($this->Image()) {
	//			if( $this->Image()->getWidth()==1280 && $this->Image()->getHeight()==408 ) {
	//				return $this->Image()->URL;	
	//			}
	//			else {
	//				return $this->Image()->CroppedImage(1280,408)->URL;	
	//			}
//			}
//		}
//		function Link() {
//			return $this->SuperChallenge()->Link();
//		}
//		
	}
