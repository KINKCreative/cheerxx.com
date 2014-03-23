<!-- <link href="plugins/jquery-socialist/jquery.socialist.css" rel="stylesheet" />
<script src='plugins/jquery-socialist/jquery.socialist.js'></script> -->

<% with Item %>

<section class="header">
	
	<div class="row">
		<h1 class="shadow">$ShowDisplayTitle <% with SuperChallenge %><small><a href="$Link">$Title</a></small><% end_with %></h1>
		<div class="large-6 columns">
			<div class="flex-video widescreen">
				$VideoEmbed.RAW
			</div>
		</div>
		<div class="large-6 columns">
			$Content
			<p>
				<% if CanSubmit %>
					<a href="upload/submit?c=Challenge&sid={$ID}" class="button small radius alert"><i class="icon-upload-cloud"></i> Submit your video</a>
				<% else %>
					<strong>You have already submitted for this challenge.<strong></p>
						<p>
							<% with UserSubmission %><a href="$Link" class="button radius small alert"><i class="icon-eye"></i> View your submission</a><% end_with %>
				<% end_if %>
				<% with SuperChallenge %><a href="$Link" class="button radius small secondary"><i class="icon-angle-circled-left"></i>Return to competition</a><% end_with %>
			</p>
		</div>
	</div>

</section>

<div class="layout">

	<section class="row main">
	
		$Message
		
		<% if Top.UserCanScore %>
			<p>View list of all submissions for scoring. <a href="$Link?adminview=1" class="button radius">Admin view</a></p>
		<% end_if %>
	
		<h2>Recent submissions</h2>
		<% if RecentSubmissions %>
		<ul class="large-block-grid-7 small-block-grid-3 blockgrid">
			<% loop RecentSubmissions %>
			<li>
				<a href="$Link" class="th">
					<img src="$ThumbnailURL">
				</a>
				<p class="details"><strong>$Created.Ago</strong><br/>by <strong><a href="$Link">$Member.Username</a></strong></p>
			</li>
			<% end_loop %>
		</ul>
		<% else %>
		<% end_if %>
		
		<% end_with %><!-- END ITEM -->
		
	</section>
	
	<% include Comments %>		

</div>



