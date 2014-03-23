<?

class ScoreCategory extends DataObject {

//	public static $allowed_actions = array (
//		'like',
//		'unlike'
//	);
	
	private static $db = array(
		'Title' => 'Varchar(96)',
		'Description' => 'Varchar(255)',
		'MaxPoints' => 'Int'
	);
	
	private static $indexes = array(
//		'URLSegment' => true
	);
	
	private static $has_one = array(
		'ChallengeCategory' => 'ChallengeCategory'
	);
	
	private static $has_many = array(
		'SubmissionScores' => 'SubmissionScore'
	);
	
	private static $api_access = array(
       'view' => array('Title'),
       'edit' => array('Title'),
       'like' => array(),
       'unlike' => array()
   );
	
	private static $defaults = array(
	);
	
	private static $summary_fields = array(
		'ID',
		'Title',
		'MaxPoints'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName("ChallengeCategory");
		return $fields;
	}
	
	function onBeforeWrite() {
		parent::onBeforeWrite();
//		if(!$this->ID) {
//			$this->MemberID = Member::currentUserID();
//		}
	}
	
	function onAfterWrite() {
		parent::onAfterWrite();
		if($this->ChallengeCategoryID) {
			$this->ChallengeCategory()->write();
		}
	}
		
}