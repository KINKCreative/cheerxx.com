<% with Profile %>

<% include Heading %>

<div class="profilebackground $Gender">
	<div class="row">
		<div class="medium-4 columns">
			$Images.First.CroppedImage(400,400)
		</div>
		<div class="medium-8 columns">
			<h2>
				$FirstName $LastName
			</h2>
			<p> <span class="label secondary radius">$Gender</span> 
				<% if IsFlyer %><span class="label radius extra">flyer</span><% end_if %>
				<% if IsBase %><span class="label radius extra">base</span><% end_if %>
				<br/>
				Hometown: <strong>$Hometown</strong>
				<% if School %><br/>School: <strong>$School</strong><br/><% end_if %>
			</p>
			
		</div>
	</div>
</div>

<div class="layout $Gender">
	<div class="row">
		<div class="large-8 columns">
			
			<article>
				$Message
				
				<% if ProfileText %>
					<h2>About me</h2>
					<div class="content">$ProfileText</div>
					<hr/>
				<% end_if %>
				
				<h2>My skills</h2>
				<ul class="large-block-grid-2">
				<% loop GroupedSkills %>
					<li>
					<h3>$Category.Title</h3>
					<div class="skillScore" data-score="$TotalScore"></div>
					<% loop Skills %>
						<% if First %>
						<div data-score="$CategoryScore"></div>
						<ul class="skills">
						<% end_if %>
							<li><i class="icon-ok-circled"></i> $Title</li>
						<% if Last %>
							</ul>
						<% end_if %>
					<% end_loop %>
					</li>
				<% end_loop %>
				</ul>
				<hr/>
				
				<h3>Colleges I am interested in</h3>
				<div class="content">$CollegesInterested</div>
				
				
				$Form
				<!-- <p class="text-centered">
					<a href="{$Link}register" class="button primary radius" title="Register now"><strong>Register now</strong> - click here <i class="icon-angle-circled-right"></i></a>
					<a href="{$Link}editprofile" class="button secondary radius" title="Edit profile"><strong>Edit your profile</strong> <i class="icon-angle-circled-right"></i></a>
				</p> -->
			</article>
		</div>
		<div class="large-4 columns">
			<div class="panel radius">
				<h3>Interested in $FirstName $LastName?</h3>
				<p>Drop <% if Gender=="Boy"%>him<% else %>her<% end_if %> a note here. (coming soon)</p>
			</div>
		</div>
	</div>
</div>

<% end_with %>