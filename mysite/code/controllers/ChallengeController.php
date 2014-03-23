<?php 

class ChallengeController extends Page_Controller {

	private static $allowed_actions = array (
		'superchallenge',
		'challenge',
		'submit',
		'index',
		'scores'
	);
	
	public static $url_handlers = array(
		'' => 'index',
		'$URLSegment!/challenge/$ID!/scores' => 'scores',
		'$URLSegment!/challenge/$ID!' => 'challenge',
	    '//$URLSegment!' => 'superchallenge'
	);
	

	public function init() {	
		parent::init();
	}
	
	const URLSegment = '/competitions';
	
	public function getURLSegment() { 
		return self::URLSegment; 
	}
	
//	public function Link($action = null, $id = null) {
		//$action = $this->request->param('Action');
		//$id = $this->request->param('ID');
//		return Controller::join_links(self::URLSegment, $action, $id);
//	} 
	
	public function index() {
		if($this->getSuperChallenges()->count() == 1) {
			$this->redirect($this->getSuperChallenges()->first()->Link());
		}
			
		return array(
			"Title" => "Online Competitions"
		);
	}
	
	public function superchallenge() {	
		if($Item = $this->getCurrentItem()) {
			return array(
				'Title' => $Item->Title,
				'Content' => $Item->Content,
				'MetaTitle' => $Item->Title,
				'Image' => $Item->Images() ? $Item->Images()->First() : false,
				'Item' => $Item,
				'Link' =>$Item->Link(),
				'ClassName' => 'SuperChallenge'
			);
		}
	    else {
			return $this->httpError(404, _t("NOTFOUND","Competition not found."));
		}
	}
	
	public function getCurrentItem() {
	    $URLSegment = Convert::raw2sql($this->request->param('URLSegment'));
		if( $URLSegment && ( $Item = SuperChallenge::get()->where("URLSegment = '$URLSegment'")->limit(1)->First() ) ) {       
			return $Item;
		}
	}

	
	/* CHALLENGE CODE */
	
	//	SS_HTTPRequest $request
	public function challenge() {
		$sc = $this->getCurrentItem();
		if($sc && ($Item = $this->getCurrentChallenge($sc->ID))) {
		
		
			$a = array(
				'Title' => $Item->Title,
				'Content' => $Item->Content,
				'MetaTitle' => $Item->Title,
				'Image' => $Item->Images() ? $Item->Images()->First() : false,
				'Item' => $Item,
				'Link' =>$Item->Link(),
				'SuperChallenge' => $sc,
				'ClassName' => 'Challenge'
			);
			if($this->request->getVar("adminview")==1 && Permission::check("USER_CAN_SCORE")) {
				return $this->customise(new ArrayData($a))->renderWith(array("ChallengeController_scoreadmin", "Page"));
			}
			else {
				return $a;
			}
			
		}
		else {
			return $this->httpError(404, _t("CHALLENGENOTFOUND","Error retrieving challenge."));
		}
	}
	
	public function scores() {
		$sc = $this->getCurrentItem();
		if($sc && ($Item = $this->getCurrentChallenge($sc->ID))) {
	
			$a = array(
				'Title' => $Item->Title,
				'Content' => $Item->Content,
				'MetaTitle' => $Item->Title,
				'Image' => $Item->Images() ? $Item->Images()->First() : false,
				'Item' => $Item,
				'Link' =>$Item->Link(),
				'SuperChallenge' => $sc,
				'ClassName' => 'Challenge'
			);
			return $a;
			
		}
		else {
			return $this->httpError(404, _t("CHALLENGENOTFOUND","Error retrieving challenge."));
		}
	}
	
	public function getCurrentChallenge($scID=0) {
		$URLSegment = Convert::raw2sql($this->request->param('ID'));
		if(($scID && $URLSegment) && $Item = Challenge::get()->filter(array("URLSegment" => $URLSegment))->limit(1)->First()) {
			return $Item;
		}
	}
	
	/* TEMPLATE FUNCTIONS */
	
	public function getSuperChallenges() {
		return SuperChallenge::get()->filter(array("Published"=>1));
	}
	
	public function Form() {
					
/*			Requirements::javascript("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js");
			Requirements::javascript("mysite/js/screwdefaultbuttons/js/jquery.screwdefaultbuttonsV2.min.js");
			Requirements::customScript('
				$(document).ready(function() {
					$("form").validate({
					    rules: {
					        recaptcha_response_field: {
					            required: true
					        }
					    },
					    messages: {
					        recaptcha_response_field: {
					            required: "*",
					            remote: "Invalid captcha"
					        }
					    }
					});
					$(":radio").screwDefaultButtons({
				        image: \'url("themes/'.SSViewer::current_theme().'/img/radio.png")\',
				        width: 40,
				        height: 40
				    });
				    $( ".radio" )
				      .click(function () {
				        n = $("input:checked").length;
				        perc = Math.round((n/5)*100);
				        $(".progress-bar").css("width",perc+"%");
				      });
			    });
			'); */
			
			
			$sendAction = new FormAction('saveSubmission', 'Submit video');
			$sendAction->addExtraClass("btn-large");
			$actions = new FieldList(
				$sendAction
			);
			$sizeMB = 50; // 50 MB
//			$size = $sizeMB * 1024 * 1024; // 2 MB in bytes
			$fields = FieldList::create();
			$uploadField = new UploadField("VideoFile","Upload your video (max. ".$sizeMB." Mb)");
			$uploadField->setFolderName("temp/videos");
			$uploadField->setAllowedExtensions(array('mov', 'avi', 'm4v', 'mp4','mpg','wmv'));
			$uploadField->getValidator()->setAllowedMaxFileSize($sizeMB);
			$uploadField->setCanAttachExisting(false);
			$uploadField->setCanPreviewFolder(false);
			$uploadField->relationAutoSetting = false;
			$fields->add(new TextareaField("Description"));
			$fields->add($uploadField);
			
			return new Form($this, "Form", $fields, $actions);
		}
		
		public function UserCanScore() {
			return Permission::check("SCORE_SUBMISSIONS");
		}

}