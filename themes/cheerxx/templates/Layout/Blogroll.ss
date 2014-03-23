<div class="row layout">

	<div class="large-3 push-9">
		<% include BlogSideBar %>
	</div>
	
	<div class="large-9 columns pull-3">
		<div class="maincontent">
		<h2>$Title</h2>
		$Content
		</div>
			<% if Blogroll %>
			<% control Blogroll %>
				<div class="article">
					<h3><a href="$Link">$Title</a></h3>
					<h6><% _t('POSTED', 'Posted') %> <% if Author %> <% _t('BY', 'by') %> $Author.Name<% end_if %> <% _t('POSTEDIN','in') %> <% control Blogroll %><a href="$Link">$Title</a><% end_control %> <% _t('POSTEDON', 'on') %> $Created.Date</h6>
					<% include Images %>
					<% if VideoEmbed %><div class="flex-video widescreen">$VideoEmbed.RAW</div><% end_if %>
					<div class="details">
						<% if Content %>
				         <p class="summary">$Content.Summary</p>
						<% end_if %>
					<!-- Soc Net BEGIN -->	
						<a href="https://twitter.com/share" class="twitter-share-button" data-text="Look what I found!! $AbsoluteLink" data-via="LeauxStandards" data-count="none" data-hashtags="LeauxStandards" data-url="$AbsoluteLink" >Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
						<div class="fb-like" data-href="$AbsoluteLink" data-width="400" data-show-faces="false" data-send="true"></div>
				    <!-- Soc Net END -->
					</div>
					<% if Last %>
					<% else %><hr /><% end_if %>
				</div>
			<% end_control %>
			
			<% if Blogroll.MoreThanOnePage %> 
				<ul class="pagination">
					<% if Blogroll.PrevLink %> 
				  		<li class="arrow"><a href="$Visuals.PrevLink"><i class="icon-left-open-big"></i></a></li>
				  	<% else %>
				  		<li class="arrow unavailable"><a href=""><i class="icon-left-open-big"></i></a></li>
				  	<% end_if %>
				  	
				  	<% control Blogroll.PaginationSummary(9) %>
				  		<% if CurrentBool %>
				 			<li class="current round"><a href="#">$PageNum</a></li>
				 		<% else %>
				 			<% if Link %>
				 				<li><a href="$Link">$PageNum</a></li>
				 			<% else %>
				 				<li class="unavailable"><a href="">&hellip;</a></li>
				 			<% end_if %>
				 		<% end_if %>
				 	<% end_control %>
				 	
				 	<% if Blogroll.NextLink %> 
				 		<li class="arrow"><a href="$Visuals.NextLink"><i class="icon-right-open-big"></i></a></li>
				 	<% else %>
				 		<li class="arrow unavailable"><a href=""><i class="icon-right-open-big"></i></a></li>
				 	<% end_if %>
				 </ul>
			<% end_if %>
			<% end_if %>
			<div class="maincontent">
			<% include FacebookComments %>
			</div>
	</div>

</div>