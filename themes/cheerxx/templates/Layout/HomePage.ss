<!-- <section class="header" style="background: #000 url(http://www.lorempixel.com/1800/300) no-repeat top center; height: 300px;" data-speed="10" data-type="background"></section> -->

<div class="layout">
<!-- STAFF PICKS - PROJECT -->

<section class="row main">
	<div class="large-12 columns">
		
		$Message
		
		<ul class="large-block-grid-3 blockgrid">
			<% with Page(coaching) %>
			<li>
				<a href="$Link">
					<span class="th">$Image.CroppedImage(480,270)</span>
					<h4>$Title</h4>
				</a>
			</li>
			<% end_with %>
			<li>
				<a href="competitions">
					<% with RandomSuperChallenge %>
						<span class="th">$Images.First.Image.CroppedImage(480,270)</span>
					<% end_with %>
					<h4>Online competitions</h4>
				</a>
			</li>
			<% with Page(recruiting) %>
			<li>
				<a href="$Link">
					<span class="th">$Image.CroppedImage(480,270)</span>
					<h4>$Title</h4>
				</a>
			</li>
			<% end_with %>
		</ul>
</section>

<section class="tips bluebackground">
	<div class="row main"
		<div class="large-12 columns">
			<div class="text-center">
				<span class="tiptag"><i class="icon-ok-circled"></i></span>
				<h4>Tip of the day</h4>
				<ul class="tipoftheday" data-orbit data-options="timer:false;bullets:false;slide_number:false;" >
					<% loop RecentTips %>
					<li>
						<div>
							<h3>$Title</h3>
							<p>$Content</p>
							<p><small>$From</small></p>
						</div>
					</li>
					<% end_loop %>
				</ul>
			</div>
		</div>
	</div>
</section>

<p><center><br/><br/><small>Professional photography courtesy of <a href="https://www.facebook.com/DrMikePhotography/photos_stream" target="_blank">Dr. Michael Huang Photography</a></small></center></p>

</div><!-- END LAYOUT -->


