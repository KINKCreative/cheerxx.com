<% include Heading %>

<div class="layout">
	<div class="row">
		<div class="large-12 columns">
	
			<article>
				<div class="content">$Content</div>
				$Message
				<% if VideoEmbed %><div class="flex-video widescreen">$VideoEmbed.RAW</div><% end_if %>
				$Content
				<% if Profiles %>
				<% loop Profiles %>
					<div class="profile">
						<div class="row">
							<div class="large-4 columns">
								<center><div class="round-image" style="<% with Image %>background-image:url('$CroppedImage(600,600).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div></center>
							</div>
							<div class="large-8 columns">
								<h3>$Title<% if JobPosition %> <small>$JobPosition</small><% end_if %></h3>
								<p>$Text</p>
								<% if VideoEmbed %>
									<div class="flex-video widescreen">
										$VideoEmbed.RAW
									</div>
								<% end_if %>
							</div>
						</div>
					</div>
				<% end_loop %>
				<% end_if %>
				$CustomHtml.RAW
				$Form
			</article>
	
		</div>
	</div>
</div>