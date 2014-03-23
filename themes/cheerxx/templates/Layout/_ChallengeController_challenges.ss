<link href="plugins/jquery-socialist/jquery.socialist.css" rel="stylesheet" />
<script src='plugins/jquery-socialist/jquery.socialist.js'></script>

<% with Item %>

<section class="header" style="background-image:url(<% with Images.First.Image %>$CroppedImage(800,600).URL<% end_with %>);">
	
	<div class="row">
		<h1 class="shadow">$Title</h1>
		<div class="large-6 columns">
			<div class="flex-video widescreen">
				$VideoEmbed.RAW
			</div>
		</div>
		<div class="large-6 columns">
			
		</div>
	</div>

</section>

<div class="layout">

	<section class="row main" data-speed="5" data-type="background">
		<h2>Submitted videos</h2>
		
		
		
	</section>
			
		

</div>

<% end_with %>



