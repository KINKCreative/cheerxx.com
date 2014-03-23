<?php

	class ProfileImage extends DataExtension {
		private static $has_one = array(
			"RecruitingProfile" => "RecruitingProfile"
		);
		
		function canCreate($member=NULL) {
			return true;
		}
		
		function canEdit($member=NULL) {
			return Permission::check("ADMIN");
		}
		
		function canDelete($member=NULL) {
			return Permission::check("ADMIN");
		}
	}