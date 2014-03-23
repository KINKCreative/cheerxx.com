<div class="row layout">

	<div class="large-3 push-9">
		<% include BlogSideBar %>
	</div>
	
	<div class="large-9 columns pull-3">
		$Image.SetWidth(1000,600)
		
		<div class="maincontent panel">
			<h2>$Title</h2>
			<% control Item %>
				<p class="articledate"><% _t('POSTED', 'Posted') %> <% if Author %> <% _t('BY', 'by') %> <strong>$Author.Name</strong><% end_if %> <% _t('POSTEDON', 'on') %> <strong>$Created.Date</strong></p>
				<% if VideoEmbed %>
				<div class="player">
					<div class="flex-video widescreen">$VideoEmbed.RAW</div>
				</div>
				<% end_if %>
			<% end_if %>
			<% include Images %>
			$Message
			$Content
			$CustomHtml.RAW
			$Form
			<!-- Soc Net BEGIN -->	
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="Look what I found!!" data-via="LeauxStandards" data-count="none" data-hashtags="LeauxStandards">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				<div class="fb-like" data-href="http://www.LeauxStandards.com" data-width="450" data-show-faces="true" data-send="true"></div>
		    <!-- Soc Net END -->
			<% include FacebookComments %>
		</div>
		
	</div>

</div>