<% include Heading %>

<div class="layout">
	<div class="row">
		<div class="medium-8 columns">
	
			<article>
				<div class="content">					$Content
					<% if Children %>
					<h3>Subpages</h3>
					<ul class="large-block-grid-5 blockgrid">
						<% loop Children %>
						<li class="subpage">
							<a href="$Link">
								<% if Image %>
									<div class="round-image" style="<% with Image %>background-image:url('$CroppedImage(600,600).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div><% end_if %>
								<h4>$Title</h4>
							</a>
						</li>
						<% end_loop %>
					</ul>
					<hr/>
					<% end_if %>
					$CustomHtml.RAW
				</div>
				<% if Form %>
				<div class="large-8 large-centered columns">
					$Form
				</div>
				<% end_if %>
			</article>
	
		</div>
		<div class="medium-4 columns">
			<% if Image %><div class="round-image round-large" style="<% with Image %>background-image:url('$CroppedImage(600,600).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div>
			<% end_if %>
		</div>
	</div>
</div>