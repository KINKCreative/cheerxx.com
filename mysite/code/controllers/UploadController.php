<?php 

class UploadController extends Page_Controller {
	
	protected $guid;
	protected $vo;
	protected $targetObject;
	
	private static $allowed_actions = array (
		'index',
		'submit',
		'UploadForm',
		'done'
	);
	
	public function init() {
		require_once 'vzaar/Vzaar.php';
		Vzaar::$token = VZAAR_TOKEN;
		Vzaar::$secret = VZAAR_SECRET; //'cheerxx';
		
		$this->targetObject = $this->getSubmissionTarget();
		
		parent::init();
	}
	
	const URLSegment = 'upload';
	
	public function getURLSegment() { 
		return self::URLSegment; 
	}
	
	public function index() {
		if(!Member::currentUserID()) {
//			$this->setMessage("danger","Login required to upload.");
			$this->redirect("Security/login?BackURL=/upload");
			return false;
		}
						
		return array(
			"Title" => "Select upload category",
			"Content" => "Please select the coaching category or challenge below to upload your video."
		);
	}
	
	public function submit() {
		if(!Member::currentUserID()) {
//			$this->setMessage("danger","Login required to upload.");
			$this->redirect("Security/login?BackURL=".urlencode($_SERVER["REQUEST_URI"]));
			return false;
		}
		
		$sr = Vzaar::getUploadSignature();
		$this->guid = $sr["vzaar-api"]["guid"];
		$vo = new ArrayData(array(
			"key" => $sr["vzaar-api"]["key"],
			"bucket" => $sr["vzaar-api"]["bucket"],
			"guid" => $sr["vzaar-api"]["guid"],
			"accesskeyid" => $sr["vzaar-api"]["accesskeyid"],
			"acl" => $sr["vzaar-api"]["acl"],
			"policy" => $sr["vzaar-api"]["policy"],
//			"success_action_redirect" => $sr["vzaar-api"]["success_action_redirect"],
			"signature" => $sr["vzaar-api"]["signature"]
		));
		$this->vo = $vo;
		
		return array(
			"Title" => "Upload video",
			"HasPayment" => $this->targetObject->IsPayable(),
			"StripePublishableKey" => STRIPE_PUBLISHABLE_KEY,
			"ClassName" => "UploadController"
		);
	}
	
//	public function done() {
//		$username = Member::currentUser()->Username;
//		$title = "competition_name - submission for challenge_name by $username";
//		
//		$guid = "";
//		$title = "";
//		$description = "";
//		$apireply = Vzaar::processVideo($guid, $title, $description, $labels, 1);
//	}
	
	
	public function VzaarObject() {
		return $this->vo;
	}
	
	public function UploadForm() {
	
		$targetObject = $this->targetObject;
		$paymentField = new LiteralField("","");
		$title = "";
		$buttonTitle = "Upload video";
		$descriptionText = "Description";
		if($targetObject) {
			if($targetObject->ClassName == "Challenge") {
				if(!$targetObject->canSubmit()) {
					$this->setMessage("warning","You have already submitted for ".$targetObject->Title);
					$this->redirectBack();
					return false;
				}
				$title = 	"to <strong>".$targetObject->Title."</strong> ".
							"(under the <strong>".$targetObject->SuperChallenge()->Title."</strong> competition)";
			}
			else if($targetObject->ClassName == "CoachingCategory") {
				$title = "an online coaching request in the <strong>".$targetObject->Title."</strong> category. You will be able to submit a video and have it reviewed by our staff.";
				$descriptionText = "Tell us about your problem";
			}
			
			
			if($targetObject->isPayable()) {
				$buttonTitle = "Upload and complete order";
				$paymentField = LiteralField::create("PaymentInformation",
					  '<h3>Payment information</h3>'.
					  '<div class="row">'.
					  '<div class="large-12 columns">'.
					  	  '<div class="row">'.
					  	  	  '<div class="medium-5 columns">'.
					  	  	  	'<label>Card number</label>'.
					  	  	  	'<input type="text" size="20" data-stripe="number" placeholder="••••  ••••  ••••  ••••" />'.
					  	  	  '</div>'.
					  	  	  '<div class="medium-7 columns">'.
					  	  	  	'<div class="row">'.
					  	  	  		'<div class="small-8 columns">'.
					  	  	  			'<label>Card Expiration</label>'.
					  	  	  			'<div class="row collapse">'.
					  	  	  				'<div class="small-4 columns">'.
					  	  	  					'<input type="text" size="2" data-stripe="exp-month" placeholder="MM" />'.
					  	  	  				'</div>'.
					  	  	  				'<div class="small-1 columns"><label class="inline text-center">/</label></div>'.
					  	  	  				'<div class="small-7 columns">'.
					  	  	  					'<input type="text" size="4" data-stripe="exp-year" placeholder="YYYY" />'.
					  	  	  				'</div>'.
					  	  	  			'</div>'.
					  	  	  		'</div>'.
					  	  	  		'<div class="small-4 columns">'.
					  	  	  			'<label>CVC</label>'.
					  	  	  			'<input type="text" size="4" data-stripe="cvc" placeholder="CVC" />'.
					  	  	  		'</div>'.
						  	  	  '</div>'.
						  	  '</div>'.
					      '</div>'.
					  '</div>'.
				      '</div>'.
				      '<span class="payment-errors"></span>'
				);
				$title = $title.="</p><hr /><p>Price: <strong>$".$targetObject->Price."</strong>";
			}
			
		}
		else {
			$this->setMessage("alert","Error retrieving submission target.");
			$this->redirectBack();
		}
	
	    $fields = new FieldList(
	    	HeaderField::create("Info","Video information",3),
	    	LiteralField::create("VideoTitle","<p>You are submitting for ".$title."</p>"),
	    	LiteralField::create('firstrow','<div class="row"><div class="large-12 columns">'),
	    	TextField::create('Title',"Enter video title"),
			TextareaField::create('description', $descriptionText)->setAttribute("required pattern","[a-zA-Z]+"),
			LiteralField::create('row2','</div></div><div class="row"><div class="large-12 columns">'),
			LiteralField::create('FileUpload','<label for="file">Select a Video to Upload (max. 50Mb)</label>'.
				'<input type="file" name="file" id="file" required accept="video/*" />'.
				'<span class="file-error"></span>'),
			$paymentField,
			$this->guid ? HiddenField::create('VzaarGuid', "VzaarGuid", $this->guid) : HiddenField::create('VzaarGuid', "VzaarGuid")
		);
		if($targetObject) {
			$fields->push(HiddenField::create("sid","sid", $targetObject->ID));
			$fields->push(HiddenField::create("c","c", $targetObject->ClassName));
		}
		
			 	
	    $uploadAction = FormAction::create('doUpload', $buttonTitle);
	    $uploadAction->addExtraClass("radius");
	    $uploadAction->addExtraClass("uploadButton");
	    $actions = new FieldList(
	    	$uploadAction
	    );
		
//		$validator = new RequiredFields('Description');
						
	    return new Form($this, 'UploadForm', $fields, $actions);
	}
 	
	function doUpload($data, $form) {
		require_once 'stripe/lib/Stripe.php';
	
		try {
			$username = Member::currentUser()->Username;
			$guid = $data["VzaarGuid"];
			$description = $data["description"];
			$labels = "CheerXX, Competition, PartnerStunt";
			$submissionClass = $data["c"]."Submission";
			$targetClass = $data["c"];
			$sid = $data["sid"];
			
			$targetObject = DataObject::get_one($targetClass, "ID = $sid");
			if($targetObject) {
			
				if($targetObject->IsPayable()) {
					
					$member = Member::currentUser();
					
					$stripeToken = $data["stripeToken"];
					Stripe::setApiKey(STRIPE_SECRET_KEY);
					$amount = (int)$targetObject->Price*100;
					$paymentFor = $targetObject->DetailTitle;
					$email = $member->Email;
					
					try {
						$userID = $member->StripeUserID;
						if(!$userID) {
						
							$customer = Stripe_Customer::create(array(
							  "card" => $stripeToken,
							  "description" => $member->Name(),
							  "email" => $member->Email,
							  "metadata" => array("Username" => $member->Username)
							  )
							);
							$userID = $member->StripeUserID = $customer->ID;
							$member->write();
							
						}
						else {
							Stripe_Customer::retrieve($userID);
							
						}
					
						$charge = Stripe_Charge::create(array(
						  "amount" => $amount, // amount in cents, again
						  "currency" => "usd",
						  "card" => $token,
						  "description" => $member->Email)
						);
					} catch(Stripe_CardError $e) {
					  $this->setMessage("danger","The card has been declined.");
					  echo("The card has been declined.");
					}
					
				
				}
			
			
			}
			
			
			// PROCESS VIDEO
			$apireply = Vzaar::processVideo($guid, "", "", "", 1);
			
			// SAVE SUBMISSION INTO DATABASE
			// print_r($apireply);
			
			$submission = new $submissionClass();
			$submission->Title = isset($data["Title"]) ? $data["Title"] : "New video";
			$submission->TargetID = $sid;
			$submission->VzaarID = $apireply;
			$submission->description = $description;
			$submission->write();
			
			// UPDATE VIDEO DETAILS
		
			$title = $data["Title"]; // **competition_name** - submission for **challenge_name** by $username";
			$vzaarDescription = 'Submission for '.$submission->Title. " by ".$username;
			$vzaarDescription = '-- View more videos on www.CheerXX.com';
			$submissionURL = $submission->absoluteLink();
			
			$vzaarDescription = $description.'\n\n'.$addDescription;
			
			Vzaar:editVideo($submussion->VzaarID, $title, $description, false, $submissionURL);
			
			//UPDATE SUBMISSION STATUS
			$submission->Status = "Published";
			$submission->write();

			// SEND EMAIL HERE
			
			$status = $apireply."<br/>";
			$this->setMessage("success", $status);
		    //Director::redirectBack(); 
		} catch (Exception $e) {
		    $this->setMessage("alert", $e->getMessage());
		}
	}
	
	private function getSubmissionTarget() {
		
		$c = Convert::raw2sql($this->request->getVar("c"));
		$sid = Convert::raw2sql($this->request->getVar("sid"));
		if( $sid && $c) {
			$do = DataObject::get_one($c, "ID = $sid");
			if($do) {
				return $do;
			}
		}
		return false;
	}
	
	public function ExtraJavascript() {
		return $this->renderWith("Javascript_UploadController");
	}
	
	public function SuperChallenges() {
		$scs = SuperChallenge::get()->where("StartTime <= NOW()");
		return $scs;
	}
	
	public function CoachingCategories() {
		$cc = CoachingCategory::get();
		return $cc;
	}
		
}