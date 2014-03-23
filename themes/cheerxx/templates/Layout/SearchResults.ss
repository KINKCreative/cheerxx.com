<% include Heading %>
<div class="row">
	<div class="large-12 columns">
		<% if SearchResults %>
			<ul class="searchresults">
			<% control SearchResults %>
				<li>
					<h6><a href="$Link">$Title</a>
						<% if Parent %><% control Parent %><span class="label radius secondary"><a href="$Link">$Title</a></span><% end_control %><% end_if %>
					</h6>
				</li>
			<% end_control %>
			</ul>
		<% end_if %>
		$Content
		$CustomHtml.RAW
		$Form
	</div>
</div>