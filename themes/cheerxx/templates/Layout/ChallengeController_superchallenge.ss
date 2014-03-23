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
			
			<% if Status==1  %>
				<span class="shadow">$ContentUpcoming</span>
			<% else_if Status==2 %>
				<span class="shadow">$ContentActive</span>
				<a href="#challenges" class="button radius alert">Submit your video</a>
			<% else_if Status==3 %>
				<span class="shadow">$ContentClosed</span>
			<% end_if %>
		</div>
	</div>

</section>

<div class="layout">

<% if Status==1  %>
	
<% else %>

	<section class="row main" >
		<h2 id="challenges">Open challenges</h2>
		<ul class="large-block-grid-3 blockgrid">
			<% loop Challenges %>
			<li>
				<a href="$Link" class="th">
					<% if Images %>
						<% with Images.First.Image %>$CroppedImage(480,270)<% end_with %>
					<% else %>
						<img src="http://placehold.it/480x270/EEEEEE&text=+" />
					<% end_if %>
				</a>
				<a href="$Link">
					<h5>$Title</h5>
				</a>
			</li>
			<% end_loop %>
		</ul>
		
		<h2>Past challenges</h2>
		<ul class="large-block-grid-6 small-block-grid-2 blockgrid">
			<% loop Challenges %>
			<li>
				<a href="$Link" class="th">
					<% if Images %>
						<% with Images.First.Image %>$CroppedImage(480,270)<% end_with %>
					<% else %>
						<img src="http://placehold.it/480x270/EEEEEE&text=+" />
					<% end_if %>
				</a>
				<a href="$Link"><h6>$Title</h6></a>
			</li>
			<% end_loop %>
		</ul>
		
		
		
	</section>

<% end_if %>
	
	<% include Comments %>
		

</div>

<% end_with %>



