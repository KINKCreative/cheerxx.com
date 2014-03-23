<?

class Video extends DataObject {
	
	public static $allowed_actions = array (
		'like',
		'unlike'
	);
	
	protected $urlPrefix = "v/";
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'URLSegment' => 'Varchar(16)',
		'VzaarID' => 'Varchar(12)',
		'Description' => 'Text',
		'ThumbnailURL' => 'Varchar(255)',
		'FramegrabURL' => 'Varchar(255)',
		'LikeTotal' => 'Int',
		'FavoriteTotal' => 'Int',
		'Status' => 'Enum(array("New","Pending","Published","Blocked"))'
	);
	
	private static $indexes = array(
		'URLSegment' => true
	);
	
	private static $has_one = array(
		'Member' => 'Member'
	);
	
	private static $api_access = array(
       'view' => array('Title'),
       'edit' => array('Title'),
       'like' => array(),
       'unlike' => array()
   );
	
	private static $defaults = array(
		'Status' => 'New',
		'Title' => "New video"
	);
	
	private static $summary_fields = array(
		'ID',
		'Title',
		'URLSegment',
		'VzaarID',
		'LikeTotal'
	);
	
	private static $belongs_many_many = array(
		'Likes' => 'Member'
//		'Favorites' => 'Member.Favorites'
	);
	
	private static $many_many = array(
		'Favorites' => 'Member'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName("Root.Likes");
		$fields->removeByName("Root.Favorites");
		return $fields;
	}
	
	function onBeforeWrite() {
		parent::onBeforeWrite();
		if(!$this->ID) {
			$this->MemberID = Member::currentUserID();
		}
	}
	
	function onAfterWrite() {
		if(!$this->URLSegment) {
			$this->URLSegment = $this->generateURL();
			$this->write();
		}
		if($this->Title=="New video") {
			$this->Title = "Video #".$this->ID;
		}
		parent::onAfterWrite();
	}
	
	protected function generateURL() {
		$hash = substr(base_convert(md5($this->ID), 16, 36), 0, 5);
		return $hash;
	}
	
	public function AbsoluteLink() {
		return "http://www.cheerxx.com/".$this->Link();
	}
	
	public function Link() {
		return $this->urlPrefix.$this->URLSegment;
	}
	
	function like() {
		$member = Member::currentUser();
		if($member) {
			try {
				$this->Likes()->add($member);
				$this->LikeTotal = $this->Likes()->count();
				$this->write();
				echo(json_encode(array("success","You liked this video.",$this->LikeTotal)));
				return null;
			}
			catch (Exception $e) {
			    echo(json_encode(array("error","Error: ".$e)));
			    return null;
			}
		}
		return false;
	}
	
	function unlike() {
		$member = Member::currentUser();
		if($member) {
			try {
				$this->Likes()->remove($member);
				$this->LikeTotal = $this->Likes()->count();
				$this->write();
				echo(json_encode(array("success","You unliked the video.",$this->LikeTotal)));
			}
			catch (Exception $e) {
			    echo(json_encode(array("error","Error: ".$e)));
			}
		}
	}
	
	
	function favorite() {
		$member = Member::currentUser();
		if($member) {
			try {
				$this->Favorites()->add($member);
				$this->FavoriteTotal = $this->Favorites()->count();
				$this->write();
				echo(json_encode(array("success","You added this video to your favorites.",$this->FavoriteTotal)));
				return null;
			}
			catch (Exception $e) {
			    echo(json_encode(array("error","Error: ".$e)));
			    return null;
			}
		}
		return false;
	}
	
	function unfavorite() {
		$member = Member::currentUser();
		if($member) {
			try {
				$this->Favorites()->remove($member);
				$this->FavoriteTotal = $this->Favorites()->count();
				$this->write();
				echo(json_encode(array("success","You removed the video from your favorites.",$this->FavoriteTotal)));
			}
			catch (Exception $e) {
			    echo(json_encode(array("error","Error: ".$e)));
			}
		}
	}
	
	function playcount() {
//		echo (strtotime($this->LastEdited) - strtotime('-2 minutes'));

		require_once dirname(__FILE__).'/../controllers/vzaar/Vzaar.php';
		Vzaar::$token = VZAAR_TOKEN;
		Vzaar::$secret = VZAAR_SECRET;
		try {
			$count = Vzaar::getVideoDetails($this->VzaarID)->playCount;
			echo(json_encode(array("playCount" => $count)));
			$this->PlayCount = $count;
			$this->write();
			return null;
		}
		catch (Exception $e) {
		    echo(json_encode(array("error","Error: ".$e)));
		    return null;
		}
//		}
	}
	
	function canView($member = NULL){ 
		return true; 
	}
	
	function ThumbnailURL() {
		return "http://view.vzaar.com/".$this->VzaarID."/thumb";
	}
	
	function UserLikes() {
		$memberID = Member::currentUserID();
		$likes = $this->Likes()->where("MemberID = $memberID")->first();
		if($likes) {
			return true;
		}
		return false;		
	}
	
	function UserFavorite() {
		$memberID = Member::currentUserID();
		$favorited = $this->Favorites()->where("MemberID = $memberID")->first();
		if($favorited) {
			return true;
		}
		return false;		
	}

}