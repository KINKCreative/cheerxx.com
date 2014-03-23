<?php

class PaymentController extends Page_Controller {
	
	
		public static $allowed_actions = array (
			'index'
		);
	
		public function init() {	
			require_once 'stripe/lib/Stripe.php';
			Vzaar::$token = VZAAR_TOKEN;
			parent::init();
		}
		
		const URLSegment = '/payment';
		
		public function getURLSegment() { 
			return self::URLSegment; 
		}
		
		public function Link($action = null, $id = null) {
			//$action = $this->request->param('Action');
			//$id = $this->request->param('ID');
			return Controller::join_links(self::URLSegment, $action, $id);
		} 
		
		
		public function index() {
			
			// Set your secret key: remember to change this to your live secret key in production
			// See your keys here https://manage.stripe.com/account
			Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
			
			// Get the credit card details submitted by the form
			$token = $_POST['stripeToken'];
			$amount = $_POST['amount'];
			$paymentFor = $_POST['paymentFor'];
			
			// Create the charge on Stripe's servers - this will charge the user's card
			try {
			$charge = Stripe_Charge::create(array(
			  "amount" => 1000, // amount in cents, again
			  "currency" => "usd",
			  "card" => $token,
			  "description" => "payinguser@example.com")
			);
			} catch(Stripe_CardError $e) {
			  $this->setMessage("danger","The card has been declined.");
			  echo("The card has been declined.");
			}
			
			 return false;
		}
				

}