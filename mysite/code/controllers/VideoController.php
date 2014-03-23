<?php


class VideoController extends Page_Controller implements PermissionProvider {

	protected $video;

	private static $allowed_actions = array (
		'index',
		'upload',
		'view',
		'ScoringForm'
	);
	
	public static $url_handlers = array(
		'ScoringForm' => 'ScoringForm',
	    '//$URLSegment!' => 'view'
	);
	
	const URLSegment = 'v';
	
	public function getURLSegment() { 
		return self::URLSegment;
	}
	
	public function providePermissions() {
	    return array(
	      "SCORE_SUBMISSIONS" => "User can score submissions",
	    );
	  }
	

	public function init() {
//		require_once 'vzaar/Vzaar.php';
//		Vzaar::$token = VZAAR_TOKEN;
//		Vzaar::$secret = VZAAR_SECRET;
		parent::init();
	}
	
	
	public function index() {
		$this->redirectBack();
	}
	
	public function view() {
		
		if($Item = $this->getCurrentItem()) {
			return array(
				'Title' => $Item->Title,
				'Content' => $Item->Content,
				'MetaTitle' => $Item->Title,
				'Item' => $Item,
				'Link' =>$Item->Link(),
				'ClassName' => 'Video'
			);
		}
	    else {
			return $this->httpError(404, _t("VIDEONOTFOUND","Video not found."));
		}
	}
	
	public function getCurrentItem() {
	    $URLSegment = Convert::raw2sql($this->request->param('URLSegment'));
		if( $URLSegment && ( $Item = Video::get()->where("URLSegment = '$URLSegment'")->limit(1)->First() ) ) {       
			return $Item;
		}
	}
	
	private function getSubmissionTarget() {
		if($c = $this->getCurrentItem()) {
			return $c;
		}
		$sid = Convert::raw2sql($this->request->requestVar("sid"));
		if( $sid) {
			$do = DataObject::get_one("Video", "ID = $sid");
			if($do) {
				return $do;
			}
		}
		$this->setMessage("error","No video found");
		return false;
	}
	
	public function FoundationConfig() {
		'{ reveal: { close_on_background_click: false, close_on_esc: false }}';
	}
	
	public function ExtraJavascript() {
		return	$this->renderWith("Javascript_VideoController");
	}
	
	public function CanScore() {
		return (($this->getCurrentItem() ? true : false) && Permission::check("SCORE_SUBMISSIONS"));
	}
	
	public function ScoringForm() {
		$video = $this->getSubmissionTarget();
		if($video) {
			if($video->ClassName == "ChallengeSubmission") {
				$fields = new FieldList();
				$fields->push(new HeaderField("h2","Submit score",2));
				$fields->push(new HeaderField("h4",$video->Target()->ChallengeCategory()->Title,4));
				try {
					$c=1;
					foreach($video->Target()->ChallengeCategory()->ScoreCategories() as $cat) {
						$fields->push(
							new LiteralField("Row_".$c."_1","<div class='row'><div class='small-7 columns'>".$cat->Title."</div><div class='small-3 columns'>")
						);
						$title = "ScoreCategory_".$cat->ID;
						$tfield = new NumericField($title,"");
						$tfield->addExtraClass("radius");
						$tfield->setAttribute("min",0);
						$tfield->setAttribute("max",$cat->MaxPoints);
//						$tfield->setAttribute("placeholder",$cat->MaxPoints);
						$ml = strlen((string)$cat->MaxPoints);
						$tfield->setMaxLength($ml);
						$tfield->setRightTitle("/ ".$cat->MaxPoints);
						
						if($s = $video->SubmissionScores()->where("ID = ".$cat->ID)->first()) {
							$tfield->setValue($s->PartialScore);
						}
						
						$fields->push(
							$tfield
						);
						$fields->push(
							new LiteralField("Row_".$c."_3","</div></div>")
						);
						$fields->push(
							new LiteralField("Row_4", '<a class="close-reveal-modal">&#215;</a>')
						);
						$c++;
						
					}
				}
				catch (Exception $e) {
					$this->setMessage("error",$e->getMessage());
				}
				$fields->push(HiddenField::create("sid","sid", $video->ID));
						 	
				$scoreAction = FormAction::create('doScore', "Submit score");
				$scoreAction->addExtraClass("radius");
				$scoreAction->addExtraClass("scoreButton");
				$actions = new FieldList(
					$scoreAction,
					new LiteralField("cancel", '&nbsp; <a class="secondary" onClick="$(\'#scoremodal\').foundation(\'reveal\', \'close\');" >Cancel</a>')
				);
				
				return new Form($this, 'ScoringForm', $fields, $actions);	
			}
		}
		return false;
	}
	
	public function doScore($data, $form) {
		try {
			$video = $this->getSubmissionTarget();
			$videoid = $video->ID;
			$ccount = ScoreCategory::get()->max("ID");
			for($i=0;$i<=$ccount;$i++) {
				$key = "ScoreCategory_".$i;
				if((array_key_exists($key, $data)) && $data[$key] > 0) {
					$s = SubmissionScore::get()->where("ChallengeSubmissionID = ".$video->ID." AND ScoreCategoryID = ".$i)->first();
					if(!$s) {
						$s = new SubmissionScore();
					}
					$s->ScoreCategoryID = $i;
					$s->ChallengeSubmissionID = $videoid;
					
					$value = $data[$key];
					$sc = ScoreCategory::get()->where("ID = ".$i)->first();
					if($sc) {
						$maxscore = $sc->MaxPoints;
						($value > $maxscore) ? ($value = $maxscore) : 1;
					}
					
					$s->PartialScore = $value;
					$s->write();
				}
			}
			$video->write();
			$this->setMessage("success","Score sheet saved.");
		}
		catch (Exception $e) {
			$this->setMessage("error",$e->getMessage());
		}
		$this->RedirectBack();
		
	}
	
	public function ScoreBox() {
		return $this->renderWith("ScoreBox");
	}
}