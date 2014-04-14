<section class="header">
	<div class="row">
		<div class="large-8 columns">
			<h1>$Title</h1>
		</div>
		<div class="large-4 columns">
			<% if CanEditProfile %>
				<a href="{$Link}editprofile" class="button primary radius" title="Edit profile"><strong>Edit your profile</strong> - click here <i class="icon-angle-circled-right"></i></a>
			<% else %>
				<a href="{$Link}editprofile" class="button primary radius" title="Create a profile now"><strong>Create your profile</strong> - click here <i class="icon-angle-circled-right"></i></a>
			<% end_if %>
		</div>
	</div>
</section>

<div class="formwrap">
	<div class="row">
		<div class="large-12 columns">
			<h3>Filter Profiles</h3>
			$Form
		</div>
	</div>
</div>

<div class="layout">
	<div class="row">
		<div class="large-12 columns">
	
			<article>
				$Message
				
				<div class="content">$Content</div>
				<h2>Profiles</h2>
				<% if PaginatedProfiles %>
					<% loop PaginatedProfiles %>
						<div class="panel $Gender profilepreview">
							<% if State %><a class="state" href="$Up.Link?State=$State">$State</a><% end_if %>
							<a href="$Link" title="View profile">
								<div class="row">
									<div class="small-3 columns">
										$Images.First.CroppedFromTopImage(300,300)
									</div>
									<div class="small-9 columns">
										<div class="details">
											<h3>$FirstName $LastName
												<% if IsFlyer %><span class="label radius extra">flyer</span><% end_if %>
												<% if IsBase %><span class="label radius extra">base</span><% end_if %>
												<% if TypeInterested %><span class="label secondary radius">$TypeInterested</span><% end_if %>
											</h3>
											<p>
												Hometown: <strong>$Hometown</strong>
												<% if School %><br/>School: <strong>$School</strong><% end_if %>
											</p>
											$ProfileText.Summary(20)
											<span class="$Gender"><a href="$Link" class="button radius small">View profile</a></span>
										</div>
									</div>
								</div>
							</a>
						</div>
					<% end_loop %>
					
					<% if $PaginatedProfiles.MoreThanOnePage %>
						<ul class="pagination text-centered">
						<li class="arrow <% if $PaginatedProfiles.NotFirstPage %><% else %>unavailable<% end_if %>"><a href="" class="$PaginatedProfiles.PrevLink">&laquo;</a></li>
					    
					    <% loop PaginatedProfiles.Pages %>
				            <% if $Link %>
				                <li><a href="$Link" <% if CurrentBool %>class="current"<% end_if %> >$PageNum</a></li>
				            <% else %>
				                <li class="unavailable"><a href="">&hellip;</a></li>
				            <% end_if %>
					     <% end_loop %>
					    <li class="arrow <% if $PaginatedProfiles.NotLastPage %><% else %>unavailable<% end_if %>"><a href="$PaginatedProfiles.NextLink" class="$PaginatedProfiles.PrevLink">&raquo;</a></li>
					    </ul>
					<% end_if %>
					
				<% else %>
					<p>No profiles found. Please expand your search.</p>
				<% end_if %>
			</article>
	
		</div>
	</div>
</div>