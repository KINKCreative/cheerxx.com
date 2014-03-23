<ul class="inline-list mainmenu">
	<li><a href="coaching"><small>online</small><i class="icon-thumbs-up"></i>coaching</a></li>
	<li><a href="competitions"><small>online</small><i class="icon-star"></i>Competitions</a></li>
	
	<!-- <li><a href="camps"><small>cheer</small><i class=" icon-globe"></i>Camps</a></li> -->
	<li><a href="recruiting"><small>cheerleader</small><i class="icon-user"></i>Recruiting</a></li>
	<!-- <li><a href="$Link"><small>rent</small>Equipment<i class="icon-angle-right"></i></a></li>
	<li><a href="$Link"><small>company</small>Directory<i class="icon-angle-right"></i></a></li>
	<li><a href="$Link"><small>let's go</small>Local</a><i class="icon-angle-right"></i></li> -->
</ul>

<dl class="sub-nav hide-for-small">
	<% if CurrentMember %>
		<!-- <dt>Hello, <strong>$CurrentMember.Name</strong></dt> -->
		<dd><a href="upload" class="button round alert"><i class="icon-upload-cloud"></i> Upload video</a></dd>
		<dd><a href="register"><i class="icon-lock-open-alt"></i>Account</a></dd>
		<dd><a href="recruiting/editprofile"><i class="icon-user"></i>Profile</a></dd>
		<dd><a href="Security/logout"><i class="icon-off"></i>Logout</a></dd>
	<% else %>
		<dd><a href="register">Sign up</a></dd>
		<dd><a href="Security/login?BackURL=$Link">Login</a></dd>		
		<dd><a href="upload" class="button round alert"><i class="icon-upload-cloud"></i> Upload video</a></dd>
	<% end_if %>
</dl>