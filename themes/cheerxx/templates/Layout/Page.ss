<% include Heading %>

<div class="layout">
	<div class="row">
		<div class="large-12 columns">
	
			<article>
				<div class="content">
					<% if Image %><div class="round-image round-large right" style="<% with Image %>background-image:url('$CroppedImage(600,600).URL');"><% end_with %><img src="$ThemeDir/images/blank.png" class="blank" /></div>
					<% end_if %>
					$Content
					<% if Children %>
					<h3>Subpages</h3>
					<ul class="large-block-grid-3 blockgrid">
						<% loop Children %>
						<li>
							<a href="$Link">
								<span class="th">$Image.CroppedImage(480,270)</span>
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
	</div>
</div>