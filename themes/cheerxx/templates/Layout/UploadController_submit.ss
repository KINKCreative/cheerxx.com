<div class="layout">
<div class="row">
<div class="large-9 large-centered columns">
	<h1>Upload your video</h1>
	$Message
	
	<div class="panel callout radius uploadwrap">
			
		$UploadForm
		
		
		
		<!-- <form enctype="multipart/form-data" method="post" action="https://{$bucket}.s3.amazonaws.com/">
			  <input name="key" value="$key" type="hidden" />
			  <input name="AWSAccessKeyId" value="$accesskeyid" type="hidden" /> 
			  <input name="acl" value="$acl" type="hidden" /> 
			  <input name="policy" value="$policy" type="hidden" />
			  <input name="success_action_redirect" value="http://cheerxx.com/upload?done=1" type="hidden" />
			  <input name="success_action_status" value="201" type="hidden" />
			  <input name="signature" value="$signature" type="hidden" />
		
		      File to upload to S3: 
		      <input name="file" type="file" /> 
		      <br /> 
		      <input value="Upload File to S3" type="submit" /> -->
		
		
		<!-- <button type="submit" value="Upload" class="button radius uploadButton">Submit</button>
		<input type="file" name="file" id="file" required accept="video/*" />
		<form id="uploadform" enctype="multipart/form-data" method="post" data-abide>
		<div class="row">
		  <label for="title">Enter description</label>
		  <textarea rows="4" cols="50" name="description" type="text" required pattern="[a-zA-Z]+"></textarea>
		  <small class="error">Enter your description.</small>
		  
		</div>
		<div id="fileName"></div>
		<div id="fileSize"></div>
		<div id="fileType"></div>
		<div class="row">
			
		</div>
		</form> -->
		
	</div>
	<div class="primary text-center">
		<p>You will only be charged after your video successfully uploads. Please make sure to follow our <a href="#">uploading guidelines here</a>. If you have any questions, feel free to <a href="#">send us an e-mail</a>.</p>
	</div>

</div>
</div>
</div>

<div class="safety">
<div class="row">
<div class="large-12 columns">
	<h3><i class="icon-credit-card"></i> Secure payments with <strong>stripe.com</strong></h3>
	<p>All credit card orders are safely processed via <strong>stripe.com</strong>.</p>
	<div class="row">
		<div class="large-4 columns">
			<h4><i class="icon-lock"></i> Safe</h4>
			<p>A safe security token is generated with Stripe and used when making the charge. No sensitive data ever enters our servers.</p>
		</div>
		<div class="large-4 columns">
			<h4><i class="icon-ok-circled"></i> Trusted</h4>
			<p>Thousands of small and large companies use Stripe to power commerce for their business.</p>
		</div>
		<div class="large-4 columns">
			<h4><i class="icon-bookmark"></i> Certified PCI level 1</h4>
			<p>Stripe is certified to PCI Service Provider Level 1, the most stringent level of certification.</p>
		</div>
	</div>
	<p>Read more about Stripe <a href="http://www.stripe.com" target="_blank">here</a> and <a href="https://stripe.com/help/security" target="_blank">here</a>.</p>
	
</div>
</div>
</div>

<div id="uploadmodal" class="reveal-modal medium" data-reveal>
	<div class="progress round">
	  <span class="meter" style="width:0;"></span>
	</div>	
	<h1 class="percentage">0%</h1>
	<h3>Upload in progress.</h3>
	<p>Do not press refresh or close window.</p>
</div>