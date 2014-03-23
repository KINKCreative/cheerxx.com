<% with Page(open-competitions) %>
<li>
	<a href="$Link">
		<span class="th">$Image.CroppedImage(480,270)</span>
		<h4>$Title</h4>
	</a>
</li>
<% end_with %>
<% with Page(recent-winners) %>
<li>
	<a href="$Link">
		<span class="th">$Image.CroppedImage(480,270)</span>
		<h4>$Title</h4>
	</a>
</li>
<% end_with %>
<% with Page(camps) %>
<li>
	<a href="$Link">
		<span class="th">$Image.CroppedImage(480,270)</span>
		<h4>$Title</h4>
	</a>
</li>
<% end_with %>