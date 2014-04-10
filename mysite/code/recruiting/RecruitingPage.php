<?php 

class RecruitingPage extends Page {

	private static $db = array(
		"SignupContent" => "HTMLText",
		"Price" => "Currency"
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Registration", new HtmlEditorField("SignupContent","Content on sign-up page"));
		$fields->addFieldToTab("Root.Registration", new CurrencyField("Price","Enter price for sign-up"));
		return $fields;
	}

}

class RecruitingPage_Controller extends Page_Controller {

	private static $allowed_actions = array (
		'profile',
		// 'register',
		'index',
		'editprofile',
		'ProfileEditForm',
		// 'RegisterForm',
		'recruitingwebhook'
	);	

	public function init() {	
		parent::init();
	}
	
	const URLSegment = '/recruiting';
	
	public function getURLSegment() { 
		return self::URLSegment; 
	}
	
//	public function Link($action = null, $id = null) {
		//$action = $this->request->param('Action');
		//$id = $this->request->param('ID');
//		return Controller::join_links(self::URLSegment, $action, $id);
//	} 
	
	// public function register() {
	// 	if(!Member::currentUserID()) {
	// 		$this->setMessage("error","You need to be logged in to register.");
	// 		Session::set('BackURL',"recruiting/register");
	// 		$this->redirect("Security/login");
	// 	}
	// 	if($profile = $this->getCurrentMemberProfile()) {
	// 		if($profile->getHasActiveSubscription()) {
	// 			$this->setMessage("warning","Your subscription is still active.");
	// 			$this->redirectBack();
	// 			return false;
	// 		}
	// 	}
	// 	return array(
	// 		"Title" => "Recruiting database sign-up",
	// 		"Form" => $this->RegisterForm(),
	// 		"StripePublishableKey" => STRIPE_PUBLISHABLE_KEY
	// 	);
	// }
	
	public function profile() {	
		if($Item = $this->getCurrentProfile()) {
			return array(
				'Title' => $Item->Title,
//				'Content' => $Item->Content,
//				'MetaTitle' => $Item->Title,
//				'Image' => $Item->Images() ? $Item->Images()->First() : false,
				'Profile' => $Item,
				'Link' =>$Item->Link(),
				'ClassName' => 'RecruitingProfile_Profile'
			);
		}
	    else {
			return $this->httpError(404, _t("NOTFOUND","Profile not found."));
		}
	
	}
	
	public function editprofile() {
		if(!Member::currentUserID()) {
			$this->setMessage("error","You need to be logged in to register.");
			Session::set('BackURL',"recruiting/editprofile");
			$this->redirect("Security/login");
		}
		
//		if($profile = $this->getCurrentMemberProfile()) {
			// if(!$profile->getHasActiveSubscription()) {
			// 	$this->setMessage("warning","Your subscription is not active anymore. Please renew.");
			// 	$this->redirect("recruiting/register");
			// 	return false;
			// }
//		}
//		else {
//
//			$member = Member::currentUser();
//
//		}
		return array(
			'Title' => "Edit your profile",
//				'Content' => $Item->Content,
//				'MetaTitle' => $Item->Title,
//				'Image' => $Item->Images() ? $Item->Images()->First() : false,
			'Form' => $this->ProfileEditForm(),
			'ClassName' => 'RecruitingProfile_Edit'
		);
	}
	
	public function Profiles() {
		return RecruitingProfile::get()->where("DATE_ADD(SubscriptionDate, INTERVAL 1 YEAR) > NOW()");
	}
	
	public function getCurrentProfile() {
	    $URLSegment = Convert::raw2sql($this->request->param('ID'));
		if( $URLSegment && ( $Item = RecruitingProfile::get()->where("URLSegment = '$URLSegment'")->limit(1)->First() ) ) {       
			return $Item;
		}
	}
	
	public function CanEditProfile() {
		$profile = $this->getCurrentMemberProfile();
		if($profile) {
			return  true; //$profile->getHasActiveSubscription();
		}
		return false;
	}
	
	
	/* 
	public function RegisterForm() {
		if($profile = $this->getCurrentMemberProfile()) {
			return false;
		}
		
		$buttonTitle = "Confirm subscription";
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
			  	  	  					'<input type="text" size="2" maxlength="2" data-stripe="exp-month" placeholder="MM" />'.
			  	  	  				'</div>'.
			  	  	  				'<div class="small-1 columns"><label class="inline text-center">/</label></div>'.
			  	  	  				'<div class="small-7 columns">'.
			  	  	  					'<input type="text" size="4"  maxlength="4" data-stripe="exp-year" placeholder="YYYY" />'.
			  	  	  				'</div>'.
			  	  	  			'</div>'.
			  	  	  		'</div>'.
			  	  	  		'<div class="small-4 columns">'.
			  	  	  			'<label>CVC</label>'.
			  	  	  			'<input type="text" size="3" maxlength="3" data-stripe="cvc" placeholder="CVC" />'.
			  	  	  		'</div>'.
				  	  	  '</div>'.
				  	  '</div>'.
			      '</div>'.
			  '</div>'.
		      '</div>'.
		      '<span class="payment-errors"></span>'
		);
		$price = "5";
		if($this->Price) { $price = $this->Price; }
		$title = "<strong>Recruiting Database Registration (1 year)</strong></p><hr /><p>Price: <strong>$".$price."/year</strong>";
		
		$fields = new FieldList(
//	    	HeaderField::create("Info","Video information",3),
	    	LiteralField::create("FormTitle","<p>".$title."</p>"),
	    	LiteralField::create('firstrow','<div class="row"><div class="large-12 columns">'),
			$paymentField,
			LiteralField::create('secondrow','</div></div>')
		);
			 	
	    $registerAction = FormAction::create('doRegister', $buttonTitle);
	    $registerAction->addExtraClass("radius");
	    $registerAction->addExtraClass("registerButton");
	    $actions = new FieldList(
	    	$registerAction
	    );
		
//		$validator = new RequiredFields('Description');
						
	    return new Form($this, 'RegisterForm', $fields, $actions);
		
	} */
	
	function getCurrentMemberProfile() {
		$uid = Member::currentUserID();
		if($uid) {
			$profile = RecruitingProfile::get()->where("MemberID = ".$uid)->limit(1)->first();
			if($profile) {
				return $profile;
			}
		}
		return false;
	}
	
/*	function doRegister($data, $form) {
			
		$price = 5;
		if($this->Price) { $price = $this->Price; }
		$amount = (int)$price*100;
		
		$member = Member::currentUser();
		
		$token = $data["stripeToken"];
		
		if($this->StripeCharge(
			$token,
			$amount,
			$description = "Recruitment Subscription for ".$member->Email,
			$saveuser = true
		)) {
			
			$profile = $this->getCurrentMemberProfile();
			if(!$profile) {
				$profile = new RecruitingProfile();
				$profile->FirstName = $member->FirstName;
				$profile->LastName = $member->Surname;
				$profile->MemberID = $member->ID;
				$profile->write();
			}
			$profile->SubscriptionDate = date("Y-m-d H:i:s");
			$profile->write();
			
			
			// SEND EMAIL
			$from = "noreply@cheerxx.com";
			$to = $member->Email;
			$subject = "Registration cofirmed for Recruiting Dabase";
			$body = 	"Dear ".$member->FirstName.",\n".
						"This confirms your registration in the\n".
						"Cheerxx.com Recruiting Database.\n".
						"--------------------------------------\n".
						"Amount: $".$price."\n\n".
						"Subscription active as of: ".strftime("%c").
						"View / edit your profile: ".$profile->AbsoluteLink().
						"--------------------------------------\n".
						"This is a receipt. No payment is due.\n".
						"Your CheerXX team";
			
			$email = new Email($from, $to, $subject, $body);
			$email->send();
			
			$status = "Registration successful!";
			$this->setMessage("success", $status);
		}
					
		$this->redirectBack();
	} */
	
	function ProfileEditForm() {
		$profile = $this->getCurrentMemberProfile();
		$member = Member::currentUser();
		
		if(!$member) {
			return false;
		}
		
		if ($member && !$profile) {
			$profile = new RecruitingProfile();
			$profile->FirstName = $member->FirstName;
			$profile->LastName = $member->Surname;
			$profile->MemberID = $member->ID;
			$profile->write();
			$profile->SubscriptionDate = date("Y-m-d H:i:s");
			$profile->write();
		}
		$form = new ProfileEditForm($this,"ProfileEditForm",$profile);
		return $form;
	}
	
	/* public function ExtraJavascript() {
		return $this->renderWith("Javascript_Recruiting");
	}	*/    
	
}





class ProfileEditForm extends Form {
 
    public function __construct($controller, $name, $profile) {
    
    	$member = Member::currentUser();
    	if(!$member || !$profile ) {
    		return false;
    	}
    	    	
		$fn = new TextField("FirstName","First name", $profile->FirstName);
		$fn->performReadonlyTransformation(true);
		
		$ln = new TextField("LastName","Last name", $profile->LastName);
		$ln->performReadonlyTransformation(true);
		
		$em = new TextField("Email","E-mail", $member->Email);
		$em->performReadonlyTransformation(true);
	
    	$sizeMB = 5; // 50 MB
		$size = $sizeMB * 1024 * 1024; // 2 MB in bytes
		$uploadField = new UploadField("Images","Upload image (max. ".$sizeMB." Mb)");
		$uploadField->setItems($profile->Images());
//		$uploadField->setRecord($profile);
		$uploadField->setFolderName("images/profiles");
		$uploadField->setAllowedExtensions(array('jpg', 'JPG', 'jpeg', 'JPEG'));
		$uploadField->getValidator()->setAllowedMaxFileSize($size);
		$uploadField->setCanAttachExisting(false);
		$uploadField->setCanPreviewFolder(false);
		$uploadField->relationAutoSetting = false;
		$uploadField->setAllowedMaxFileNumber(3);
    
    	$date = new DateTime($profile->SubscriptionDate);
    	$nicedate2 = $date->format('Y-m-d h:m');
    	$date->modify('+1 year');
    	$nicedate = $date->format('Y-m-d h:m');
    	   
    
   		global $state_list;
//    	print_r($state_list);

		$tabset = new TabSet(
			"Root",
			new Tab("Main",
				$fn,$ln,$em,
					DropdownField::create(
					  'Gender',
					  'Gender',
					  singleton('RecruitingProfile')->dbObject('Gender')->enumValues(),
					  $profile->Gender
					)->setEmptyString('(Select)'),
				new TextField("Hometown","Hometown",$profile->Hometown),
				DropdownField::create("State","State", $state_list, $profile->State)->setEmptyString('(Select one)'),
				new TextField("School","School", $profile->School),
				new TextareaField("ProfileText", $profile->ProfileText),
				DropdownField::create(
				  'TypeInterested',
				  'Squad Type',
				  singleton('RecruitingProfile')->dbObject('TypeInterested')->enumValues(),
				  $profile->TypeInterested
				)->setEmptyString('(Select one)'),
				new TextareaField("CollegesInterested", "Please list colleges / teams you are interested in",$profile->CollegesInterested),
				new HiddenField("pid", "", $profile->ID)
			),
			new Tab("YourSkills",
//    			DateField("BirthDate")::create()->setConfig('showcalendar','true'),
	    		new CheckboxField("IsBase", "Are you a base?", $profile->IsBase),
	    		new CheckboxField("IsFlyer", "Are you a flyer?", $profile->IsFlyer),
	    		new LiteralField("m1","<br/><hr/>"),
    			new CheckboxField("ShowPartnerStuntSkills", "Partner Stunts",$profile->ShowPartnerStuntSkills),
    			new CheckboxField("ShowGroupStuntSkills", "Group Stunts",$profile->ShowGroupStuntSkills),
    			new CheckboxField("ShowStandingTumblingSkills", "Standing Tumbling Skills",$profile->ShowStandingTumblingSkills),
    			new CheckboxField("ShowRunningTumblingSkills", "Running Tumbling Skills",$profile->ShowRunningTumblingSkills),
    			new CheckboxField("BasketTossSkills", "Basket Toss Skills",$profile->ShowBasketTossSkills),
    			new LiteralField("m2","<br/><hr/>"),
				new HeaderField("Skillsheader", "Skill categories",4)
			) /* ,
			new Tab("Subscription",
				new ReadonlyField("Renewed", "Subscription renewed", $nicedate2),
				new ReadonlyField("Valid", "Subscription valid until", $nicedate)
			) */
		);
		$fields = new FieldList($tabset);
		    
    	$groupedSkillList = new GroupedList(Skill::get()); 
    	$grouped = $groupedSkillList->GroupedBy("CategoryID","Skills")->sort(array("CategoryID"=>"ASC", "SortOrder" => "ASC")); //,"Skills");
    	
    	$c=0;
//    	$fields->addFieldToTab("Root.YourSkills", new HeaderField("Skillsheader", "Skill categories",4));
    	foreach($grouped as $skillset) {
    		if(($n=$skillset->Skills->count())>0) {
	    		//$fields->add(new HeaderField("Header", $skillset->Skills->first()->Category()->Title,4));
	    		$idlist = implode(",", array_unique($profile->Skills()->getIDList()));
	    		$tempfield = ListboxField::create("Skills_".$skillset->CategoryID,$skillset->Skills->first()->Category()->Title,$skillset->Skills->map("ID","Title"),$idlist,$n,true)->setAttribute('placeholder','(Select one)');
	    		$tempfield->addExtraClass("chosen-select");
	    		$fields->addFieldToTab("Root.YourSkills",$tempfield);	
	    	}
    	}
    	$fields->addFieldToTab("Root.Main",$uploadField);
    	
		$sendAction = new FormAction('saveprofile', "Save changes");
		$sendAction->addExtraClass("btn-large");
		$actions = new FieldList(
			$sendAction
		);
        parent::__construct($controller, $name, $fields, $actions);
    }
    
    public function SkillFields() {
    	$skills = Skill::get();
    	$groupedSubmissionsList = new GroupedList($skills); 
    	$grouped = $groupedSubmissionsList->groupBy("CategoryID");
    }
     
    public function forTemplate() {
        return $this->renderWith(array($this->class, 'Form'));
    }
    
    
    public function saveprofile(array $data, Form $form) {
		try{
	    	$skills = array();
	    	for($i=0;$i<6;$i++) {
	    		if(array_key_exists("Skills_".$i, $data)) {
	    			$skills = array_merge($skills,$data["Skills_".$i]);
	    		}
	    	}
	    	$profile = RecruitingProfile::get()->where("ID = ".$data["pid"])->first();
	    	
	    	if($profile) {
	   			$profile->Skills()->setByIDList($skills);
//	   			$profile->Skills()->write();
	   			/* foreach($skills as $s) {
	   				$temp = Skill::get()->where("ID = ".$s)->limit(1)->first();
	   				$profileSkills->add($temp);
	   			} */
//	   			$profile->FirstName = $data["FirstName"];
//	   			$profile->LastName = $data["LastName"];
	   			$profile->Hometown = $data["Hometown"];
	   			$profile->School = $data["School"];
	   			$profile->ProfileText = $data["ProfileText"];
	   			$profile->CollegesInterested = $data["CollegesInterested"];
	   			
	   			if(array_key_exists("IsFlyer",$data)) {
		   			$profile->IsFlyer = $data["IsFlyer"];
		   		}
		   		if(array_key_exists("IsBase",$data)) {
		   			$profile->IsBase = $data["IsBase"];
		   		}
		   		if(array_key_exists("Gender",$data)) {
		   			$profile->Gender = $data["Gender"];
		   		}
		   		if(array_key_exists("TypeInterested",$data)) {
		   			$profile->TypeInterested = $data["TypeInterested"];
		   		}
		   		if(array_key_exists("Files",$data["Images"]) && sizeof($data["Images"]["Files"] > 0)) {
			   		$profile->Images()->setByIDList($data["Images"]["Files"]);
			   	}
			   	$profile->Skills()->write(null, null, null, true);
	   			$profile->write(null, null, null, true);
	   			Controller::curr()->setMessage("success","Your profile was successfully updated.");
	   			//print_r($data["Images"]["Files"][0]);
	   		}
	        // Do something with $data
		}
		catch(Exception $e) {
			$this->setMessage("danger",$e->getMessage());
		}
		Controller::curr()->redirectBack();
	}
    
}