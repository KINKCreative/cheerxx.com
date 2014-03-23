<?php

class CoachingPage extends Page implements PermissionProvider {

   	private static $db = array(
   	);
	
	private static $has_many = array(
	);
	
//	static $defaults = array(
//	);
		
//	private static $allowed_children = array("none");
	
//	function DropdownTitle() {
//		$String = '' . $this->Parent()->Title . ' --- ' . $this->Title;
//		return $String;
//	}
	
//	function providePermissions() {
//	    return array(
//	      "POST_CoachingS_FRONTEND" => "Post Coachings on frontend",
//	    );
//	  }
	  
	  public function getCMSFields() {
	  	$fields = parent::getCMSFields();
//	  	$categories = $this->Categories();
//	  	if($categories) {
//	  		$fields->addFieldToTab("Root.Content.Categories", 
//	  			new CheckboxSetField("AggregateCategories","Gather other categories",$categories->toDropdownMap("ID","Title"))
//	  		);
//	  	}
	  	return $fields;
	  }
	  
//	  public function Categories() {
//	  	return DataObject::get("CoachingPage");
//	  }
}
 
class CoachingPage_Controller extends Page_Controller {

	private static $allowed_actions = array(
		'index',
		'submit'
	);
	
	public function Categories() {
		return $p = CoachingCategory::get()->sort("Title ASC");
	}
//	public function getCoachingPage() {
//		
//		if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) 
//	    {
//	        $_GET['start'] = 0;
//	    }
//		
//		$SQL_start = (int)$_GET['start'];
//		
//		$filter = "Published=1 ";
//		if($this->AggregateCategories!="") {
//			$filter.=" AND CoachingPageID IN(".$this->AggregateCategories.")";
//		}
//		else {
//			$filter.=" AND CoachingPageID=$this->ID";
//		}
//		$CoachingPage = DataObject::get("Coaching",$filter,"","","{$SQL_start},10");
//		if($CoachingPage) {
//			return $CoachingPage;
//		}
//	}
	
	function submit()
	{	
		return array(
			"Title" => "Submit your coaching request",
			"MetaTitle" => "Submit your coaching request"
		);
	}
	
	function NewCoachingForm() 
		{
//			$fileField= new FileUploadField('File', 'Upload your video');
//			$fileField->setUploadFolder('images/posts');
	      	// Create fields
		    $fields = new FieldList(
		    	new TextField("Name","Your name", Member::currentUser()->Name),
				new TextField('Skill',"Skill performed"),
				new TextareaField('Content',"Describe your problem",8),
				new TextareaField('VideoEmbed','Embed your stunt video'),
				new HiddenField('CoachingPageID', "", $this->ID)
//				new CheckboxField('Featured','Feature on Inicio',1)
			);
		 	
		    $sendAction = new FormAction('doSubmitCoaching', 'Submit your video');
		    $sendAction->extraClass("round");
		    $actions = new FieldList(
		    	$sendAction
		    );
			
			//$validator = new RequiredFields('');
							
		    return new Form($this, 'NewCoachingForm', $fields, $actions);
		}
	 	
		function doSubmitCoaching($data, $form) {
		 			 
	         $newCoaching = new Coaching();
	         $form->saveInto($newCoaching);
	         $newCoaching->write();
	         
	         $link = $newCoaching->absoluteLink();
	        $this->setMessage("success","<h3>Nueva entrada con titulo '<strong>".$data["Title"]."</strong>' fue publicada!</h3><p><a href='".$link."'>Vista previa aquí.</a></p>");
		    Director::redirectBack();
		}
	
//	public function nuevo()
//	{	
//		Validator::set_javascript_validation_handler('none'); 
//		//Requirements::javascript("http://ajax.microsoft.com/ajax/jquery.validate/1.8/jquery.validate.min.js");
//		if(Permission::check('POST_CoachingS_FRONTED')) {
//			$Data = array(
//				'MetaTitle' => "Nueva entrada",
//				'Title' => "Nueva entrada",
//				'Form' => $this->NewCoachingForm(),
//				'ProvideComments' => false
//			);
//			return $this->customise($Data)->renderWith('Page');
//		}
//		else {
//			$this->SetMessage('error','No puedes añadir entradas.');
//			Director::redirectBack($this->Link());
//		}
//	}
	
	public function FeaturedPost($n=1) {
		$p = DataObject::get("Coaching","Featured=1 AND Published=1","Created DESC","",$n);
		if($p) {
			return $p;
		}
	}
	
}

