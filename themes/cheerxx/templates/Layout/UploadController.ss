<div class="row layout">
<div class="large-9 large-centered columns">
	<h1>$Title</h1>
	$Message
	$Content
	<hr />
	<div class="row">
		<div class="medium-6 columns <% if not SuperChallenges %>medium-centered<% end_if %>">
			<h3>Coaching requests</h3>
			<% if CoachingCategories %>
			<% loop CoachingCategories %>
				<a href="upload/submit?c=CoachingCategory&sid=$ID">
				<div class="row">
					<div class="small-3 columns">
						<center><div class="round-image round-small" style="<% with Image %>background-image:url('$CroppedImage(200,200).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div></center>
					</div>
					<div class="small-9 columns">
						<h4>$Title</h4>
						<span class="button radius nopadding">Upload now <% if IsPayable %>(<strong>$Price.Nice</strong>)<% end_if %></span>
					</div>
				</div>
				</a>
			<% end_loop %>
			<% end_if %>
		</div>
		<div class="medium-6 columns">
			<% loop SuperChallenges %>
				<h3>$Title</h3>
				<% loop Challenges %>
					<a href="upload/submit?c=Challenge&sid=$ID">
					<div class="row">
						<div class="small-3 columns">
							<center><div class="round-image round-small" style="<% with FirstImage.Image %>background-image:url('$CroppedImage(200,200).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div></center>
						</div>
						<div class="small-9 columns">
							<h4>$Title</h4>
							<span class="button radius nopadding">Upload now <% if IsPayable %>(<strong>$Price.Nice</strong>)<% end_if %></span>
						</div>
					</div>
					</a>
				<% end_loop %>
				
				<% if Last==false %><hr /><% end_if %>
			<% end_loop %>
		</div>
	</div>
	
</div>
</div>