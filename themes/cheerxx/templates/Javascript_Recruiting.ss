<% if not CurrentMemberProfile %>

<script src="plugins/foundation/js/foundation/foundation.abide.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
	  
	  Stripe.setPublishableKey("{$StripePublishableKey}");
	  var stripeResponseHandler = function(status, response) {
	    var form = \$('#Form_RegisterForm');
	  
	    if (response.error) {
	      // Show the errors on the form
	      \$('.payment-errors').text(response.error.message).addClass("alert").addClass("alert-box");
	      form.find('button').attr('disabled', false);
	    } else {
	      // token contains id, last4, and card type
	      var token = response.id;
	      // Insert the token into the form so it gets submitted to the server
	      form.append(\$('<input type="hidden" name="stripeToken" />').val(token));
	      // and submit
	      form.get(0).submit();
	    }
	  };
	  
	  jQuery(function(\$) {
	  	
	  	\$('#Form_RegisterForm').submit(function(e){
	  		e.preventDefault();
	  		\$(this).find('button').attr('disabled', "disabled");
  			Stripe.card.createToken(\$(this), stripeResponseHandler);
	  	 });
	  	
	  });
	  
</script>
<% end_if %>