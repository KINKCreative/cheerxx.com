<?php

class SubmissionScore extends DataObject {

	private static $db = array(
		"PartialScore" => "Int"
	);
	
	private static $has_one = array(
		"ScoreCategory" => "ScoreCategory",
		"ChallengeSubmission" => "ChallengeSubmission"
	);

}	
