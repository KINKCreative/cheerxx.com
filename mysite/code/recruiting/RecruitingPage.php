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
	
	protected $vo;
	protected $targetObject;
	
	private static $allowed_actions = array (
		'profile',
		// 'register',
		'index',
		'editprofile',
		'ProfileEditForm',
		// 'RegisterForm',
		'recruitingwebhook',
		'update',
		'FilterForm'
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
		
		require_once dirname(__FILE__).'/../controllers/vzaar/Vzaar.php';
		Vzaar::$token = VZAAR_TOKEN;
		Vzaar::$secret = VZAAR_SECRET; //'cheerxx';
		
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
		
		//$this->targetObject = $this->getSubmissionTarget();
		
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
			'Form' => $this->ProfileEditForm(),
			'ClassName' => 'RecruitingProfile_Edit',
			"StripePublishableKey" => STRIPE_PUBLISHABLE_KEY
		);
	}
	
	public function Form() {
		global $state_list;
		$fields = new FieldList(
			new LiteralField("l1",'<div class="row"><div class="medium-2 columns">'),
			new CheckboxField("IsBase","Base"),
			new CheckboxField("IsFlyer","Flyer"),
			new LiteralField("l2",'</div><div class="medium-3 small-6 columns">'),
			DropdownField::create("Gender","Gender", singleton('RecruitingProfile')->dbObject('Gender')->enumValues())->setEmptyString("(Gender)"),
			new LiteralField("l3",'</div><div class="medium-3 small-6 columns">'),
			DropdownField::create("TypeInterested","Squad type", singleton('RecruitingProfile')->dbObject('TypeInterested')->enumValues())->setEmptyString("(Squad type)"),
			new LiteralField("l4",'</div><div class="medium-2 columns">'),
			DropdownField::create("State","State", $state_list)->setEmptyString("(State)"),
			new LiteralField("l5",'</div><div class="medium-2 columns">'),
			TextField::create("Keyword","Search text")->setAttribute("placeholder","Keywords"),
			new LiteralField("l6",'</div></div>')
		);
	
		$sendAction = new FormAction('filterprofiles', "Submit");
		$sendAction->addExtraClass("btn-large");
		$actions = new FieldList(
			$sendAction
		);
		$form = new Form($this, 'FilterForm', $fields, $actions);
		$form->loadDataFrom($this->request->postVars());
	    return $form;
	}
	
	public function Profiles() {
		$goodFilters = array("IsBase", "IsFlyer","Gender","State","Keyword");
		//$whereString = "DATE_ADD(SubscriptionDate, INTERVAL 1 YEAR) > NOW()";
		// WHEN SUBSCRIPTIONS BECOME ACTIVE
		
		$whereString = "1 ";
		foreach($goodFilters as $var) {
			if($this->request->postVar($var)!="") {
				$whereString.= " AND $var = '".$this->request->postVar($var)."'";
			}
		}
		return RecruitingProfile::get()->where($whereString);
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
			$profile->Gender = $member->Gender;
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
	
	public function update() {
		/* echo("Update performed");
		foreach(SkillCategory::get() as $skillCategory) {
			$skillCategory->write();
			echo("Skillcategory ".$skillCategory->Title." updated.<br/>");
		} */
		echo("Profiles");
		foreach(RecruitingProfile::get() as $profile) {
			echo("Updated profile: $FirstName $LastName");
			if($profile->Gender=="Boy") {
				$profile->ShowBasketTossSkills = false;
				$profile->IsFlyer = false;
				$profile->IsBase = true;
				$profile->ShowPartnerStuntSkills = true;
				$profile->ShowRunningTumblingSkills = true;
				$profile->ShowStandingTumblingSkills = true;
			}
			else {
				if(!$profile->IsFlyer && !$this->IsBase) {
					$profile->ShowPartnerStuntSkills = false;
					$profile->ShowGroupStuntSkills = false;
				}
			}
		}
		
		return false;
	}
	
}





class ProfileEditForm extends Form {
 
    public function __construct($controller, $name, $profile) {
    
    	$member = Member::currentUser();
    	if(!$member || !$profile ) {
    		return false;
    	}
    	    	
		$fn = TextField::create("FirstName","First name", $profile->FirstName);
		$fn->setAttribute("disabled",true);
		
		$ln = TextField::create("LastName","Last name", $profile->LastName);
		$ln->setAttribute("disabled",true);
		
		$em = TextField::create("Email","E-mail", $member->Email);
		//$em->setAttribute("disabled",true);
		
		$ge = TextField::create("Gender","Gender", $profile->Gender);
		$ge->setAttribute("disabled",true);
	
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
		
		/* $fields = new FieldList(
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
		*/ 
		
		$tabset = new TabSet(
			"Root",
			new Tab("Main",
				new LiteralField("l1",'<div class="row"><div class="large-6 columns">'),
				$fn,
				new LiteralField("l2",'</div><div class="large-6 columns">'),
				$ln,
				new LiteralField("l3",'</div></div><div class="row"><div class="large-8 columns">'),
				$em,
				new LiteralField("l4",'</div><div class="large-4 columns">'),
//				DropdownField::create(
//				  'Gender',
//				  'Gender',
//				  singleton('RecruitingProfile')->dbObject('Gender')->enumValues(),
//				  $profile->Gender
//				)->setEmptyString('(Select)'),
				$ge,
				new LiteralField("l5",'</div></div><div class="row"><div class="large-8 columns">'),
				new TextField("Hometown","Hometown",$profile->skHometown),
				new LiteralField("l6",'</div><div class="large-4 columns">'),
				DropdownField::create("State","State", $state_list, $profile->State)->setEmptyString('(Select one)'),
				new LiteralField("l7",'</div></div>'),
				new TextField("School","School", $profile->School),
				new TextareaField("ProfileText", "Profile text", $profile->ProfileText, 10),
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
	    		new CheckboxField("ShowStandingTumblingSkills", "Standing Tumbling Skills",$profile->ShowStandingTumblingSkills),
	    		new CheckboxField("ShowRunningTumblingSkills", "Running Tumbling Skills",$profile->ShowRunningTumblingSkills),
    			new CheckboxField("ShowPartnerStuntSkills", "Partner Stunts",$profile->ShowPartnerStuntSkills),
    			new CheckboxField("ShowGroupStuntSkills", "Group Stunts",$profile->ShowGroupStuntSkills),
    			new CheckboxField("ShowBasketTossSkills", "Basket Toss Skills",$profile->ShowBasketTossSkills),
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
    			$skillCategoryID = $skillset->CategoryID;
    			$category = SkillCategory::get()->where("ID = ".$skillCategoryID)->first();

    			$skillClass = $category->MethodClassName;
    			$fieldName = "Show".$skillClass."Skills";
//    			echo($fieldName." ///");
//    			echo($fieldName);
    			if( $profile->{$fieldName} == 1 ) {
//    				echo($skillClass);
    				//$fields->add(new HeaderField("Header", $skillset->Skills->first()->Category()->Title,4));
		    		
		    		$fieldLabel = "Enter other ".$category->Title." skills";
		    		$myclassName = "Other".$category->MethodClassName."Skills";
		    		$textareaField = new TextareaField("Other".$skillClass."Skills", $fieldLabel, $profile->{$myclassName}, 3);
		    		
		    		$n=$skillset->Skills->count();
//		    		if(($n=$skillset->Skills->count())>0) {
	    			$idlist = implode(",", array_unique($profile->Skills()->sort("SortOrder ASC")->getIDList()));
	    			$skillset->Skills->sort("SortOrder","ASC");
	    			$tempfield = ListboxField::create("Skills_".$skillset->CategoryID,$skillset->Skills->first()->Category()->Title,$skillset->Skills->map("ID","Title"),$idlist,"",true)->setAttribute('placeholder','(Select one)');
	    			$tempfield->addExtraClass("chosen-select");
	    			$fields->addFieldToTab("Root.YourSkills",$tempfield);
		    		$fields->addFieldToTab("Root.YourSkills",$textareaField);
//			    	}
		    		
    			}
    			else {    				
    				//$fields->removeByName("Show".$skillClass."Skills");
    			}
    	}
    	$fields->addFieldToTab("Root.Main",$uploadField);
    	
    	if($profile->Gender == "Boy") {
    		$fields->removeByName("IsFlyer");
    		$fields->removeByName("ShowBasketTossSkills");
    	}
    	else {
    		//$fields->removeByName("IsBase");
    	}
    	
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
//    	print_r($data);
		try{
	    	$skills = array();
	    	for($i=0;$i<6;$i++) {
	    		if(array_key_exists("Skills_".$i, $data)) {
	    			$skills = array_merge($skills,$data["Skills_".$i]);
	    		}
	    	}
	    	$profile = RecruitingProfile::get()->where("ID = ".$data["pid"])->first();
	    	if($profile) {
	   			/* foreach($skills as $s) {
	   				$temp = Skill::get()->where("ID = ".$s)->limit(1)->first();
	   				$profileSkills->add($temp);
	   			} */
//	   			$profile->FirstName = $data["FirstName"];
//	   			$profile->LastName = $data["LastName"];
				$myFields = array(
					"IsBase",
					"IsFlyer",
					"Hometown",
					"State",
					"School",
					"ProfileText",
					"CollegesInterested",
					"TypeInterested",
					"ShowPartnerStuntSkills",
					"ShowGroupStuntSkills",
					"ShowRunningTumblingSkills",
					"ShowStandingTumblingSkills",
					"ShowBasketTossSkills",
					"OtherPartnerStuntSkills",
					"OtherGroupStuntSkills",
					"OtherRunningTumblingSkills",
					"OtherStandingTumblingSkills",
					"OtherBasketTossSkills"
				);
				foreach($myFields as $fieldName) {
					if(array_key_exists($fieldName,$data)) {
						$profile->{$fieldName} = $data[$fieldName];
					}
					else {
						$profile->{$fieldName} = false;
					}
				}
					
	   			
//	   			$profile->State = $data["State"];
//	   			$profile->School = $data["School"];
//	   			$profile->ProfileText = $data["ProfileText"];
//	   			$profile->CollegesInterested = $data["CollegesInterested"];
//	   			
//	   			$profile->ShowPartnerStuntSkills = $data["ShowPartnerStuntSkills"];
//	   			$profile->ShowGroupStuntSkills = $data["ShowGroupStuntSkills"];
//	   			$profile->ShowRunningTumblingSkills = $data["ShowRunningTumblingSkills"];
//	   			$profile->ShowStandingTumblingSkills = $data["ShowStandingTumblingSkills"];
//	   			$profile->ShowBaketTossSkills = $data["ShowBaketTossSkills"];
//	   			
//	   			$profile->OtherPartnerStuntSkills = $data["OtherPartnerStuntSkills"];
//	   			$profile->OtherGroupStuntSkills = $data["OtherGroupStuntSkills"];
//	   			$profile->OtherRunningTumblingSkills = $data["OtherRunningTumblingSkills"];
//	   			$profile->OtherStandingTumblingSkills = $data["OtherStandingTumblingSkills"];
//	   			$profile->OtherBaketTossSkills = $data["OtherBaketTossSkills"];
//	   			
//	   			if(array_key_exists("IsFlyer",$data)) {
//		   			$profile->IsFlyer = $data["IsFlyer"];
//		   		}
//		   		if(array_key_exists("IsBase",$data)) {
//		   			$profile->IsBase = $data["IsBase"];
//		   		}
//		   		if(array_key_exists("Gender",$data)) {
//		   			$profile->Gender = $data["Gender"];
//		   		}
//		   		if(array_key_exists("TypeInterested",$data)) {
//		   			$profile->TypeInterested = $data["TypeInterested"];
//		   		}
		   		if(array_key_exists("Files",$data["Images"]) && sizeof($data["Images"]["Files"] > 0)) {
			   		$profile->Images()->setByIDList($data["Images"]["Files"]);
			   	}
			   	$profile->write();
			   	$profile->Skills()->setByIDList($skills);
			   	$profile->Skills()->write();
			   	
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