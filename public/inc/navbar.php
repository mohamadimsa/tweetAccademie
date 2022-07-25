<body style="background-color: <?=$_SESSION['theme']?>">
	<div class="row">		
		<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between fixed-top" data-spy="affix" data-offset-top="197">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<ul class="inf navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item"><a class="nav-link" href="/Twitter">Home</a></li>
					<li class="nav-item"><a class="nav-link" href="/Twitter/mentions">Mentions</a></li>
					<li class="nav-item"><a class="nav-link" id="msgLink" data-toggle="modal" data-target="#messageModal" href="#">Messages</a></li>
				</ul>
				<img src="/Twitter/public/img/birdie.png" alt="logo" width="35" height="35" class="d-inline-block align-top">
				<form class="form-inline my-2 my-lg-0" id="formSearch">
					<div class="dropdown">
					<input id="searchHome" class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
					<ul id="searchComp"></ul>
					</div>
				</form>
				<button type="button" id="logout" name="logout" value="logout" class="btn btn-primary">Log Out</button>
			</div>
		</nav>
	</div>
	<div class="clearfix"></div>