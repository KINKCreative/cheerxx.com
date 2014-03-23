<% if Images %>
<% if ImageCount==1 %>
	<% loop Images.First %>$Image.GreyPaddedImage(900,540)
	<% if Caption %><p><center><em>$Caption</em></center></p><% end_if %>
	<% end_loop %>
<% else %>
	<ul data-orbit>
		<% loop Images %>
		<li>
	    	$Image.GreyPaddedImage(900,540)
	    	<% if Caption %><div class="orbit-caption">$Caption</div><% end_if %>
	  	</li>
	  	<% end_loop %>
	</ul>
<% end_if %>
<% end_if %>