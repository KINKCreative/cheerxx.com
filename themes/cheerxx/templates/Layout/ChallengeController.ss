<!-- <section class="header" style="background: #000 url(http://www.lorempixel.com/1800/300) no-repeat top center; height: 300px;" data-speed="10" data-type="background"></section> -->


<div class="layout">

<section class="row main" data-speed="5" data-type="background">
	<div class="large-12 columns">
		
		<h1><strong>CheerXX</strong> $Title</h1>
		
		<!--<h3>Ongoing competitions</h3> -->
		<ul class="large-block-grid-3 blockgrid">
			<% loop getSuperChallenges %>
			<li>
				<a href="$Link">
					<% if Images %>
						<span class="th"><% with Images.First.Image %>$CroppedImage(480,270)<% end_with %></span>
					<% else %>
						<img src="http://placehold.it/480x270/EEEEEE&text=+" />
					<% end_if %>
					<h5>$Title</h5>
				</a>
			</li>
			<% end_loop %>
		</ul>
</section>

</div>



