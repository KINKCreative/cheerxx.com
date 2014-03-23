<div class="bottomsection">
	<div class="row">
		<div class="large-12 columns">
			<ul class="large-block-grid-6 medium-block-grid-3">
			<% loop Menu(1) %>
				<li>
					<h3><a href="$Link">$Title</a></h3>
					<ul class="side-nav">
						<% loop Children %>
							<li><a href="$Link">$Title</a></li>
						<% end_loop %>
					</ul>
				</li>
			<% end_loop %>
		</ul>
	</div>
</div>

<footer>
	<div class="row">
		<div class="large-12 columns">
			&copy; <strong>CheerXX</strong>.com 
		</div>
	</div>
</footer>