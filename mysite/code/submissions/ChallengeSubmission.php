<?php

class ChallengeSubmission extends Video {
	
	private static $db = array(
		'PointScore' => 'Int',
		'LikeScore' => 'Int',
		'TotalScore' => 'Int'
	);
	
	private static $has_one = array(
		'Target' => 'Challenge'
	);
	
	private static $has_many = array(
		'SubmissionScores' => 'SubmissionScore'
	);
	
	private static $indexes = array(
		'TotalScore' => true,
		'TargetID' => true
	);
	
	private static $default_sort = "TotalScore DESC"; 
	
	public function IsScored() {
		if($this->SubmissionScores()->count() > 0) {
			return true;
		}
	}
	
	public function calculateLikeScore() {
		$likes = $this->LikeTotal;
		$maxLikePoints = $this->Target()->ChallengeCategory()->LikesWeight;
		
		$maxLikes = 100;
		
		if($likes > $maxLikes) {
			$likes = $maxLikes;
		}
		
		$score = ceil($likes * $maxLikePoints / $maxLikes);
		return $score;
	}
	
	public function calculateTotalScore() {
	
		$score = $this->SubmissionScores()->sum("PartialScore");
		return $score;
		
	}	
	
	public function onBeforeWrite() {
		$this->PointScore = $this->calculateTotalScore();
		$this->LikeScore = $this->calculateLikeScore();
		$this->TotalScore = $this->PointScore + $this->LikeScore;
		
		parent::onBeforeWrite();
	}
		

}