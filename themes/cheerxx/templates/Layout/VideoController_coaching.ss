<section class="header">
	<div class="row">
	<div class="large-12 columns">
		<% with Item %>
		<div class="row">
			<div class="large-8 columns">
				<div class="flex-video widescreen">
					<div class="video">
						<iframe allowFullScreen allowTransparency="true" class="vzaar-video-player" frameborder="0" height="432" id="player" mozallowfullscreen name="vzvd" src="http://view.vzaar.com/{$VzaarID}/player" title="vzaar video player" type="text/html" webkitAllowFullScreen width="768"></iframe>
					</div>
				</div>
			</div>
			<div class="medium-12 large-4 columns">
				<div class="row">
					<div class="large-12 medium-6 small-12 small-center columns">
						<div class="small-center"><img src="http://www.placehold.it/300x250"  /></div>
					</div>
					<div class="large-12 medium-6 small-12 columns">
						<p></p>
						<h4>
							<i class="icon-eye"></i> <strong class="views"><span class="playCount"></span></strong>  <i class="icon-thumbs-up"></i> <span class="noLikes">$LikeTotal</span>   <i class="icon-heart"></i> <span class="favorites"><span class="noFavorites">$FavoriteTotal</span></span>
						</h4>
						<p>
							<% if Member.CurrentUserID %>
								<a href="#" class="button radius nopadding like <% if UserLikes %>likes primary<% else %>secondary<% end_if %>" data-id="$ID"><i class="icon-thumbs-up"></i>Like </a>
								<a href="#" class="button favorite radius nopadding <% if UserFavorite %>isfavorite alert<% else %>secondary<% end_if %>" alt="Add to favorites" data-id="$ID"><i class="icon-heart"></i><span> Favorite</span></a><br/>
							<% else %>
								<a href="Security/login?BackURL={$Link}">Log in to like this video</a>
							<% end_if %>
						</p>
						<% include AddThis %>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>

<div class="layout">
	<div class="row main">
		<div class="large-8 columns">
			$Top.Message
			<h2 class="sshadow">$Title <small>($ID)</small></h2>
			<p>
				Submitted <strong>$Created.Ago</strong> by <strong><a href="$Link">$Member.Username</a></strong><br/>
			<!-- <p><strong>Published on $Created.Long</strong><br/> -->
			<small>Coaching submission</small></p>

			$Top.CoachingForm
			<!-- <p>Vivamus a neque adipiscing, tincidunt erat quis, interdum tortor. Ut faucibus lectus ac mattis aliquam. In hac habitasse platea dictumst. Nunc at justo eget eros lacinia convallis id a lorem. Pellentesque dapibus id nunc eu iaculis. Donec placerat eros ac metus placerat, ac condimentum nibh congue.</p> -->
			
		<% end_with %>
			<% include Comments %>
		</div>
		<div class="large-4 columns">
			$Top.ScoreBox
		</div>	
			
	</div>
</div>