<div class="row">
<div class="large-12 columns">

<h1>$Title</h1>

<div class="row">
	<div class="large-8 columns">
		$Content
		$CustomHtml.RAW
		$Form
	</div>
	<div class="large-4 columns">
		
		<div class="accountnav sidebar">
					<h2>My Account</h2>
					<ul class="side-nav ">
						<li class="$LinkingMode"><a href="$Link"><i class="icon icon-doc-text"></i> Past Orders</a></li>
						<li class="$LinkingMode"><a href="$Link(editprofile)"><i class="icon icon-user"></i> Edit Profile</a></li>
						<li class="$LinkingMode"><a href="$Link(addressbook)"><i class="icon icon-truck"></i> Address Book</a></li>
					</ul>
				<div class="panel">	
					<% control Member %>
						<dl>
							<dt>Name</dt><dd>$Name</dd>
							<dt>Email</dt><dd>$Email</dd>
							<dt>Member Since</dt> <dd>$Created.Nice</dd>
							<dt>Last Visit</dt> <dd>$LastVisited.Nice</dd>
							<dt>Number of orders</dt> <dd><% if PastOrders %>$PastOrders.Count<% else %>0<% end_if %></dd>
						</dl>
					<% end_control %>
				</div>
				<a></a>
				<a href="Security/logout" class="button secondary small"><i class="icon icon-off"></i> Log Out</a>
		</div>
		
	</div>
</div>

</div>
</div>