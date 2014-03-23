<!-- <link href="plugins/jquery-socialist/jquery.socialist.css" rel="stylesheet" />
<script src='plugins/jquery-socialist/jquery.socialist.js'></script> -->

<% with Item %>

<% include Heading %>

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
						Points
					</td>
					<td>
						Edit/score
					</td>
					</tr>
				</thead>
				<% loop AdminSubmissions %>
				<tr class="<% if IsScored %><% else %>unscored<% end_if %>">
					<td>
						<a href="$Link" class="th">
							<img src="$ThumbnailURL" height="40">
						</a>
					</td>
					<td>
						by <strong>$Member.Name</strong>
					</td>
					<td>
						<strong>$Created.Nice</strong>
					</td>
					<td>
						<strong>$LikeTotal</strong><i class="icon-thumbs-up"></i>
					</td>
					<td>
						<% if IsScored %>
							<strong>$TotalScore</strong> / $Target.ChallengeCategory.TotalScore pts.</td>
							<td><a href="$Link" target="_blank" class="button tiny radius">Edit score</a>
						<% else %>Unscored
							<td><a href="$Link" target="_blank" class="button tiny radius">Score video</a>
						<% end_if %>
					</td>
				</tr>	
				<% end_loop %>
			</table>
			<% else %>
			<% end_if %>
			
		<% end_with %><!-- END ITEM -->
		
	</section>
	
	<% include Comments %>		

</div>



