<?php

class CoachingCategorySubmission extends Video {
	
	private static $db = array(
	);
	
	private static $has_one = array(
		'Target' => 'CoachingCategory'
	);
}