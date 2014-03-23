<?php

class ContestPage extends Page implements PermissionProvider {

   	private static $db = array(
   	);
	
	private static $has_many = array(
	);
	
//	static $defaults = array(
//	);
		
//	static $allowed_children = array("none");
	
//	function DropdownTitle() {
//		$String = '' . $this->Parent()->Title . ' --- ' . $this->Title;
//		return $String;
//	}
	
//	function providePermissions() {
//	    return array(
//	      "POST_ContestS_FRONTEND" => "Post Contests on frontend",
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
//	  	return DataObject::get("ContestPage");
//	  }
}
 
class ContestPage_Controller extends Page_Controller {

	private static $allowed_actions = array(
		'contest',
		'NewContestForm'
	);

//	public function getContestPage() {
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
//			$filter.=" AND ContestPageID IN(".$this->AggregateCategories.")";
//		}
//		else {
//			$filter.=" AND ContestPageID=$this->ID";
//		}
//		$ContestPage = DataObject::get("Contest",$filter,"","","{$SQL_start},10");
//		if($ContestPage) {
//			return $ContestPage;
//		}
//	}
	
	function contest()
	{	
		if($Item = $this->getCurrentItem()) {
			$Data = array(
				'Title' => $Item->Title,
				'Content' => $Item->Content,
				'MetaTitle' => $Item->Title,
				'Images' => $Item->Images(),
				'ImageCount' => $Item->Images()->Count(),
				'Item' => $Item,
				'ThumbnailURL' =>$Item->ThumbnailURL(),
				'AbsoluteLink' =>$Item->AbsoluteLink()
			);
			return $this->customise($Data)->renderWith(array('Contest','Page'));	
		}
	    else {
			return $this->httpError(404, _t("Blog.NOTFOUND","Blog entry not found."));
		}
	}
	
	public function getCurrentItem()
	    {
	        $Params = $this->getURLParams();
	        $URLSegment = Convert::raw2sql($Params['ID']);  
			if($URLSegment && $Item = DataObject::get_one('Contest',
	        	"URLSegment = '" . $URLSegment . "'"))
			{       
			return $Item;
		}
	}
	
	function NewContestForm() 
		{
			$imageField= new MultipleFileUploadField('Images', 'Upload images');
			$imageField->setUploadFolder('images/posts');
	      	// Create fields
		    $fields = new FieldSet(
				new TextField('Title',"Titulo"),
				new HtmlEditorField('Content',"Contenido",8),
				new HeaderField("Imagenes",5),
				$imageField,
				new TextareaField('VideoEmbed','Embed Code YouTube'),
				new HiddenField('ContestPageID', "", $this->ID),
				new CheckboxField('Featured','Feature on Inicio',1)
			);
		 	
		    $sendAction = new FormAction('doSubmitContest', 'Añadir entrada');
		    $sendAction->extraClass("round");
		    $actions = new FieldSet(
		    	$sendAction
		    );
			
			//$validator = new RequiredFields('');
							
		    return new Form($this, 'NewContestForm', $fields, $actions);
		}
	 	
		function doSubmitContest($data, $form) {
		 			 
	         $newContest = new Contest();
	         $form->saveInto($newContest);
	         $newContest->write();
	         
	         $link = $newContest->absoluteLink();
	        $this->setMessage("success","<h3>Nueva entrada con titulo '<strong>".$data["Title"]."</strong>' fue publicada!</h3><p><a href='".$link."'>Vista previa aquí.</a></p>");
		    Director::redirectBack();
		}
	
//	public function nuevo()
//	{	
//		Validator::set_javascript_validation_handler('none'); 
//		//Requirements::javascript("http://ajax.microsoft.com/ajax/jquery.validate/1.8/jquery.validate.min.js");
//		if(Permission::check('POST_ContestS_FRONTED')) {
//			$Data = array(
//				'MetaTitle' => "Nueva entrada",
//				'Title' => "Nueva entrada",
//				'Form' => $this->NewContestForm(),
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
		$p = DataObject::get("Contest","Featured=1 AND Published=1","Created DESC","",$n);
		if($p) {
			return $p;
		}
	}
	
}

