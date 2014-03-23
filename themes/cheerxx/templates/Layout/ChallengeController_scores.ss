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
		<div class="large-12">
			<h2>All submissions <a href="$Link" class="button small radius">Return to competition</a></h2>
			$Message
		
			<% if AdminSubmissions %>
			<table class="scoretable">
				<thead>
					<tr>
					<td>
						#
					</td>
					<td>
						User
					</td>
					<td>
						Submitted
					</td>
					<td>
						Likes
					</td>
					<td>
						Eval. points
					</td>
					<td>
						Total
					</td>
					</tr>
				</thead>
				<% loop AdminSubmissions %>
				<tr>
					<td>
						<a href="$Link" class="th">
							<img src="$ThumbnailURL" height="40">
						</a>
					</td>
					<td>
						by <strong>$Member.Name</strong>
					</td>
					<td>
						<strong>$Created.Ago</strong>
					</td>
					<td>
						<strong>$LikeTotal</strong><i class="icon-thumbs-up"></i>
					</td>
					<td>
						<strong>$PointScore</strong>
					</td>
					<td>
						<% if IsScored %>
							<strong>$TotalScore</strong></td>
						<% else %>
							Unscored
						<% end_if %>
					</td>
				</tr>	
				<% end_loop %>
			</table>
			<p class="text-right">out of $Target.ChallengeCategory.TotalScore pts.</p>
			<% else %>
			<% end_if %>
			
		<% end_with %><!-- END ITEM -->
		
	</section>
	
	<% include Comments %>		

</div>



