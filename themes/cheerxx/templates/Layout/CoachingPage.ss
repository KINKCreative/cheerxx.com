<!-- <section class="header" style="background: #000 url(http://www.lorempixel.com/1800/300) no-repeat top center; height: 300px;" data-speed="10" data-type="background"></section> -->


<div class="layout">
<!-- STAFF PICKS - PROJECT -->

<section class="row main">
	<div class="large-12 columns">
		<h1 class>$Title</h1>
		$Content
		
		<hr />
		
		<div class="row">
		<div class="large-12 columns">
		
		<ul class="medium-block-grid-3">
		<% if Categories %>
		<% loop Categories %>
					<li>
					<center><div class="round-image" style="<% with Image %>background-image:url('$CroppedImage(600,600).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div></center>
					<h2 class="text-center">$Title</h2>
					<ul class="pricing-table">
					  $Content.RAW
					  <li class="price">$Price.Nice</li>
					  <li class="cta-button">
					  		<a href="upload/submit?c=CoachingCategory&sid={$ID}" class="button primary radius"><strong>Submit now</strong><br/><small>to improve your techinque</small></a>
					  		
					  		<!-- <form action="$Top.Link/payment" method="POST">
					  		  <script
					  		    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					  		    data-key="pk_test_0uyDEsAxKSPpeuI6Aml0D8bj"
					  		    data-amount="$CentPrice"
					  		    data-name="CheerXX"
					  		    data-description="$Title"
					  		    data-image="<% with Image %>$CroppedImage(100,100).URL<% end_with %>"
					  		    data-email="$CurrentUser.Email"
					  		    >
					  		  </script>
					  		  <input name="paymentFor" value="CoachingSubmission" type="hidden" />
					  		  <input name="forID" value="$ID" type="hidden" />
					  		  <input name="amount" value="$CentPrice" type="hidden" />
					  		  
					  		</form> -->
					  </li>
					</ul>
					</li>
		<% end_loop %>
		</ul>
		<% end_if %>
		<hr />
		</div>
		</div>
		
	</div>
</section>

</div>



