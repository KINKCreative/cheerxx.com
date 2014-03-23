<?php

class Search_Controller extends Page_Controller {

	public static $allowed_actions = array (
		'index'
	);

	public function init() {	
		parent::init();
	}
	
	const URLSegment = '/search';
	
	public function getURLSegment() { 
		return self::URLSegment; 
	}
	
	public function Link($action = null, $id = null) {
		//$action = $this->request->param('Action');
		//$id = $this->request->param('ID');
		return Controller::join_links(self::URLSegment, $action, $id);
	} 
	
	
	public function index() {
		$q="";
		if(isset($_GET["q"])&& $_GET["q"]!="") {
			$q = convert::raw2sql($_GET["q"]);
			$fword = "'%$q%'";
			$query = "Title LIKE $fword";
			
			$results = new DataObjectSet();
			$pages = DataObject::get("Page",$query,"Title ASC");
			$articles = DataObject::get("Article",$query,"Title ASC");
			$results->merge($articles);
			$results->merge($pages);
			
			return $this->customise( new ArrayData(array( 
				"Title" => "Search results for '$q'",
				"SearchResults" => $results
			)))->renderWith(array('SearchResults', 'Page'));
		}
		else {
			return array(
				"Title" => "Search query required",
				"Content" => "Please enter a search query and try again."
			); 
		}
	}
	
	public function SearchTerm() {
		$q="";
		if(isset($_GET["q"])) {
			return $q;
		}
	}
	
}