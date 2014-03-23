<?php

class CoachingResponseEntry extends DataObject {
	
	private static $db = array(
		'Text' => 'HtmlText'
	);
	private static $has_one = array(
		'CoachingCategorySubmission' => 'CoachingCategorySubmission',
		'Image' => 'Image'
	);

}