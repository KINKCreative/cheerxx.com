<div class="show-for-small">
<nav class="top-bar">
  <ul class="title-area">
    <!-- Title Area -->
    <li class="name">
      <h1><a href="#"><img src="$ThemeDir/images/logo-mini.png" alt="CheerXX" class="logo" /></a></h1>
    </li>
    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Left Nav Section -->
    <!-- <ul class="left">
      
      <!-- <li class="divider"></li>
      <li><a href="#">Main Item 2</a></li>
      <li class="divider"></li>
      <li class="has-dropdown"><a href="#">Main Item 3</a>

        <ul class="dropdown">
          <li class="has-dropdown"><a href="#">Dropdown Level 1a</a>

            <ul class="dropdown">
              <li><label>Dropdown Level 2 Label</label></li>
              <li><a href="#">Dropdown Level 2a</a></li>
              <li><a href="#">Dropdown Level 2b</a></li>
              <li class="has-dropdown"><a href="#">Dropdown Level 2c</a>

                <ul class="dropdown">
                  <li><label>Dropdown Level 3 Label</label></li>
                  <li><a href="#">Dropdown Level 3a</a></li>
                  <li><a href="#">Dropdown Level 3b</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Dropdown Level 3c</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown Level 2d</a></li>
              <li><a href="#">Dropdown Level 2e</a></li>
              <li><a href="#">Dropdown Level 2f</a></li>
            </ul>
          </li>
          <li><a href="#">Dropdown Level 1b</a></li>
          <li><a href="#">Dropdown Level 1c</a></li>
          <li class="divider"></li>
          <li><a href="#">Dropdown Level 1d</a></li>
          <li><a href="#">Dropdown Level 1e</a></li>
          <li><a href="#">Dropdown Level 1f</a></li>
          <li class="divider"></li>
          <li><a href="#">See all &rarr;</a></li>
        </ul>
      </li>
      <li class="divider"></li> 
    </ul> -->

	<ul class="right">
	  <li class="divider"></li>
	  <li class="active"><a href="#">Online coaching</a></li>
	  <li class="divider"></li>
	  <li class="active"><a href="#">Challenges</a></li>
	  <li class="divider"></li>
	  <li class="active"><a href="#">Online competitions</a></li>
	  <li class="divider"></li>
	  <li class="active"><a href="#">Camps</a></li>
	  <li class="divider"></li>
		<% if CurrentMember %>
		  <li class="has-dropdown">
			<a href="#">$CurrentMember.Name</a>
			<ul class="dropdown">
				<li><a href="account">Account</a></li>
				<li><a href="Security/logout">Log out</a></li>
			</ul>
		  </li>
		<% else %>
		  <li><a href="register">Sign up</a></li>
		  <li><a href="Security/login">Login</a></li>
		  <li class="divider"></li>
		<% end_if %>
	</ul>
	
    <!-- Right Nav Section
    <ul class="right">
      <li class="divider hide-for-small"></li>
      <li class="has-dropdown"><a href="#">Main Item 4</a>

        <ul class="dropdown">
          <li><label>Dropdown Level 1 Label</label></li>
          <li class="has-dropdown"><a href="#" class="">Dropdown Level 1a</a>

            <ul class="dropdown">
              <li><a href="#">Dropdown Level 2a</a></li>
              <li><a href="#">Dropdown Level 2b</a></li>
              <li class="has-dropdown"><a href="#">Dropdown Level 2c</a>

                <ul class="dropdown">
                  <li><a href="#">Dropdown Level 3a</a></li>
                  <li><a href="#">Dropdown Level 3b</a></li>
                  <li><a href="#">Dropdown Level 3c</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown Level 2d</a></li>
              <li><a href="#">Dropdown Level 2e</a></li>
              <li><a href="#">Dropdown Level 2f</a></li>
            </ul>
          </li>
          <li><a href="#">Dropdown Level 1b</a></li>
          <li><a href="#">Dropdown Level 1c</a></li>
          <li class="divider"></li>
          <li><label>Dropdown Level 1 Label</label></li>
          <li><a href="#">Dropdown Level 1d</a></li>
          <li><a href="#">Dropdown Level 1e</a></li>
          <li><a href="#">Dropdown Level 1f</a></li>
          <li class="divider"></li>
          <li><a href="#">See all &rarr;</a></li>
        </ul>
      </li>
      <li class="divider"></li>
      <li class="has-form">
        <form>
          <div class="row collapse">
            <div class="small-8 columns">
              <input type="text">
            </div>
            <div class="small-4 columns">
              <a href="#" class="alert button">Search</a>
            </div>
          </div>
        </form>
      </li>
      <li class="divider show-for-small"></li>
      <li class="has-form">
        <a class="button" href="#">Button!</a>
      </li>
    </ul> -->
  </section>
</nav>
</div>