<?php
class Page extends SiteTree {
	
	private static $db = array(
		'CustomHtml' => 'Text',
	);
	
	private static $has_one = array(
		'Image' => 'Image'
	);
	
	private static $has_many = array(
		'Images' => 'PageImage'
	);
	
	function getCMSFields() {
	    $fields = parent::getCMSFields();
	    //$fields->removeByName('MetaTitle');
	    //$fields->addFieldToTab("Root.Widgets", new WidgetAreaEditor("Sidebar"));

	 	if(!Permission::check('ADMIN')){ 
	 		$fields->removeByName(_t('SiteTree.TABTODO')); 
	 		$fields->removeByName(_t('SiteTree.TABBEHAVIOUR'));
	 		$fields->removeByName('Access');
	 		$fields->removeByName('Google Sitemap');
	 	}
	 	
	 	/* $photoManager = new ImageDataObjectManager(
	 		$this, // Controller
	 		'Images', // Source name
	 		'PageImage', // Source class
	 		'Image', // File name on DataObject
	 		array(
	 			'Caption' => 'Name'
	 		), // Headings 
	 		'getCMSFields_forPopup' // Detail fields (function name or FieldSet object)
	 		// Filter clause
	 		// Sort clause
	 		// Join clause
	 	);
	 	$photoManager->setUploadFolder("images/pages"); */
	 	
	 	$fields->removeByName('Content.Content');
	 	$fields->addFieldToTab("Root.Main", new HTMLEditorField("Content","Content",15));
	 	
	 	$imageField = new UploadField('Image','Choose image');
	 	$imageField->setFolderName("images"); 
	 	$fields->addFieldToTab("Root.Images",new HeaderField("ImageNote","Page image",3));
	 	$fields->addFieldToTab("Root.Images",$imageField);
	 	$fields->addFieldToTab("Root.Images",new LiteralField("ImageNote2","<br/>"));
	 	$fields->addFieldToTab("Root.Images",new HeaderField("ImageNote3","Page gallery",3));
//	 	$fields->addFieldToTab("Root.Images",$photoManager);
	 	
	 	$fields->addFieldToTab("Root.Main", new TextareaField("CustomHtml","Custom HTML code",4));
	 	
		return $fields;
	}
	
	public function onBeforeWrite () {
		$this->MetaTitle = $this->Title;
		parent::onBeforeWrite();
	}
	
    public function IsAdmin() {
      return Permission::check('ADMIN') ? 1 : 0;
     }

	public function canDelete($member = null) {
		return Permission::check('ADMIN');
	}
		
}
class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
		//	'LoginForm',
		//'SiteSearchForm',
		//'doSearchResults'
		'index'
	);

	public function init() {
		parent::init();
	}
	
	function Siblings() {
		if($this->ParentID) {
		  $whereStatement = "ClassName!='ErrorPage' AND ParentID = ".$this->ParentID;
		  return DataObject::get("Page", $whereStatement);
		 }
	 }
	 
	 function getMetaTitle() {
	 	return $this->Title;
	 }
	
	public function setMessage($type, $message)
	   {   
	   	   $message = array(
	   	       'MessageType' => $type,
	   	       'Message' => $message
	   	   );
	   	   $messageArray = array();
	   	   if($tmp = Session::get("Message")) {
	   	     $messageArray = $tmp;
	   	   }
	   	   $messageArray[] = $message;	   	   
	       Session::set('Message', $messageArray);
	   }
	
	public function getMessage(){
		if($message = Session::get('Message')){
			$array = new ArrayList($message);
			Session::clear('Message');
			return $array->renderWith('Message');
		}
	}
	
	public function IsAdmin() {
	  return Permission::check('ADMIN');
	 }
	
	public function YouTubeID($embedcode) {
		preg_match('/youtube[.]com\/(v|embed)\/([^"?]+)/', $embedcode, $match);
		return $match[2];
	}
	
	function ThumbnailURL() {
		if($this->VideoEmbed) {
			return "http://img.youtube.com/vi/".$this->YouTubeID($this->VideoEmbed)."/0.jpg";
		}
		if(!$this->Image() && !$this->Images()) {
			return "http://www.mundotrevi.com/assets/images/MundoTrevi.jpg";
		}
	}
	
	public function PageById($id) {
		$page = DataObject::get_by_id("SiteTree",$id);
		if($page) {
			return $page;
		}
	}
	
	/* CHALLENGE CONTROLS */
	
	public function RandomSuperChallenge() {
		return SuperChallenge::get()->sort("RAND()")->limit(1)->First();
	}
	
	public function StripeCharge($stripeToken="", $amount=0, $description="", $storeUser = true) {
		
		if(!$stripeToken || !$amount || !$description) {
			return false;
		}
		
		require_once dirname(__FILE__).'/controllers/stripe/lib/Stripe.php';
		Stripe::setApiKey(STRIPE_SECRET_KEY);
		
		$member = Member::currentUser();
		
		$details = array();
		
		if($storeUser) {
		
			$userID = $member->StripeUserID;
			if($userID=="") {
//				echo("Create stripe customer");
				$customer = Stripe_Customer::create(array(
				  "card" => $stripeToken,
				  "description" => $member->getName(),
				  "email" => $member->Email,
				  "metadata" => array("Username" => $member->Username)
				  )
				);
				$member->StripeUserID = $customer->id;
				$member->write();
			}
			else {
				$customer = Stripe_Customer::retrieve($userID);
				if($member->StripeUserID != $customer->id) {
					$member->StripeUserID = $customer->id;
					$member->write();
				}
			}
			
			$details = array(
			  "amount" => $amount, // amount in cents
			  "currency" => "usd",
			  "customer" => $customer->id,
//			  "card" => $stripeToken,
			  "description" => $description
			);
		
		}
		else {
			$details = array(
			  "amount" => $amount, // amount in cents, again
			  "currency" => "usd",
//			  "customer" => $customer->id,
			  "card" => $stripeToken,
			  "description" => $description
			);
		}	
			
		try {
			$charge = Stripe_Charge::create($details);
			if($charge) {
				return true;
			}
		}
		catch(Stripe_CardError $e) {
		  $this->setMessage("danger","The card has been declined.");
		  return false;
		}
		
	}
	
}



class TempPage extends Page {
	
}

class TempPage_Controller extends Page_Controller {

	function init() {
		parent::init();
	}
	
}